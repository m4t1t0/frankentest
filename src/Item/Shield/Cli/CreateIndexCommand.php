<?php

declare(strict_types=1);

namespace App\Item\Shield\Cli;

use App\Item\Shield\Persistence\RedisItemRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:create-index')]
class CreateIndexCommand extends Command
{
    public function __construct(
        private RedisItemRepository $repository,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Create the item index')
            ->setHelp('This command create the index for items.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->repository->createSearchIndex();

        $output->writeln('Index created sucessfully.');

        return Command::SUCCESS;
    }
}

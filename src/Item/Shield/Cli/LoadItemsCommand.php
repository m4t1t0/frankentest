<?php

declare(strict_types=1);

namespace App\Item\Shield\Cli;

use App\Item\Core\Aggregate\Item\ValueObjects\Location;
use App\Item\Core\Command\Add\AddItemCommand;
use App\Shared\Core\Bus\CommandBusInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Faker\Factory;

#[AsCommand(name: 'app:load-items')]
class LoadItemsCommand extends Command
{
    private const int MAX_NUMBER_OF_ITEMS = 1000;

    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Load a lot of fake items.')
            ->setHelp('This command allows you load a lot of fake items.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::MAX_NUMBER_OF_ITEMS; $i++) {
            $this->commandBus->handle(
                new AddItemCommand(
                    id: $faker->uuid(),
                    name: $faker->text(20),
                    description: $faker->text(50),
                    location: $faker->randomElement(Location::AVAILABLE_LOCATIONS),
                    quantity: $faker->randomDigitNotZero(),
                    price: $faker->randomFloat(2, 10, 100),
                )
            );

            $output->writeln('Item ' . $i + 1 . ' added.');
        }

        return Command::SUCCESS;
    }
}

<?php

declare(strict_types=1);

namespace Tests\Support\Helper;

use Redis;
use Codeception\Lib\ModuleContainer;
use \Codeception\Module;
use \Codeception\TestInterface;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Tests\Support\Helper\Domain\Item\Item;
use Tests\Support\Helper\Domain\Item\ItemRepository;
use Tests\Support\Helper\Domain\Event\Event;
use Tests\Support\Helper\Domain\Event\EventRepository;

class DbHelper extends Module
{
    private Redis $redisWrite;
    private Redis $redisRead;

    public function __construct(ModuleContainer $moduleContainer, ?array $config = null)
    {
        $this->redisWrite = RedisAdapter::createConnection($config['connections']['writes']['dsn']);
        $this->redisRead = RedisAdapter::createConnection($config['connections']['reads']['dsn']);
        parent::__construct($moduleContainer, $config);
    }

    public function _before(TestInterface $test): void
    {
        $this->flushAllDbs();
    }

    public function flushAllDbs(): void
    {
        $this->redisWrite->flushDB();
        $this->redisRead->flushDB();
    }

    public function seeEventExists(string $aggregateRootId, string $type): bool
    {
        $key = 'es_events_' . $aggregateRootId;

        if (!$this->redisWrite->exists($key)) {
            return false;
        }

        $events = $this->redisWrite->lRange($key, 0, -1);
        foreach ($events as $event) {
            $decodedEvent = json_decode($event, true);

            if ($decodedEvent['headers']['__event_type'] === $type) {
                return true;
            }
        }

        return false;
    }

    public function seeInReadDatabase(string $prefix, string $aggregateRootId): bool
    {
        return (bool)$this->redisRead->exists($prefix . '_' . $aggregateRootId);
    }

    public function haveItem(Item $item): void
    {
        $itemRepository = new ItemRepository($this->redisRead);
        $itemRepository->insertItem($item);
    }

    public function haveEvent(Event $event): void
    {
        $eventRepository = new EventRepository($this->redisWrite);
        $eventRepository->insertEvent($event);
    }
}

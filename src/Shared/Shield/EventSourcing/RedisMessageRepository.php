<?php

declare(strict_types=1);

namespace App\Shared\Shield\EventSourcing;

use Generator;
use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\Header;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageRepository;
use EventSauce\EventSourcing\Serialization\MessageSerializer;
use EventSauce\EventSourcing\Serialization\ConstructingMessageSerializer;
use EventSauce\EventSourcing\PaginationCursor;
use Redis;
class RedisMessageRepository implements MessageRepository
{
    private Redis $redis;
    private MessageSerializer|ConstructingMessageSerializer $serializer;

    public function __construct(
        Redis $redis,
        MessageSerializer $serializer = null
    ) {
        $this->redis = $redis;
        $this->serializer = $serializer ?: new ConstructingMessageSerializer();
    }

    public function persist(Message ... $messages): void
    {
        foreach ($messages as $message) {
            $aggregateRootId = $message->header(Header::AGGREGATE_ROOT_ID);
            $payload = $this->serializer->serializeMessage($message);

            $this->redis->set($aggregateRootId->toString(), json_encode($payload));
        }
    }

    public function retrieveAll(AggregateRootId $id): Generator
    {
        $directory = __DIR__ . '/' . $id->toString();

        if (!is_dir($directory)) {
            return 0;
        }

        foreach (array_diff(scandir($directory), array('..', '.')) as $file) {
            $message = $this->serializer->unserializePayload(
                json_decode(
                    file_get_contents($directory.'/'.$file),
                    true
                )
            );

            yield $message;
        }

        return isset($message) ? $message->header(Header::AGGREGATE_ROOT_VERSION) : 0;
    }
    public function retrieveAllAfterVersion(AggregateRootId $id, int $aggregateRootVersion): Generator
    {
        $directory = __DIR__.'/'.$id->toString();

        if ( ! is_dir($directory)) {
            return 0;
        }

        foreach (array_diff(scandir($directory), array('..', '.')) as $file) {
            if ($aggregateRootVersion >= (int) $file) continue;

            $message = $this->serializer->unserializePayload(
                json_decode(
                    file_get_contents($directory.'/'.$file),
                    true
                )
            );

            yield $message;
        }

        return isset($message) ? $message->header(Header::AGGREGATE_ROOT_VERSION) : 0;
    }

    public function paginate(PaginationCursor $cursor): Generator
    {
        // TODO: Implement paginate() method.
    }
}

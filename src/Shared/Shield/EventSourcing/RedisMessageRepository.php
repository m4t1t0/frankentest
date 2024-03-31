<?php

declare(strict_types=1);

namespace App\Shared\Shield\EventSourcing;

use App\Shared\Core\Services\JsonWrapperInterface;
use App\Shared\Shield\Redis\RedisClientInterface;
use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\Header;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageRepository;
use EventSauce\EventSourcing\PaginationCursor;
use EventSauce\EventSourcing\Serialization\ConstructingMessageSerializer;
use EventSauce\EventSourcing\Serialization\MessageSerializer;
use EventSauce\EventSourcing\UnableToRetrieveMessages;
use EventSauce\EventSourcing\OffsetCursor;
use Generator;
use LogicException;
use Throwable;

class RedisMessageRepository implements MessageRepository
{
    private const string EVENTS_PREFIX = 'es_events';

    private RedisClientInterface $redis;
    private MessageSerializer|ConstructingMessageSerializer $serializer;
    private JsonWrapperInterface $jsonWrapper;

    public function __construct(
        RedisClientInterface $redis,
        JsonWrapperInterface $jsonWrapper,
        MessageSerializer $serializer = null,
    ) {
        $this->redis = $redis;
        $this->jsonWrapper = $jsonWrapper;
        $this->serializer = $serializer ?: new ConstructingMessageSerializer();
    }

    public function persist(Message ... $messages): void
    {
        foreach ($messages as $message) {
            $aggregateRootId = $message->header(Header::AGGREGATE_ROOT_ID);
            $payload = $this->serializer->serializeMessage($message);

            $this->redis->rpush(
                key: static::EVENTS_PREFIX . '_' . $aggregateRootId->toString(),
                value: $this->jsonWrapper->encode($payload),
            );
        }
    }

    public function retrieveAll(AggregateRootId $id): Generator
    {
        $key = static::EVENTS_PREFIX . '_' . $id->toString();

        if (! $this->redis->exists($key)) {
            return 0;
        }

        $payloads = $this->redis->lrange($key);
        try {
            return $this->yieldMessagesFromPayloads($payloads);
        } catch (Throwable $exception) {
            throw UnableToRetrieveMessages::dueTo('', $exception);
        }
    }
    public function retrieveAllAfterVersion(AggregateRootId $id, int $aggregateRootVersion): Generator
    {
        $key = static::EVENTS_PREFIX . '_' . $id->toString();

        if (! $this->redis->exists($key)) {
            return 0;
        }

        $allPayloads = $this->redis->lrange($key);
        $payloads = [];
        foreach ($allPayloads as $payload) {
            $decodedPayload = $this->jsonWrapper->decode($payload);
            $version = (int)$decodedPayload['version'];

            if ($version <= $aggregateRootVersion) {
                continue;
            }

            $payloads[] = $payload;
        }

        try {
            return $this->yieldMessagesFromPayloads($payloads);
        } catch (Throwable $exception) {
            throw UnableToRetrieveMessages::dueTo('', $exception);
        }
    }

    public function paginate(PaginationCursor $cursor): Generator
    {
        if (!$cursor instanceof OffsetCursor) {
            throw new LogicException(sprintf('Wrong cursor type used, expected %s, received %s', OffsetCursor::class, get_class($cursor)));
        }

        $numberOfMessages = 0;

        $keys = $this->redis->keys(static::EVENTS_PREFIX . '*');
        try {
            for ($i = $cursor->offset(); $i < $cursor->limit(); $i++) {
                $numberOfMessages++;
                $payload = $this->redis->lrange($keys[$i])[$i];
                yield $this->serializer->unserializePayload($this->jsonWrapper->decode($payload));
            }
        } catch (Throwable $exception) {
            throw UnableToRetrieveMessages::dueTo($exception->getMessage(), $exception);
        }

        return $cursor->plusOffset($numberOfMessages);
    }

    /**
     * @psalm-return Generator<Message>
     */
    private function yieldMessagesFromPayloads(iterable $payloads): Generator
    {
        foreach ($payloads as $payload) {
            yield $message = $this->serializer->unserializePayload($this->jsonWrapper->decode($payload));
        }

        return isset($message)
            ? $message->header(Header::AGGREGATE_ROOT_VERSION) ?: 0
            : 0;
    }
}

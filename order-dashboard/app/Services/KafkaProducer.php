<?php

namespace App\Services;

use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
use Junges\Kafka\Message\Serializers\JsonSerializer;
use Psr\Log\LoggerInterface;

class KafkaProducer
{
    public function __construct(
        private readonly LoggerInterface $logger,
    ) {}

    public function sendMessage(string $topic, array $data): bool
    {
        try {
            $message = new Message(
                topicName: $topic,
                body: $data,
            );

            Kafka::publish()
                ->onTopic($topic)
                ->withMessage($message)
                ->usingSerializer(new JsonSerializer())
                ->send();
        } catch (\Throwable $t) {
            dd($t);
            $this->logger->error('[KafkaProducer][SendMessage]', [
                'topic' => $topic,
                'error' => $t->getMessage(),
                'trace' => $t->getTraceAsString(),
                'line' => $t->getLine(),
            ]);

            return false;
        }

        return true;
    }
}

<?php

namespace App\Services;

use App\Builder\KafkaMessage\OrderCreated;
use Illuminate\Support\Facades\DB;
use App\Models\Order as OrderModel;
use Psr\Log\LoggerInterface;

class Order
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly KafkaProducer $kafkaProducer,
    ) {}

    public function store($products): bool
    {
        DB::beginTransaction();

        try {
            $order = OrderModel::create();

            foreach ($products as $product) {
                $order->orderItems()->create([
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                ]);
            }

            DB::commit();

            $kafkaStatus = $this
                ->kafkaProducer
                ->sendMessage(OrderCreated::TOPIC_NAME, (new OrderCreated())->generateMessage($order));

            if (!$kafkaStatus) {
                dd('bam bam bam');
                $this->logger->warning('[OrderService][Store][SendKafka]', [
                    'order_id' => $order->id,
                    'message' => 'Failed to send message to Kafka',
                ]);
            }
        } catch (\Exception $e) {
            dd(
                $e
            );
            DB::rollback();
            $this->logger->error('[OrderService][Store]', [
                'data' => $products,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'line' => $e->getLine(),
            ]);

            return false;
        }

        return true;
    }
}
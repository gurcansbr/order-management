<?php

namespace App\Builder\KafkaMessage;

use App\Models\Product;

class OrderCreated
{
    const TOPIC_NAME = 'order_created';

    public function generateMessage($order)
    {
        $orderItems = $order->orderItems()->with('product')->get();
        $message = [
            'order_id' => $order->id,
            'created_at' => $order->created_at,
        ];

        foreach ($orderItems as $orderItem) {
            $product = Product::with('price')->find($orderItem->product->id);

            $message['items'][] = [
                'product_id' => $orderItem->product->id,
                'product_name' => $orderItem->product->name,
                'quantity' => (int) $orderItem->quantity,
                'price' => [
                    'base' => (float) $product->price->base,
                    'tax_rate' => (float) $product->price->tax_rate,
                    'discount_rate' => (float) $product->price->discount_rate,
                    'currency' => $product->price->currency,
                ],
            ];
        }

        return $message;
    }
}
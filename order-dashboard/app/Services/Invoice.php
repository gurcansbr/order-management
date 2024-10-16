<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Invoice
{
    public function fetchInvoices(): ?array
    {
        $response = Http::get(env('INVOICE_API_URL').'api/invoice');
        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    public function fetchInvoice(string $id): ?array
    {
        $response = Http::get(env('INVOICE_API_URL').'api/invoice/'.$id);
        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}

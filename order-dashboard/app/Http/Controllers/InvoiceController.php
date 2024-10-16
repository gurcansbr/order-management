<?php

namespace App\Http\Controllers;

use App\Services\Invoice as InvoiceService;

class InvoiceController extends Controller
{
    public function __construct(
        private readonly InvoiceService $invoiceService
    ) {}

    public function index()
    {
        $invoices = $this->invoiceService->fetchInvoices();
        return view('invoices.index', compact('invoices'));
    }

    public function show($id)
    {
        $invoice = $this->invoiceService->fetchInvoice($id);
        return view('invoices.show', compact('invoice'));
    }
}

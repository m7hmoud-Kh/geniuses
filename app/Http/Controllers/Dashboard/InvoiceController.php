<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Invoice\StoreInvoiceRequest;
use App\Mail\InvoiceMail;
use App\Models\Invoice;
use App\Services\Models\InvoiceModel;
use App\Services\Utils\StripePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{

    public $invoiceModel;
    public function __construct(InvoiceModel $invoiceModel)
    {
        $this->invoiceModel = $invoiceModel;
    }

    public function index()
    {
        //index
        return $this->invoiceModel->getAllIvoices();

    }

    public function store(StoreInvoiceRequest $request, StripePayment $stripe)
    {
        $invoiceData = $this->invoiceModel->storeInvoice($request, $stripe);
        Mail::to($request->email)->send(new InvoiceMail($invoiceData));
        return response()->json([
            'message' => 'mail Send Successfully'
        ]);
    }

    public function destroy(Invoice $invoice)
    {
        return $this->invoiceModel->destoryInvoice($invoice);
    }
}

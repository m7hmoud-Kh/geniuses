<?php

namespace App\Services\Models;

use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Services\Utils\Paginatable;
use App\Services\Utils\StripePayment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoiceModel extends Model
{

    use Paginatable;

    public function getAllIvoices()
    {
        $invoices = Invoice::latest()->paginate();
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => InvoiceResource::collection($invoices),
            'meta' => $this->getPaginatable($invoices)
        ]);
    }

    public function storeInvoice(Request $request, StripePayment $stripe)
    {
        $invoice = Invoice::create($request->validated());
        $url = $stripe->createPaymentLink($invoice);
        return [
            'url' => $url,
            'invoice' => $invoice
        ];
    }

    public function destoryInvoice($invoice)
    {
        $invoice->delete();
        return response()->json([],Response::HTTP_NO_CONTENT);
    }
}

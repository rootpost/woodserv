<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Counter;
use App\Models\InvoiceItem;

class InvoiceController extends Controller
{
    //
    

    // API methods
    public function get_all_invoice()
    {
        $invoices = Invoice::with('customer')->orderBy('id', 'DESC')->get();
        return response()->json([
            'invoices' => $invoices
        ], 200);
    }

    public function search_invoice(Request $request)
    {
        $search = $request->get('s');
        if ($search != null){
            //$invoices = Invoice::where('id', 'LIKE', "%$search%")->get();
            $invoices = Invoice::with(['customer', 'invoice_items.product'])->where('total', 'LIKE', "%$search%")->get();
            return response()->json([
                'invoices' => $invoices
            ], 200);
        }else{
            return $this->get_all_invoice();
        }
    }

    public function create_invoice(Request $request)
    {
        $counter = Counter::where('key', 'invoice')->first();
        //$random = Counter::where('key', 'invoice')->first();

        $invoice = Invoice::orderBy('id', 'DESC')->first();
        if($invoice){
            $invoice = $invoice->id + 1;
            $counters = $counter->value + $invoice;
        }else{
            $counters = $counter->value;
        }

        $formData = [
            'number' => $counters,
            'customer_id' => null,
            'customer' => null,
            'date' => date('Y-m-d'),
            'due_date' => null,
            'reference' => 'нет',
            'discount' => 0,
            'terms_and_conditions' => 'Стандартные условия и положения',
            'items' => [
                [
                    'product_id' => null,
                    'product' => null,
                    'quantity' => 1,
                    'price' => 0,
                ]
            ]
        ];
        return response()->json($formData);
    }

    public function add_invoice(Request $request)
    {
        $invoiceitem = $request->input("invoice_item");

        $invoicedata['customer_id'] = $request->input("customer_id");
        $invoicedata['number'] = $request->input("number");
        $invoicedata['date'] = $request->input("date");
        $invoicedata['due_date'] = $request->input("due_date");
        $invoicedata['sub_total'] = $request->input("sub_total");
        $invoicedata['discount'] = $request->input("discount");
        $invoicedata['total'] = $request->input("total");
        $invoicedata['reference'] = $request->input("reference");
        $invoicedata['terms_and_conditions'] = $request->input("terms_and_conditions");
        $invoicedata['status'] = $request->input("status");

        $invoice = Invoice::create($invoicedata);

        foreach(json_decode($invoiceitem) as $item){
            $itemdata['invoice_id'] = $invoice->id;
            $itemdata['product_id'] = $item->id;
            $itemdata['quantity'] = $item->quantity;
            $itemdata['price'] = $item->price;

            InvoiceItem::create($itemdata);
        }
    }

    public function show_invoice($id) {
        $invoice = Invoice::with(['customer', 'invoice_items.product'])->find($id);
        return response()->json([
            'invoice' => $invoice
        ], 200);
    }

    public function edit_invoice($id) {
        $invoice = Invoice::with(['customer', 'invoice_items.product'])->find($id);
        //$invoice = Invoice::with('customer')->find($id);
        //$invoiceItems = Invoice::with('invoice_items.product')->find($id);
        return response()->json([
            'invoice' => $invoice,
            //'invoice_items_2' => $invoiceItems
        ], 200);
    }

    public function delete_invoice_items($id) {
        $invoiceitem = InvoiceItem::findOrFail($id);
        $invoiceitem->delete();
    }

    public function update_invoice(Request $request, $id) {
        $invoice = Invoice::where('id', $id)->first();

        $invoice->customer_id = $request->customer_id;
        $invoice->number = $request->number;
        $invoice->date = $request->date;
        $invoice->due_date = $request->due_date;
        $invoice->sub_total = $request->sub_total;
        $invoice->discount = $request->discount;
        $invoice->total = $request->total;
        $invoice->reference = $request->reference;
        $invoice->terms_and_conditions = $request->terms_and_conditions;
        $invoice->status = $request->status;

        $invoice->update($request->all());

        $invoiceitem = $request->input("invoice_items");

        $invoice->invoice_items()->delete();

        foreach(json_decode($invoiceitem) as $item){
            $itemdata['invoice_id'] = $invoice->id;
            $itemdata['product_id'] = $item->product_id;
            $itemdata['quantity'] = $item->quantity;
            $itemdata['price'] = $item->price;

            InvoiceItem::create($itemdata);
        }
    }

    
    public function delete_invoice($id) {
        $invoice = Invoice::findOrFail($id);
        $invoice->invoice_items()->delete();
        $invoice->delete();
    }
}

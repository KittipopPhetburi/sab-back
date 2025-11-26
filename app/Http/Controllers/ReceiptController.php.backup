<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::orderBy('created_at', 'desc')->get();
        return response()->json($invoices);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_no' => 'required|string|max:50|unique:invoices',
            'invoice_date' => 'required|date',
            'customer_code' => 'nullable|string|max:50',
            'customer_name' => 'required|string|max:255',
            'seller_name' => 'nullable|string|max:255',
            'customer_address' => 'nullable|string',
            'customer_tax_id' => 'nullable|string|max:50',
            'customer_phone' => 'nullable|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'reference_doc' => 'nullable|string|max:255',
            'shipping_address' => 'nullable|string',
            'shipping_phone' => 'nullable|string|max:20',
            'items' => 'required|string', // JSON string
            'notes' => 'nullable|string',
            'discount' => 'nullable|numeric|min:0|max:100',
            'vat_rate' => 'nullable|numeric|min:0|max:100',
            'subtotal' => 'required|numeric|min:0',
            'discount_amount' => 'required|numeric|min:0',
            'after_discount' => 'required|numeric|min:0',
            'vat' => 'required|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
            'status' => 'nullable|in:draft,pending,paid,cancelled',
            'due_date' => 'nullable|date',
            'doc_type' => 'nullable|string|in:original,copy,ต้นฉบับ,สำเนา',
        ]);

        // แปลง items จาก JSON string เป็น array
        if (isset($validated['items'])) {
            $validated['items'] = json_decode($validated['items'], true);
        }

        // แปลงค่า doc_type จากภาษาไทยเป็นภาษาอังกฤษ
        if (isset($validated['doc_type'])) {
            if ($validated['doc_type'] === 'ต้นฉบับ') {
                $validated['doc_type'] = 'original';
            } elseif ($validated['doc_type'] === 'สำเนา') {
                $validated['doc_type'] = 'copy';
            }
        }

        $invoice = Invoice::create($validated);

        return response()->json([
            'message' => 'สร้างใบแจ้งหนี้สำเร็จ',
            'data' => $invoice
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        return response()->json($invoice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        $validated = $request->validate([
            'invoice_no' => 'required|string|max:50|unique:invoices,invoice_no,' . $id,
            'invoice_date' => 'required|date',
            'customer_code' => 'nullable|string|max:50',
            'customer_name' => 'required|string|max:255',
            'seller_name' => 'nullable|string|max:255',
            'customer_address' => 'nullable|string',
            'customer_tax_id' => 'nullable|string|max:50',
            'customer_phone' => 'nullable|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'reference_doc' => 'nullable|string|max:255',
            'shipping_address' => 'nullable|string',
            'shipping_phone' => 'nullable|string|max:20',
            'items' => 'required|string', // JSON string
            'notes' => 'nullable|string',
            'discount' => 'nullable|numeric|min:0|max:100',
            'vat_rate' => 'nullable|numeric|min:0|max:100',
            'subtotal' => 'required|numeric|min:0',
            'discount_amount' => 'required|numeric|min:0',
            'after_discount' => 'required|numeric|min:0',
            'vat' => 'required|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
            'status' => 'nullable|in:draft,pending,paid,cancelled',
            'due_date' => 'nullable|date',
            'doc_type' => 'nullable|string|in:original,copy,ต้นฉบับ,สำเนา',
        ]);

        // แปลง items จาก JSON string เป็น array
        if (isset($validated['items'])) {
            $validated['items'] = json_decode($validated['items'], true);
        }

        // แปลงค่า doc_type จากภาษาไทยเป็นภาษาอังกฤษ
        if (isset($validated['doc_type'])) {
            if ($validated['doc_type'] === 'ต้นฉบับ') {
                $validated['doc_type'] = 'original';
            } elseif ($validated['doc_type'] === 'สำเนา') {
                $validated['doc_type'] = 'copy';
            }
        }

        $invoice->update($validated);

        return response()->json([
            'message' => 'อัปเดตใบแจ้งหนี้สำเร็จ',
            'data' => $invoice
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return response()->json([
            'message' => 'ลบใบแจ้งหนี้สำเร็จ'
        ]);
    }

    /**
     * Update only the status of an invoice.
     */
    public function updateStatus(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:draft,pending,paid,cancelled',
        ]);

        $invoice->update(['status' => $validated['status']]);

        return response()->json([
            'message' => 'อัปเดตสถานะใบแจ้งหนี้สำเร็จ',
            'data' => $invoice
        ]);
    }
}

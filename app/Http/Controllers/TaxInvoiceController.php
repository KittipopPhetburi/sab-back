<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaxInvoice;
use App\Mail\InvoiceNotification;
use Illuminate\Support\Facades\Mail;

class TaxInvoiceController extends Controller
{
    public function index()
    {
        $taxInvoices = TaxInvoice::orderBy('created_at', 'desc')->get();
        return response()->json($taxInvoices);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'docNumber' => 'required|string|unique:tax_invoices,doc_number',
            'documentType' => 'required|in:invoice,receipt',
            'docDate' => 'required|date',
            'customer' => 'required|array',
            'items' => 'required|array',
            'subtotal' => 'required|numeric',
            'discountAmount' => 'required|numeric',
            'afterDiscount' => 'required|numeric',
            'vat' => 'required|numeric',
            'grandTotal' => 'required|numeric',
        ]);

        $taxInvoice = TaxInvoice::create([
            'doc_number' => $validated['docNumber'],
            'document_type' => $validated['documentType'],
            'doc_date' => $validated['docDate'],
            'customer_code' => $validated['customer']['code'] ?? null,
            'customer_name' => $validated['customer']['name'],
            'customer_address' => $validated['customer']['address'] ?? null,
            'customer_tax_id' => $validated['customer']['taxId'] ?? null,
            'selected_document' => $request->selectedDocument,
            'shipping_address' => $request->shippingAddress,
            'shipping_phone' => $request->shippingPhone,
            'items' => $validated['items'],
            'notes' => $request->notes,
            'discount' => $request->discount ?? 0,
            'vat_rate' => $request->vatRate ?? 7,
            'subtotal' => $validated['subtotal'],
            'discount_amount' => $validated['discountAmount'],
            'after_discount' => $validated['afterDiscount'],
            'vat' => $validated['vat'],
            'grand_total' => $validated['grandTotal'],
            'status' => 'draft',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'บันทึกใบแจ้งหนี้/ใบกำกับภาษีสำเร็จ',
            'data' => $taxInvoice
        ], 201);
    }

    public function show($id)
    {
        $taxInvoice = TaxInvoice::findOrFail($id);
        return response()->json($taxInvoice);
    }

    public function update(Request $request, $id)
    {
        $taxInvoice = TaxInvoice::findOrFail($id);

        $validated = $request->validate([
            'docNumber' => 'required|string|unique:tax_invoices,doc_number,' . $id,
            'documentType' => 'required|in:invoice,receipt',
            'docDate' => 'required|date',
            'customer' => 'required|array',
            'items' => 'required|array',
            'subtotal' => 'required|numeric',
            'discountAmount' => 'required|numeric',
            'afterDiscount' => 'required|numeric',
            'vat' => 'required|numeric',
            'grandTotal' => 'required|numeric',
        ]);

        $taxInvoice->update([
            'doc_number' => $validated['docNumber'],
            'document_type' => $validated['documentType'],
            'doc_date' => $validated['docDate'],
            'customer_code' => $validated['customer']['code'] ?? null,
            'customer_name' => $validated['customer']['name'],
            'customer_address' => $validated['customer']['address'] ?? null,
            'customer_tax_id' => $validated['customer']['taxId'] ?? null,
            'selected_document' => $request->selectedDocument,
            'shipping_address' => $request->shippingAddress,
            'shipping_phone' => $request->shippingPhone,
            'items' => $validated['items'],
            'notes' => $request->notes,
            'discount' => $request->discount ?? 0,
            'vat_rate' => $request->vatRate ?? 7,
            'subtotal' => $validated['subtotal'],
            'discount_amount' => $validated['discountAmount'],
            'after_discount' => $validated['afterDiscount'],
            'vat' => $validated['vat'],
            'grand_total' => $validated['grandTotal'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'อัปเดตใบแจ้งหนี้/ใบกำกับภาษีสำเร็จ',
            'data' => $taxInvoice
        ]);
    }

    public function destroy($id)
    {
        $taxInvoice = TaxInvoice::findOrFail($id);
        $taxInvoice->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'ลบใบแจ้งหนี้/ใบกำกับภาษีสำเร็จ'
        ]);
    }

    public function sendEmail(Request $request, $id)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $taxInvoice = TaxInvoice::findOrFail($id);

        // Prepare invoice data for email
        $invoiceData = [
            'docNumber' => $taxInvoice->doc_number,
            'documentType' => $taxInvoice->document_type,
            'docDate' => $taxInvoice->doc_date,
            'customer' => [
                'name' => $taxInvoice->customer_name,
                'code' => $taxInvoice->customer_code,
                'address' => $taxInvoice->customer_address,
                'taxId' => $taxInvoice->customer_tax_id,
            ],
            'selectedDocument' => $taxInvoice->selected_document,
            'shippingAddress' => $taxInvoice->shipping_address,
            'shippingPhone' => $taxInvoice->shipping_phone,
            'items' => $taxInvoice->items,
            'notes' => $taxInvoice->notes,
            'discount' => $taxInvoice->discount,
            'vatRate' => $taxInvoice->vat_rate,
            'subtotal' => $taxInvoice->subtotal,
            'discountAmount' => $taxInvoice->discount_amount,
            'afterDiscount' => $taxInvoice->after_discount,
            'vat' => $taxInvoice->vat,
            'grandTotal' => $taxInvoice->grand_total,
        ];

        try {
            Mail::to($validated['email'])
                ->send(new InvoiceNotification($invoiceData, $validated['email']));

            return response()->json([
                'status' => 'success',
                'message' => 'ส่งอีเมลสำเร็จไปยัง ' . $validated['email']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'เกิดข้อผิดพลาดในการส่งอีเมล: ' . $e->getMessage()
            ], 500);
        }
    }
}

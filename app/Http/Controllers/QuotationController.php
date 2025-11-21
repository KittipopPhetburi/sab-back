<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function index()
    {
        $quotations = Quotation::orderBy('created_at', 'desc')->get();
        return response()->json($quotations);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'quotation_number' => 'required|string|max:50|unique:quotations',
            'date' => 'required|date',
            'seller_name' => 'nullable|string|max:255',
            'seller_phone' => 'nullable|string|max:20',
            'seller_email' => 'nullable|email|max:100',
            'customer' => 'nullable|string|max:255',
            'customer_code' => 'nullable|string|max:50',
            'customer_name' => 'required|string|max:255',
            'customer_address' => 'nullable|string',
            'customer_tax_id' => 'nullable|string|max:20',
            'customer_phone' => 'nullable|string|max:20',
            'customer_email' => 'nullable|email|max:100',
            'reference_doc' => 'nullable|string|max:100',
            'shipping_address' => 'nullable|string',
            'shipping_phone' => 'nullable|string|max:20',
            'items' => 'required|string',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'discount' => 'nullable|numeric|min:0|max:100',
            'vat_rate' => 'nullable|numeric|min:0|max:100',
            'subtotal' => 'required|numeric|min:0',
            'discount_amount' => 'required|numeric|min:0',
            'after_discount' => 'required|numeric|min:0',
            'vat' => 'required|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
            'amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:ร่าง,รออนุมัติ,อนุมัติแล้ว,ยกเลิก',
            'valid_until' => 'nullable|date',
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

        $quotation = Quotation::create($validated);

        return response()->json([
            'message' => 'เพิ่มใบเสนอราคาสำเร็จ',
            'data' => $quotation
        ], 201);
    }

    public function show($id)
    {
        $quotation = Quotation::findOrFail($id);
        return response()->json($quotation);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quotation_number' => 'required|string|max:50|unique:quotations,quotation_number,' . $id,
            'date' => 'required|date',
            'seller_name' => 'nullable|string|max:255',
            'seller_phone' => 'nullable|string|max:20',
            'seller_email' => 'nullable|email|max:100',
            'customer' => 'nullable|string|max:255',
            'customer_code' => 'nullable|string|max:50',
            'customer_name' => 'required|string|max:255',
            'customer_address' => 'nullable|string',
            'customer_tax_id' => 'nullable|string|max:20',
            'customer_phone' => 'nullable|string|max:20',
            'customer_email' => 'nullable|email|max:100',
            'reference_doc' => 'nullable|string|max:100',
            'shipping_address' => 'nullable|string',
            'shipping_phone' => 'nullable|string|max:20',
            'items' => 'required|string',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'discount' => 'nullable|numeric|min:0|max:100',
            'vat_rate' => 'nullable|numeric|min:0|max:100',
            'subtotal' => 'required|numeric|min:0',
            'discount_amount' => 'required|numeric|min:0',
            'after_discount' => 'required|numeric|min:0',
            'vat' => 'required|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
            'amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:ร่าง,รออนุมัติ,อนุมัติแล้ว,ยกเลิก',
            'valid_until' => 'nullable|date',
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

        $quotation = Quotation::findOrFail($id);
        $quotation->update($validated);

        return response()->json([
            'message' => 'อัปเดตใบเสนอราคาสำเร็จ',
            'data' => $quotation
        ]);
    }

    public function destroy($id)
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->delete();

        return response()->json([
            'message' => 'ลบใบเสนอราคาสำเร็จ'
        ]);
    }

    /**
     * Update only the status of a quotation.
     */
    public function updateStatus(Request $request, $id)
    {
        $quotation = Quotation::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:ร่าง,รออนุมัติ,อนุมัติแล้ว,ยกเลิก',
        ]);

        $quotation->update(['status' => $validated['status']]);

        return response()->json([
            'message' => 'อัปเดตสถานะใบเสนอราคาสำเร็จ',
            'data' => $quotation
        ]);
    }
}

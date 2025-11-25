<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function index()
    {
        $receipts = Receipt::orderBy('created_at', 'desc')->get();
        return response()->json($receipts);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'receipt_no' => 'required|string|max:50|unique:receipts',
            'date' => 'required|date',
            'customer' => 'required|string|max:255',
            'seller_name' => 'nullable|string|max:255',
            'customer_address' => 'nullable|string',
            'customer_tax_id' => 'nullable|string|max:20',
            'customer_phone' => 'nullable|string|max:20',
            'customer_email' => 'nullable|string|email|max:255',
            'discount' => 'nullable|numeric|min:0',
            'vat_rate' => 'nullable|numeric|min:0',
            'subtotal' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'after_discount' => 'nullable|numeric|min:0',
            'vat' => 'nullable|numeric|min:0',
            'invoice_ref' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:ร่าง,รอออก,ออกแล้ว,ยกเลิก',
            'doc_type' => 'nullable|string|in:original,copy,ต้นฉบับ,สำเนา',
        ]);

        // แปลงค่า doc_type จากภาษาไทยเป็นภาษาอังกฤษ
        if (isset($validated['doc_type'])) {
            if ($validated['doc_type'] === 'ต้นฉบับ') {
                $validated['doc_type'] = 'original';
            } elseif ($validated['doc_type'] === 'สำเนา') {
                $validated['doc_type'] = 'copy';
            }
        }

        $receipt = Receipt::create($validated);

        return response()->json([
            'message' => 'เพิ่มใบเสร็จรับเงินสำเร็จ',
            'data' => $receipt
        ], 201);
    }

    public function show($id)
    {
        $receipt = Receipt::findOrFail($id);
        return response()->json($receipt);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'receipt_no' => 'required|string|max:50|unique:receipts,receipt_no,' . $id,
            'date' => 'required|date',
            'customer' => 'nullable|string|max:255',
            'seller_name' => 'nullable|string|max:255',
            'customer_address' => 'nullable|string',
            'customer_tax_id' => 'nullable|string|max:20',
            'customer_phone' => 'nullable|string|max:20',
            'customer_email' => 'nullable|string|email|max:255',
            'discount' => 'nullable|numeric|min:0',
            'vat_rate' => 'nullable|numeric|min:0',
            'subtotal' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'after_discount' => 'nullable|numeric|min:0',
            'vat' => 'nullable|numeric|min:0',
            'invoice_ref' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:ร่าง,รอออก,ออกแล้ว,ยกเลิก',
            'doc_type' => 'nullable|string|in:original,copy,ต้นฉบับ,สำเนา',
        ]);

        // แปลงค่า doc_type จากภาษาไทยเป็นภาษาอังกฤษ
        if (isset($validated['doc_type'])) {
            if ($validated['doc_type'] === 'ต้นฉบับ') {
                $validated['doc_type'] = 'original';
            } elseif ($validated['doc_type'] === 'สำเนา') {
                $validated['doc_type'] = 'copy';
            }
        }

        $receipt = Receipt::findOrFail($id);
        $receipt->update($validated);

        return response()->json([
            'message' => 'อัปเดตใบเสร็จรับเงินสำเร็จ',
            'data' => $receipt
        ]);
    }

    public function destroy($id)
    {
        $receipt = Receipt::findOrFail($id);
        $receipt->delete();

        return response()->json([
            'message' => 'ลบใบเสร็จรับเงินสำเร็จ'
        ]);
    }
}

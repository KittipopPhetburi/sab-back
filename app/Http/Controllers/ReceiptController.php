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
            'invoice_ref' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:ร่าง,รอออก,ออกแล้ว,ยกเลิก',
        ]);

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
            'customer' => 'required|string|max:255',
            'invoice_ref' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:ร่าง,รอออก,ออกแล้ว,ยกเลิก',
        ]);

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

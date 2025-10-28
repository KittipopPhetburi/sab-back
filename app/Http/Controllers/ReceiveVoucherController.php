<?php

namespace App\Http\Controllers;

use App\Models\ReceiveVoucher;
use Illuminate\Http\Request;

class ReceiveVoucherController extends Controller
{
    public function index()
    {
        $vouchers = ReceiveVoucher::orderBy('created_at', 'desc')->get();
        return response()->json($vouchers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'voucher_no' => 'required|string|max:50|unique:receive_vouchers',
            'date' => 'required|date',
            'payer' => 'required|string|max:255',
            'payer_id' => 'nullable|integer',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:รอรับ,รออนุมัติ,รับแล้ว,ยกเลิก',
            'receive_method' => 'nullable|string|max:50',
            'payment_method' => 'nullable|string|max:50',
            'payment_date' => 'nullable|date',
            'withholding_tax_no' => 'nullable|string|max:50',
            'withholding_tax_amount' => 'nullable|numeric|min:0',
            'receive_date' => 'nullable|date',
            'tax_type' => 'nullable|string|max:20',
            'salesperson' => 'nullable|string|max:255',
            'items' => 'nullable|json',
            'notes' => 'nullable|string',
            'discount' => 'nullable|numeric|min:0|max:100',
            'vat_rate' => 'nullable|numeric|min:0',
            'subtotal' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'after_discount' => 'nullable|numeric|min:0',
            'vat' => 'nullable|numeric|min:0',
            'grand_total' => 'nullable|numeric|min:0',
        ]);

        $voucher = ReceiveVoucher::create($validated);

        return response()->json([
            'message' => 'เพิ่มใบสำคัญรับเงินสำเร็จ',
            'data' => $voucher
        ], 201);
    }

    public function show($id)
    {
        $voucher = ReceiveVoucher::findOrFail($id);
        return response()->json($voucher);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'voucher_no' => 'required|string|max:50|unique:receive_vouchers,voucher_no,' . $id,
            'date' => 'required|date',
            'payer' => 'required|string|max:255',
            'payer_id' => 'nullable|integer',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:รอรับ,รออนุมัติ,รับแล้ว,ยกเลิก',
            'receive_method' => 'nullable|string|max:50',
            'payment_method' => 'nullable|string|max:50',
            'payment_date' => 'nullable|date',
            'withholding_tax_no' => 'nullable|string|max:50',
            'withholding_tax_amount' => 'nullable|numeric|min:0',
            'receive_date' => 'nullable|date',
            'tax_type' => 'nullable|string|max:20',
            'salesperson' => 'nullable|string|max:255',
            'items' => 'nullable|json',
            'notes' => 'nullable|string',
            'discount' => 'nullable|numeric|min:0|max:100',
            'vat_rate' => 'nullable|numeric|min:0',
            'subtotal' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'after_discount' => 'nullable|numeric|min:0',
            'vat' => 'nullable|numeric|min:0',
            'grand_total' => 'nullable|numeric|min:0',
        ]);

        $voucher = ReceiveVoucher::findOrFail($id);
        $voucher->update($validated);

        return response()->json([
            'message' => 'อัปเดตใบสำคัญรับเงินสำเร็จ',
            'data' => $voucher
        ]);
    }

    public function destroy($id)
    {
        $voucher = ReceiveVoucher::findOrFail($id);
        $voucher->delete();

        return response()->json([
            'message' => 'ลบใบสำคัญรับเงินสำเร็จ'
        ]);
    }
}

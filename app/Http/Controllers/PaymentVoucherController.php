<?php

namespace App\Http\Controllers;

use App\Models\PaymentVoucher;
use Illuminate\Http\Request;

class PaymentVoucherController extends Controller
{
    public function index()
    {
        return response()->json(PaymentVoucher::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'payee' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'status' => 'required|string|max:50',
            'payment_method' => 'nullable|string|max:100',
            'withholding_tax_no' => 'nullable|string|max:50',
            'withholding_tax_amount' => 'nullable|numeric',
            'payment_date' => 'nullable|date',
        ]);

        $voucher = PaymentVoucher::create($validated);

        return response()->json(['message' => 'เพิ่มใบสำคัญจ่ายสำเร็จ', 'data' => $voucher]);
    }

    public function show($id)
    {
        return response()->json(PaymentVoucher::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'payee' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'status' => 'required|string|max:50',
            'payment_method' => 'nullable|string|max:100',
            'withholding_tax_no' => 'nullable|string|max:50',
            'withholding_tax_amount' => 'nullable|numeric',
            'payment_date' => 'nullable|date',
        ]);

        $voucher = PaymentVoucher::findOrFail($id);
        $voucher->update($validated);

        return response()->json(['message' => 'อัปเดตข้อมูลสำเร็จ', 'data' => $voucher]);
    }

    public function destroy($id)
    {
        $voucher = PaymentVoucher::findOrFail($id);
        $voucher->delete();

        return response()->json(['message' => 'ลบข้อมูลสำเร็จ']);
    }
}

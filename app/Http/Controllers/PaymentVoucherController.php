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
            'voucher_no' => 'nullable|string|max:50',
            'date' => 'required|date',
            'payee' => 'required|string|max:255',
            'payee_id' => 'nullable|integer',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'status' => 'required|string|max:50',
            'payment_method' => 'nullable|string|max:100',
            'withholding_tax_no' => 'nullable|string|max:50',
            'withholding_tax_amount' => 'nullable|numeric',
            'payment_date' => 'nullable|date',
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
            'doc_type' => 'nullable|string|in:original,copy,ต้นฉบับ,สำเนา',
        ]);

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
            'voucher_no' => 'nullable|string|max:50',
            'date' => 'required|date',
            'payee' => 'required|string|max:255',
            'payee_id' => 'nullable|integer',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'status' => 'required|string|max:50',
            'payment_method' => 'nullable|string|max:100',
            'withholding_tax_no' => 'nullable|string|max:50',
            'withholding_tax_amount' => 'nullable|numeric',
            'payment_date' => 'nullable|date',
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
            'doc_type' => 'nullable|string|in:original,copy,ต้นฉบับ,สำเนา',
        ]);

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

    /**
     * Update only the status of a payment voucher.
     */
    public function updateStatus(Request $request, $id)
    {
        $voucher = PaymentVoucher::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string|max:50',
        ]);

        $voucher->update(['status' => $validated['status']]);

        return response()->json([
            'message' => 'อัปเดตสถานะใบสำคัญจ่ายสำเร็จ',
            'data' => $voucher
        ]);
    }
}

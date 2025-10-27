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
            'customer' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:ร่าง,รออนุมัติ,อนุมัติแล้ว,ยกเลิก',
            'valid_until' => 'nullable|date',
        ]);

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
            'customer' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:ร่าง,รออนุมัติ,อนุมัติแล้ว,ยกเลิก',
            'valid_until' => 'nullable|date',
        ]);

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
}

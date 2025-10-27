<?php

namespace App\Http\Controllers;

use App\Models\WithholdingTax;
use App\Models\WithholdingTaxItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithholdingTaxController extends Controller
{
    public function index()
    {
        $taxes = WithholdingTax::with('items')
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($taxes);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doc_number' => 'required|string|max:50|unique:withholding_taxes',
            'doc_date' => 'required|date',
            'sequence_number' => 'required|string|max:50',
            'payer_tax_id' => 'required|string|max:13',
            'payer_name' => 'required|string|max:255',
            'recipient_tax_id' => 'required|string|max:13',
            'recipient_name' => 'required|string|max:255',
            'recipient_address' => 'required|string',
            'recipient_type' => 'required|in:individual,juristic,partnership,other',
            'company_type' => 'nullable|string|max:10',
            'total_amount' => 'required|numeric|min:0',
            'total_tax' => 'required|numeric|min:0',
            'status' => 'required|in:ร่าง,รออนุมัติ,อนุมัติแล้ว,ยกเลิก',
            'created_by' => 'required|string|max:100',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.type' => 'required|string|max:50',
            'items.*.description' => 'required|string',
            'items.*.date' => 'required|date',
            'items.*.tax_rate' => 'required|numeric|min:0|max:100',
            'items.*.amount' => 'required|numeric|min:0',
            'items.*.tax_amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Create main record
            $tax = WithholdingTax::create([
                'doc_number' => $validated['doc_number'],
                'doc_date' => $validated['doc_date'],
                'sequence_number' => $validated['sequence_number'],
                'payer_tax_id' => $validated['payer_tax_id'],
                'payer_name' => $validated['payer_name'],
                'recipient_tax_id' => $validated['recipient_tax_id'],
                'recipient_name' => $validated['recipient_name'],
                'recipient_address' => $validated['recipient_address'],
                'recipient_type' => $validated['recipient_type'],
                'company_type' => $validated['company_type'] ?? null,
                'total_amount' => $validated['total_amount'],
                'total_tax' => $validated['total_tax'],
                'status' => $validated['status'],
                'created_by' => $validated['created_by'],
                'notes' => $validated['notes'] ?? null,
            ]);

            // Create items
            foreach ($validated['items'] as $item) {
                $tax->items()->create([
                    'type' => $item['type'],
                    'description' => $item['description'],
                    'date' => $item['date'],
                    'tax_rate' => $item['tax_rate'],
                    'amount' => $item['amount'],
                    'tax_amount' => $item['tax_amount'],
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'เพิ่มหัก ณ ที่จ่ายสำเร็จ',
                'data' => $tax->load('items')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $tax = WithholdingTax::with('items')->findOrFail($id);
        return response()->json($tax);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'doc_number' => 'required|string|max:50|unique:withholding_taxes,doc_number,' . $id,
            'doc_date' => 'required|date',
            'sequence_number' => 'required|string|max:50',
            'payer_tax_id' => 'required|string|max:13',
            'payer_name' => 'required|string|max:255',
            'recipient_tax_id' => 'required|string|max:13',
            'recipient_name' => 'required|string|max:255',
            'recipient_address' => 'required|string',
            'recipient_type' => 'required|in:individual,juristic,partnership,other',
            'company_type' => 'nullable|string|max:10',
            'total_amount' => 'required|numeric|min:0',
            'total_tax' => 'required|numeric|min:0',
            'status' => 'required|in:ร่าง,รออนุมัติ,อนุมัติแล้ว,ยกเลิก',
            'created_by' => 'required|string|max:100',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.type' => 'required|string|max:50',
            'items.*.description' => 'required|string',
            'items.*.date' => 'required|date',
            'items.*.tax_rate' => 'required|numeric|min:0|max:100',
            'items.*.amount' => 'required|numeric|min:0',
            'items.*.tax_amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $tax = WithholdingTax::findOrFail($id);

            // Update main record
            $tax->update([
                'doc_number' => $validated['doc_number'],
                'doc_date' => $validated['doc_date'],
                'sequence_number' => $validated['sequence_number'],
                'payer_tax_id' => $validated['payer_tax_id'],
                'payer_name' => $validated['payer_name'],
                'recipient_tax_id' => $validated['recipient_tax_id'],
                'recipient_name' => $validated['recipient_name'],
                'recipient_address' => $validated['recipient_address'],
                'recipient_type' => $validated['recipient_type'],
                'company_type' => $validated['company_type'] ?? null,
                'total_amount' => $validated['total_amount'],
                'total_tax' => $validated['total_tax'],
                'status' => $validated['status'],
                'created_by' => $validated['created_by'],
                'notes' => $validated['notes'] ?? null,
            ]);

            // Delete old items and create new ones
            $tax->items()->delete();
            foreach ($validated['items'] as $item) {
                $tax->items()->create([
                    'type' => $item['type'],
                    'description' => $item['description'],
                    'date' => $item['date'],
                    'tax_rate' => $item['tax_rate'],
                    'amount' => $item['amount'],
                    'tax_amount' => $item['tax_amount'],
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'อัปเดตหัก ณ ที่จ่ายสำเร็จ',
                'data' => $tax->load('items')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $tax = WithholdingTax::findOrFail($id);
        $tax->delete(); // Items will be cascade deleted

        return response()->json([
            'message' => 'ลบหัก ณ ที่จ่ายสำเร็จ'
        ]);
    }
}

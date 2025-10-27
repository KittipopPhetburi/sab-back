<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::orderBy('created_at', 'desc')->get();
        return response()->json($purchaseOrders);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'po_number' => 'required|string|max:50|unique:purchase_orders',
            'date' => 'required|date',
            'supplier' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:ร่าง,รอจัดส่ง,จัดส่งแล้ว,ยกเลิก',
        ]);

        $purchaseOrder = PurchaseOrder::create($validated);

        return response()->json([
            'message' => 'เพิ่มใบสั่งซื้อสำเร็จ',
            'data' => $purchaseOrder
        ], 201);
    }

    public function show($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);
        return response()->json($purchaseOrder);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'po_number' => 'required|string|max:50|unique:purchase_orders,po_number,' . $id,
            'date' => 'required|date',
            'supplier' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:ร่าง,รอจัดส่ง,จัดส่งแล้ว,ยกเลิก',
        ]);

        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $purchaseOrder->update($validated);

        return response()->json([
            'message' => 'อัปเดตใบสั่งซื้อสำเร็จ',
            'data' => $purchaseOrder
        ]);
    }

    public function destroy($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $purchaseOrder->delete();

        return response()->json([
            'message' => 'ลบใบสั่งซื้อสำเร็จ'
        ]);
    }
}

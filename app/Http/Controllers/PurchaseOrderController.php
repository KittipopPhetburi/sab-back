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
            'supplier' => 'nullable|string|max:255',
            'supplier_code' => 'nullable|string|max:50',
            'supplier_name' => 'required|string|max:255',
            'supplier_address' => 'nullable|string',
            'supplier_tax_id' => 'nullable|string|max:20',
            'supplier_phone' => 'nullable|string|max:20',
            'supplier_email' => 'nullable|email|max:100',
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
            'status' => 'required|in:ร่าง,รอจัดส่ง,จัดส่งแล้ว,ยกเลิก',
            'expected_delivery_date' => 'nullable|date',
            'buyer_name' => 'nullable|string|max:255',
            'buyer_phone' => 'nullable|string|max:20',
            'buyer_email' => 'nullable|email|max:100',
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
            'supplier' => 'nullable|string|max:255',
            'supplier_code' => 'nullable|string|max:50',
            'supplier_name' => 'required|string|max:255',
            'supplier_address' => 'nullable|string',
            'supplier_tax_id' => 'nullable|string|max:20',
            'supplier_phone' => 'nullable|string|max:20',
            'supplier_email' => 'nullable|email|max:100',
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
            'status' => 'required|in:ร่าง,รอจัดส่ง,จัดส่งแล้ว,ยกเลิก',
            'expected_delivery_date' => 'nullable|date',
            'buyer_name' => 'nullable|string|max:255',
            'buyer_phone' => 'nullable|string|max:20',
            'buyer_email' => 'nullable|email|max:100',
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

    /**
     * Update only the status of a purchase order.
     */
    public function updateStatus(Request $request, $id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:ร่าง,รอจัดส่ง,จัดส่งแล้ว,ยกเลิก',
        ]);

        $purchaseOrder->update(['status' => $validated['status']]);

        return response()->json([
            'message' => 'อัปเดตสถานะใบสั่งซื้อสำเร็จ',
            'data' => $purchaseOrder
        ]);
    }
}

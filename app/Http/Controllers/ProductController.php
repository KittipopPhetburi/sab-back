<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
 public function index()
{
    $products = Product::with('category')->get()->map(function ($p) {
        return [
            'id' => $p->id,
            'code' => $p->code,
            'name' => $p->name,
            'type' => $p->type,
            'category_id' => $p->category_id,
            'category' => optional($p->category)->name ?? '(ไม่ระบุ)',
            'quantity' => $p->quantity,
            'unit' => $p->unit,
            'purchase_price' => $p->purchase_price ?? 0,
            'sale_price' => $p->sale_price ?? 0,
            'description' => $p->description,
            'status' => $p->status,
            // Legacy fields for backward compatibility
            'price' => $p->price ?? $p->sale_price ?? 0,
            'stock' => $p->stock ?? $p->quantity,
        ];
    });

    return response()->json($products);
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:50',
            'category_id' => 'nullable|integer|exists:categories,id',
            'quantity' => 'nullable|integer',
            'unit' => 'nullable|string|max:50',
            'purchase_price' => 'nullable|numeric',
            'sale_price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'status' => 'required|string|max:50',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'message' => 'เพิ่มสินค้าสำเร็จ',
            'product' => $product,
        ]);
    }

    public function show(Product $product)
    {
        $product->load('category');

        return response()->json([
            'id' => $product->id,
            'code' => $product->code,
            'name' => $product->name,
            'type' => $product->type,
            'category_id' => $product->category_id,
            'category' => optional($product->category)->name ?? '(ไม่ระบุ)',
            'quantity' => $product->quantity,
            'unit' => $product->unit,
            'purchase_price' => $product->purchase_price ?? 0,
            'sale_price' => $product->sale_price ?? 0,
            'description' => $product->description,
            'status' => $product->status,
            // Legacy fields
            'price' => $product->price ?? $product->sale_price ?? 0,
            'stock' => $product->stock ?? $product->quantity,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:50',
            'category_id' => 'nullable|integer|exists:categories,id',
            'quantity' => 'nullable|integer',
            'unit' => 'nullable|string|max:50',
            'purchase_price' => 'nullable|numeric',
            'sale_price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'status' => 'required|string|max:50',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        return response()->json([
            'message' => 'อัปเดตข้อมูลสินค้าสำเร็จ',
            'product' => $product,
        ]);
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json(['message' => 'ลบสินค้าสำเร็จ']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'ไม่สามารถลบสินค้าได้',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

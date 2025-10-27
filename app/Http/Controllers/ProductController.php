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
            'category_id' => $p->category_id,
            'category' => optional($p->category)->name ?? '(ไม่ระบุ)',
            'price' => $p->price,
            'stock' => $p->stock,
            'status' => $p->status,
        ];
    });

    return response()->json($products);
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|integer|exists:categories,id',
            'price' => 'nullable|numeric',
            'stock' => 'nullable|integer',
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
            'category_id' => $product->category_id,
            'category' => optional($product->category)->name ?? '(ไม่ระบุ)',
            'price' => number_format($product->price, 2),
            'stock' => $product->stock,
            'status' => $product->status,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|integer|exists:categories,id',
            'price' => 'nullable|numeric',
            'stock' => 'nullable|integer',
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

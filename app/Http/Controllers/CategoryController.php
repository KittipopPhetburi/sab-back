<?php

// app/Http/Controllers/CategoryController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
{
    $categories = \App\Models\Category::withCount('products')->get();

    return response()->json($categories->map(function ($c) {
        return [
            'id' => $c->id,
            'code' => $c->code,
            'name' => $c->name,
            'type' => $c->type,
            'products_count' => $c->products_count, // ✅ จำนวนสินค้า
        ];
    }));
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:categories,code',
            'name' => 'required|string|max:100',
            'type' => 'required|string|in:สินค้า,บริการ',
        ]);

        $category = Category::create($validated);
        return response()->json(['message' => 'บันทึกสำเร็จ', 'data' => $category]);
    }
    public function update(Request $request, $id)
{
    $category = Category::find($id);
    if (!$category) {
        return response()->json(['message' => 'ไม่พบหมวดหมู่'], 404);
    }

    $validated = $request->validate([
        'code' => 'required|string|max:20|unique:categories,code,' . $id,
        'name' => 'required|string|max:255',
        'type' => 'required|in:สินค้า,บริการ',
    ]);

    $category->update($validated);

    return response()->json(['message' => 'อัปเดตสำเร็จ', 'data' => $category]);
}

public function destroy($id)
{
    $category = Category::find($id);
    if (!$category) {
        return response()->json(['message' => 'ไม่พบหมวดหมู่'], 404);
    }

    $category->delete();

    return response()->json(['message' => 'ลบข้อมูลสำเร็จ']);
}
}

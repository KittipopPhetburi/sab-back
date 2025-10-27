<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ✅ ดึงรายชื่อผู้ใช้ทั้งหมด
    public function index()
    {
        return response()->json(User::all());
    }

    // ✅ เพิ่มผู้ใช้ใหม่
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'fullname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'nullable|string',
            'role_name' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $user = User::create([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'user',
            'role_name' => $request->role_name ?? 'ผู้ใช้งาน',
            'status' => $request->status ?? 'active',
        ]);

        return response()->json([
            'message' => 'เพิ่มผู้ใช้งานสำเร็จ',
            'data' => $user
        ]);
    }

    // ✅ อัปเดตข้อมูลผู้ใช้
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'username' => $request->username ?? $user->username,
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'role' => $request->role ?? $user->role,
            'role_name' => $request->role_name ?? $user->role_name,
            'status' => $request->status ?? $user->status,
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return response()->json(['message' => 'อัปเดตข้อมูลสำเร็จ']);
    }

    // ✅ ลบผู้ใช้
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['message' => 'ลบผู้ใช้งานเรียบร้อยแล้ว']);
    }

    // ✅ ดูรายละเอียดผู้ใช้
    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // ✅ สมัครสมาชิก
    public function register(Request $request)
{
    $validated = $request->validate([
        'username' => 'required|string|unique:users',
        'fullname' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
    ]);

    $user = User::create([
        'username' => $validated['username'],
        'fullname' => $validated['fullname'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
        'role' => 'user', // 🔒 กำหนดบทบาทเริ่มต้นเป็น user เสมอ
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'สมัครสมาชิกสำเร็จ',
        'user' => $user,
    ]);
}


    // ✅ เข้าสู่ระบบ
   public function login(Request $request)
{
    try {
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = \App\Models\User::where('username', $validated['username'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'เข้าสู่ระบบสำเร็จ',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'fullname' => $user->fullname,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'เกิดข้อผิดพลาดในการเข้าสู่ระบบ',
            'error' => $e->getMessage(),
        ], 500);
    }
}

}

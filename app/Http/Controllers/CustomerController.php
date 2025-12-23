<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('created_at', 'desc')->get();
        return response()->json($customers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:customers,code',
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:ลูกค้า,คู่ค้า,ทั้งคู่ค้าและลูกค้า',
            'branch_name' => 'nullable|string|max:100',
            'tax_id' => 'nullable|string|size:13|regex:/^[0-9]{13}$/',
            'contact_person' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string',
            'note' => 'nullable|string',
            'account_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:50',
            'bank_name' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
        ], [
            'code.required' => 'กรุณากรอกรหัสลูกค้า',
            'code.unique' => 'รหัสลูกค้านี้มีอยู่ในระบบแล้ว',
            'name.required' => 'กรุณากรอกชื่อลูกค้า/คู่ค้า',
            'name.max' => 'ชื่อลูกค้าต้องไม่เกิน 255 ตัวอักษร',
            'type.required' => 'กรุณาเลือกประเภท',
            'type.in' => 'ประเภทต้องเป็น ลูกค้า, คู่ค้า หรือ ทั้งคู่ค้าและลูกค้า',
            'tax_id.size' => 'เลขประจำตัวผู้เสียภาษีต้องเป็น 13 หลัก',
            'tax_id.regex' => 'เลขประจำตัวผู้เสียภาษีต้องเป็นตัวเลขเท่านั้น',
            'phone.required' => 'กรุณากรอกเบอร์โทรศัพท์',
            'phone.min' => 'เบอร์โทรศัพท์ต้องมีอย่างน้อย 9 หลัก',
            'phone.max' => 'เบอร์โทรศัพท์ต้องไม่เกิน 10 หลัก',
            'phone.regex' => 'เบอร์โทรศัพท์ต้องเป็นตัวเลขเท่านั้น',
            'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
            'address.required' => 'กรุณากรอกที่อยู่',
            'status.required' => 'กรุณาเลือกสถานะ',
        ]);

        $customer = Customer::create($validated);
        return response()->json($customer, 201);
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json($customer);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:customers,code,' . $id,
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:ลูกค้า,คู่ค้า,ทั้งคู่ค้าและลูกค้า',
            'branch_name' => 'nullable|string|max:100',
            'tax_id' => 'nullable|string|size:13|regex:/^[0-9]{13}$/',
            'contact_person' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string',
            'note' => 'nullable|string',
            'account_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:50',
            'bank_name' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
        ], [
            'code.required' => 'กรุณากรอกรหัสลูกค้า',
            'code.unique' => 'รหัสลูกค้านี้มีอยู่ในระบบแล้ว',
            'name.required' => 'กรุณากรอกชื่อลูกค้า/คู่ค้า',
            'name.max' => 'ชื่อลูกค้าต้องไม่เกิน 255 ตัวอักษร',
            'type.required' => 'กรุณาเลือกประเภท',
            'type.in' => 'ประเภทต้องเป็น ลูกค้า, คู่ค้า หรือ ทั้งคู่ค้าและลูกค้า',
            'tax_id.size' => 'เลขประจำตัวผู้เสียภาษีต้องเป็น 13 หลัก',
            'tax_id.regex' => 'เลขประจำตัวผู้เสียภาษีต้องเป็นตัวเลขเท่านั้น',
            'phone.required' => 'กรุณากรอกเบอร์โทรศัพท์',
            'phone.min' => 'เบอร์โทรศัพท์ต้องมีอย่างน้อย 9 หลัก',
            'phone.max' => 'เบอร์โทรศัพท์ต้องไม่เกิน 10 หลัก',
            'phone.regex' => 'เบอร์โทรศัพท์ต้องเป็นตัวเลขเท่านั้น',
            'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
            'address.required' => 'กรุณากรอกที่อยู่',
            'status.required' => 'กรุณาเลือกสถานะ',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($validated);

        return response()->json($customer);
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return response()->json(['message' => 'Customer deleted successfully']);
    }
}

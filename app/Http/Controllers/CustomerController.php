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
            'type' => 'required|string|max:50',
            'branch_name' => 'nullable|string|max:100',
            'tax_id' => 'nullable|string|max:50',
            'contact_person' => 'nullable|string|max:100',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'address' => 'nullable|string',
            'note' => 'nullable|string',
            'account_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:50',
            'bank_name' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
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
            'type' => 'required|string|max:50',
            'branch_name' => 'nullable|string|max:100',
            'tax_id' => 'nullable|string|max:50',
            'contact_person' => 'nullable|string|max:100',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'address' => 'nullable|string',
            'note' => 'nullable|string',
            'account_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:50',
            'bank_name' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
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

<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanySettingController extends Controller
{
    /**
     * Get company settings (always returns first record or creates default)
     */
    public function index()
    {
        $settings = CompanySetting::first();

        if (!$settings) {
            // Create default settings if none exist
            $settings = CompanySetting::create([
                'company_name' => 'บริษัท ตัวอย่าง จำกัด',
                'branch_name' => 'สำนักงานใหญ่',
                'tax_id' => '0000000000000',
                'vat_number' => '0000000000000',
                'address' => 'ที่อยู่บริษัท',
                'phone' => '02-000-0000',
                'email' => 'info@company.com',
                'enable_email' => true,
                'enable_sms' => false,
                'auto_backup' => true,
                'vat_rate' => 7.00,
            ]);
        }

        return response()->json($settings);
    }

    /**
     * Update company settings
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'branch_name' => 'nullable|string|max:255',
            'tax_id' => 'required|string|max:13',
            'vat_number' => 'nullable|string|max:13',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'enable_email' => 'boolean',
            'enable_sms' => 'boolean',
            'auto_backup' => 'boolean',
            'vat_rate' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $settings = CompanySetting::first();

        if (!$settings) {
            // Create new settings if none exist
            $settings = CompanySetting::create($request->all());
        } else {
            // Update existing settings
            $settings->update($request->all());
        }

        return response()->json([
            'message' => 'Company settings updated successfully',
            'data' => $settings
        ]);
    }
}

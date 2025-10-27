<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = [
            [
                'code' => 'CUST-001',
                'name' => 'กรมพัฒนาธุรกิจการค้า',
                'type' => 'ลูกค้า',
                'branch_name' => 'สำนักงานใหญ่',
                'tax_id' => '0105558123456',
                'contact_person' => 'นายสมชาย ใจดี',
                'phone' => '02-123-4567',
                'email' => 'contact@dbd.go.th',
                'address' => '563 ถนนนนทบุรี ตำบลบางกระสอ อำเภอเมือง จังหวัดนนทบุรี 11000',
                'note' => 'ลูกค้าองค์กรภาครัฐ',
                'account_name' => 'กรมพัฒนาธุรกิจการค้า',
                'bank_account' => '123-4-56789-0',
                'bank_name' => 'ธนาคารกรุงไทย',
                'status' => 'active',
            ],
            [
                'code' => 'CUST-002',
                'name' => 'สำนักงานเขตบางนา',
                'type' => 'ลูกค้า',
                'branch_name' => null,
                'tax_id' => '0994000123456',
                'contact_person' => 'นางสาวสมหญิง รักงาน',
                'phone' => '02-234-5678',
                'email' => 'bangna@bangkok.go.th',
                'address' => '1910 ถนนบางนา-ตราด แขวงบางนา เขตบางนา กรุงเทพมหานคร 10260',
                'note' => null,
                'account_name' => null,
                'bank_account' => null,
                'bank_name' => null,
                'status' => 'active',
            ],
            [
                'code' => 'CUST-003',
                'name' => 'โรงเรียนบ้านสวนดอก',
                'type' => 'ลูกค้า',
                'branch_name' => null,
                'tax_id' => null,
                'contact_person' => 'นายวิชัย ครูดี',
                'phone' => '02-345-6789',
                'email' => 'suandok.school@gmail.com',
                'address' => '99/1 หมู่ 5 ตำบลสวนดอก อำเภอเมือง จังหวัดสุพรรณบุรี 72000',
                'note' => 'โรงเรียนประถมศึกษา',
                'account_name' => null,
                'bank_account' => null,
                'bank_name' => null,
                'status' => 'active',
            ],
            [
                'code' => 'SUPP-001',
                'name' => 'บริษัท ABC จำกัด',
                'type' => 'คู่ค้า',
                'branch_name' => 'สาขาสุขุมวิท',
                'tax_id' => '0105558999888',
                'contact_person' => 'นายประเสริฐ มั่งมี',
                'phone' => '02-456-7890',
                'email' => 'sales@abccompany.co.th',
                'address' => '123 ถนนสุขุมวิท แขวงคลองเตย เขตคลองเตย กรุงเทพมหานคร 10110',
                'note' => 'คู่ค้าจำหน่ายอุปกรณ์คอมพิวเตอร์',
                'account_name' => 'บริษัท ABC จำกัด',
                'bank_account' => '234-5-67890-1',
                'bank_name' => 'ธนาคารกสิกรไทย',
                'status' => 'active',
            ],
            [
                'code' => 'CUST-004',
                'name' => 'สำนักงานสาธารณสุขจังหวัดปทุมธานี',
                'type' => 'ลูกค้า',
                'branch_name' => null,
                'tax_id' => '0994000234567',
                'contact_person' => 'นางอรุณี สุขภาพดี',
                'phone' => '02-567-8901',
                'email' => 'pathum.health@moph.go.th',
                'address' => '1 หมู่ 4 ถนนพหลโยธิน ตำบลบางปรอก อำเภอเมือง จังหวัดปทุมธานี 12000',
                'note' => 'โครงการระบบสุขภาพ',
                'account_name' => null,
                'bank_account' => null,
                'bank_name' => null,
                'status' => 'active',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}

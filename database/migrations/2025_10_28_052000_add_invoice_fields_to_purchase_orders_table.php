<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ทำให้ฟิลด์เดิมเป็น nullable ก่อน
        DB::statement('ALTER TABLE purchase_orders MODIFY supplier VARCHAR(255) NULL');
        DB::statement('ALTER TABLE purchase_orders MODIFY amount DECIMAL(15, 2) NULL');

        Schema::table('purchase_orders', function (Blueprint $table) {
            // เพิ่มฟิลด์รายละเอียด supplier (ใช้ชื่อเดียวกับ customer แต่สำหรับผู้ขาย)
            $table->string('supplier_code')->nullable()->after('date');
            $table->string('supplier_name')->nullable()->after('supplier_code');
            $table->text('supplier_address')->nullable()->after('supplier_name');
            $table->string('supplier_tax_id')->nullable()->after('supplier_address');
            $table->string('supplier_phone')->nullable()->after('supplier_tax_id');
            $table->string('supplier_email')->nullable()->after('supplier_phone');

            // เพิ่มฟิลด์การจัดส่ง
            $table->string('reference_doc')->nullable()->after('supplier_email');
            $table->text('shipping_address')->nullable()->after('reference_doc');
            $table->string('shipping_phone')->nullable()->after('shipping_address');

            // เพิ่มฟิลด์รายการสินค้า
            $table->json('items')->nullable()->after('shipping_phone');

            // เพิ่มฟิลด์การคำนวณ
            $table->decimal('discount', 5, 2)->default(0)->after('description');
            $table->decimal('vat_rate', 5, 2)->default(7)->after('discount');
            $table->decimal('subtotal', 15, 2)->default(0)->after('vat_rate');
            $table->decimal('discount_amount', 15, 2)->default(0)->after('subtotal');
            $table->decimal('after_discount', 15, 2)->default(0)->after('discount_amount');
            $table->decimal('vat', 15, 2)->default(0)->after('after_discount');
            $table->decimal('grand_total', 15, 2)->default(0)->after('vat');

            // เพิ่มฟิลด์หมายเหตุ
            $table->text('notes')->nullable()->after('grand_total');

            // เพิ่มฟิลด์วันที่คาดว่าจะได้รับสินค้า
            $table->date('expected_delivery_date')->nullable()->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropColumn([
                'supplier_code',
                'supplier_name',
                'supplier_address',
                'supplier_tax_id',
                'supplier_phone',
                'supplier_email',
                'reference_doc',
                'shipping_address',
                'shipping_phone',
                'items',
                'discount',
                'vat_rate',
                'subtotal',
                'discount_amount',
                'after_discount',
                'vat',
                'grand_total',
                'notes',
                'expected_delivery_date'
            ]);
        });
    }
};

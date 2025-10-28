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
        DB::statement('ALTER TABLE quotations MODIFY customer VARCHAR(255) NULL');
        DB::statement('ALTER TABLE quotations MODIFY amount DECIMAL(15, 2) NULL');

        Schema::table('quotations', function (Blueprint $table) {
            // เพิ่มฟิลด์รายละเอียดลูกค้า
            $table->string('customer_code')->nullable()->after('date');
            $table->string('customer_name')->nullable()->after('customer_code');
            $table->text('customer_address')->nullable()->after('customer_name');
            $table->string('customer_tax_id')->nullable()->after('customer_address');
            $table->string('customer_phone')->nullable()->after('customer_tax_id');
            $table->string('customer_email')->nullable()->after('customer_phone');

            // เพิ่มฟิลด์การจัดส่ง
            $table->string('reference_doc')->nullable()->after('customer_email');
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn([
                'customer_code',
                'customer_name',
                'customer_address',
                'customer_tax_id',
                'customer_phone',
                'customer_email',
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
                'notes'
            ]);
        });
    }
};

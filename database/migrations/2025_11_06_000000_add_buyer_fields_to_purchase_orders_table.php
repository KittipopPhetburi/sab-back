<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            // เพิ่มฟิลด์ผู้จัดซื้อ (Buyer/Purchaser)
            $table->string('buyer_name')->nullable()->after('expected_delivery_date');
            $table->string('buyer_phone')->nullable()->after('buyer_name');
            $table->string('buyer_email')->nullable()->after('buyer_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropColumn([
                'buyer_name',
                'buyer_phone',
                'buyer_email'
            ]);
        });
    }
};

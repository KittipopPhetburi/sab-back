<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountToreceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('receipts', function (Blueprint $table) {
            // เพิ่ม column หลัง column ที่ระบุ
            $table->decimal('discount', 5, 2)->default(0);
            $table->decimal('vat_rate', 5, 2)->default(7);
            $table->decimal('subtotal', 15, 2);
            $table->decimal('discount_amount', 15, 2);
            $table->decimal('after_discount', 15, 2);
            $table->decimal('vat', 15, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('receipts', function (Blueprint $table) {
        $table->dropColumn(['amount']);
    });
    }
}

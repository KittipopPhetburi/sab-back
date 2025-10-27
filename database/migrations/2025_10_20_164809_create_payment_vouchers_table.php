<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentVouchersTable extends Migration
{
    public function up()
    {
        Schema::create('payment_vouchers', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('payee', 255);
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['รอจ่าย', 'รออนุมัติ', 'จ่ายแล้ว', 'ยกเลิก'])->default('รออนุมัติ');
            $table->string('payment_method', 100)->nullable();
            $table->string('withholding_tax_no', 50)->nullable();
            $table->decimal('withholding_tax_amount', 15, 2)->nullable();
            $table->date('payment_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_vouchers');
    }
}

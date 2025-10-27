<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiveVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receive_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_no', 50)->unique();      // เลขที่เอกสาร
            $table->date('date');                             // วันที่ออกเอกสาร
            $table->string('payer', 255);                     // ผู้จ่ายเงิน
            $table->text('description')->nullable();          // รายละเอียด
            $table->decimal('amount', 15, 2);                 // จำนวนเงิน
            $table->enum('status', ['รอรับ', 'รออนุมัติ', 'รับแล้ว', 'ยกเลิก'])->default('รอรับ');
            $table->string('receive_method', 50)->nullable(); // วิธีรับเงิน
            $table->string('withholding_tax_no', 50)->nullable(); // เลขที่ใบหัก ณ ที่จ่าย
            $table->decimal('withholding_tax_amount', 15, 2)->nullable(); // ยอดเงินหัก ณ ที่จ่าย
            $table->date('receive_date')->nullable();         // วันที่รับชำระเงิน
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receive_vouchers');
    }
}

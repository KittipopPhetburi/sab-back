<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('receipts', function (Blueprint $table) {
        $table->id();
        $table->string('receipt_no')->unique();      // เลขที่เอกสาร
        $table->date('date');                        // วันที่ออกเอกสาร
        $table->string('customer');                  // ชื่อลูกค้า
        $table->string('invoice_ref')->nullable();   // อ้างถึงใบแจ้งหนี้
        $table->decimal('amount', 10, 2);            // จำนวนเงิน
        $table->text('description')->nullable();     // รายละเอียด
        $table->enum('status', ['ร่าง', 'รอออก', 'ออกแล้ว', 'ยกเลิก'])->default('ร่าง');
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
        Schema::dropIfExists('receipts');
    }
}

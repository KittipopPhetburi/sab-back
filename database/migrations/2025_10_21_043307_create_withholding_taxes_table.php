<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithholdingTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withholding_taxes', function (Blueprint $table) {
            $table->id();
            $table->string('doc_number', 50)->unique();           // เลขที่เอกสาร
            $table->date('doc_date');                             // วันที่ออกเอกสาร
            $table->string('sequence_number', 50);                // ลำดับที่
            $table->string('payer_tax_id', 13);                   // เลขประจำตัวผู้เสียภาษีผู้จ่าย
            $table->string('payer_name', 255);                    // ชื่อผู้จ่ายเงิน
            $table->string('recipient_tax_id', 13);               // เลขประจำตัวผู้เสียภาษีผู้รับ
            $table->string('recipient_name', 255);                // ชื่อผู้รับเงิน
            $table->text('recipient_address');                    // ที่อยู่ผู้รับเงิน
            $table->enum('recipient_type', ['individual', 'juristic', 'partnership', 'other']); // ประเภทผู้รับเงิน
            $table->string('company_type', 10)->nullable();       // ประเภทบริษัท
            $table->decimal('total_amount', 15, 2);               // รวมเงินที่จ่าย
            $table->decimal('total_tax', 15, 2);                  // รวมภาษีหัก ณ ที่จ่าย
            $table->enum('status', ['ร่าง', 'รออนุมัติ', 'อนุมัติแล้ว', 'ยกเลิก'])->default('ร่าง');
            $table->string('created_by', 100);                    // ผู้สร้าง
            $table->text('notes')->nullable();                    // หมายเหตุ
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
        Schema::dropIfExists('withholding_taxes');
    }
}

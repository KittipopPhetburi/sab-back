<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithholdingTaxItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withholding_tax_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('withholding_tax_id')->constrained()->onDelete('cascade'); // อ้างอิงไปยังตารางหลัก
            $table->string('type', 50);                       // ประเภทเงินได้ เช่น 40(2), 40(3)
            $table->text('description');                      // รายละเอียด
            $table->date('date');                             // วันที่จ่าย
            $table->decimal('tax_rate', 5, 2);                // อัตราภาษี (%)
            $table->decimal('amount', 15, 2);                 // จำนวนเงินที่จ่าย
            $table->decimal('tax_amount', 15, 2);             // ภาษีหัก ณ ที่จ่าย
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
        Schema::dropIfExists('withholding_tax_items');
    }
}

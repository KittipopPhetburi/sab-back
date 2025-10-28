<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique();
            $table->date('invoice_date');
            $table->string('customer_code')->nullable();
            $table->string('customer_name');
            $table->text('customer_address')->nullable();
            $table->string('customer_tax_id')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('reference_doc')->nullable(); // อ้างอิงเอกสาร (ใบเสนอราคา, PO)
            $table->text('shipping_address')->nullable();
            $table->string('shipping_phone')->nullable();
            $table->json('items'); // รายการสินค้า/บริการ
            $table->text('notes')->nullable();
            $table->decimal('discount', 5, 2)->default(0); // ส่วนลด %
            $table->decimal('vat_rate', 5, 2)->default(7); // VAT %
            $table->decimal('subtotal', 15, 2); // ยอดรวมก่อนส่วนลด
            $table->decimal('discount_amount', 15, 2); // จำนวนส่วนลด
            $table->decimal('after_discount', 15, 2); // ยอดหลังหักส่วนลด
            $table->decimal('vat', 15, 2); // ภาษีมูลค่าเพิ่ม
            $table->decimal('grand_total', 15, 2); // ยอดรวมสุทธิ
            $table->enum('status', ['draft', 'sent', 'paid', 'cancelled'])->default('draft');
            $table->date('due_date')->nullable(); // วันครบกำหนดชำระ
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
        Schema::dropIfExists('invoices');
    }
}

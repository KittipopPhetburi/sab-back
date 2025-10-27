<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('doc_number')->unique();
            $table->enum('document_type', ['invoice', 'receipt'])->default('invoice');
            $table->date('doc_date');
            $table->string('customer_code')->nullable();
            $table->string('customer_name');
            $table->text('customer_address')->nullable();
            $table->string('customer_tax_id')->nullable();
            $table->string('selected_document')->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('shipping_phone')->nullable();
            $table->json('items');
            $table->text('notes')->nullable();
            $table->decimal('discount', 5, 2)->default(0);
            $table->decimal('vat_rate', 5, 2)->default(7);
            $table->decimal('subtotal', 15, 2);
            $table->decimal('discount_amount', 15, 2);
            $table->decimal('after_discount', 15, 2);
            $table->decimal('vat', 15, 2);
            $table->decimal('grand_total', 15, 2);
            $table->enum('status', ['draft', 'approved', 'cancelled'])->default('draft');
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
        Schema::dropIfExists('tax_invoices');
    }
}

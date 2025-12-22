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
        Schema::create('credit_notes', function (Blueprint $table) {
            $table->id();
            $table->string('credit_note_no')->unique(); // CN20250001
            $table->date('date');
            
            // Customer Info
            $table->string('customer');
            $table->string('customer_code')->nullable();
            $table->string('customer_branch_name')->nullable();
            $table->text('customer_address')->nullable();
            $table->string('customer_tax_id')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();

            // References
            $table->string('invoice_ref')->nullable(); // อ้างอิงใบแจ้งหนี้
            
            // Seller / Internal
            $table->string('seller_name')->nullable();
            $table->string('salesperson')->nullable();
            $table->string('branch_name')->nullable();

            // Shipping
            $table->text('shipping_address')->nullable();
            $table->string('shipping_phone')->nullable();

            // Items & Totals
            $table->json('items')->nullable(); // JSON Array of items
            $table->text('description')->nullable();
            $table->text('notes')->nullable();

            // Calculations
            $table->decimal('amount', 15, 2)->default(0); // ยอดรวม (หรือ subtotal)
            $table->decimal('discount', 15, 2)->default(0); // % ส่วนลด
            $table->decimal('discount_amount', 15, 2)->default(0); // มูลค่าส่วนลด
            $table->decimal('after_discount', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('vat_rate', 5, 2)->default(7);
            $table->decimal('vat', 15, 2)->default(0);
            $table->decimal('grand_total', 15, 2)->default(0);
            
            // Status & Type
            $table->enum('status', ['draft', 'pending', 'paid', 'cancelled'])->default('draft');
            $table->enum('doc_type', ['original', 'copy'])->default('original');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_notes');
    }
};

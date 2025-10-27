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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('quotation_number', 50)->unique();
            $table->date('date');
            $table->string('customer', 255);
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['ร่าง', 'รออนุมัติ', 'อนุมัติแล้ว', 'ยกเลิก'])->default('ร่าง');
            $table->date('valid_until')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};

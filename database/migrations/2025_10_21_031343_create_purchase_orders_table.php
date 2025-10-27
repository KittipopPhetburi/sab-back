<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_number', 50)->unique();
            $table->date('date');
            $table->string('supplier', 255);
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['ร่าง', 'รอจัดส่ง', 'จัดส่งแล้ว', 'ยกเลิก'])->default('ร่าง');
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
        Schema::dropIfExists('purchase_orders');
    }
}

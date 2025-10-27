<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // เพิ่มฟิลด์ใหม่
            $table->string('type')->nullable()->after('name');
            $table->integer('quantity')->nullable()->after('category_id');
            $table->string('unit')->nullable()->after('quantity');
            $table->decimal('purchase_price', 10, 2)->default(0)->after('unit');
            $table->decimal('sale_price', 10, 2)->default(0)->after('purchase_price');
            $table->text('description')->nullable()->after('sale_price');

            // เปลี่ยนชื่อฟิลด์เก่า (ไว้เพื่อ backward compatibility)
            // price และ stock ยังคงไว้แต่จะใช้ฟิลด์ใหม่แทน
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['type', 'quantity', 'unit', 'purchase_price', 'sale_price', 'description']);
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQtyToQuotationsInvoicesReceiptsPurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add qty to quotations table
        Schema::table('quotations', function (Blueprint $table) {
            $table->integer('qty')->default(1)->after('description');
        });

        // Add qty to invoices table
        Schema::table('invoices', function (Blueprint $table) {
            $table->integer('qty')->default(1)->after('items');
        });

        // Add qty to receipts table
        Schema::table('receipts', function (Blueprint $table) {
            $table->integer('qty')->default(1)->after('description');
        });

        // Add qty to purchase_orders table
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->integer('qty')->default(1)->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn('qty');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('qty');
        });

        Schema::table('receipts', function (Blueprint $table) {
            $table->dropColumn('qty');
        });

        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropColumn('qty');
        });
    }
}

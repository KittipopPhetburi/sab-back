<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemsFieldToReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->text('items')->nullable()->after('description');
            $table->string('customer_code')->nullable()->after('customer');
            $table->string('customer_branch_name')->nullable()->after('customer_code');
            $table->string('salesperson')->nullable()->after('seller_name');
            $table->string('branch_name')->nullable()->after('salesperson');
            $table->string('shipping_address')->nullable()->after('customer_email');
            $table->string('shipping_phone')->nullable()->after('shipping_address');
            $table->text('notes')->nullable()->after('items');
            $table->decimal('grand_total', 10, 2)->nullable()->after('vat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->dropColumn(['items', 'customer_code', 'customer_branch_name', 'salesperson', 'branch_name', 'shipping_address', 'shipping_phone', 'notes', 'grand_total']);
        });
    }
}

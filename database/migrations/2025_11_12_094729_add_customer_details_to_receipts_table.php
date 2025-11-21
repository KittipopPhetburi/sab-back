<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerDetailsToReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->text('customer_address')->nullable()->after('customer');
            $table->string('customer_tax_id')->nullable()->after('customer_address');
            $table->string('customer_phone')->nullable()->after('customer_tax_id');
            $table->string('customer_email')->nullable()->after('customer_phone');
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
            $table->dropColumn(['customer_address', 'customer_tax_id', 'customer_phone', 'customer_email']);
        });
    }
}

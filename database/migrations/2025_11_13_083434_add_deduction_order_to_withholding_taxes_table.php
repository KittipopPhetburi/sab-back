<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeductionOrderToWithholdingTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withholding_taxes', function (Blueprint $table) {
            $table->string('deduction_order', 50)->nullable()->after('deduction_format');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('withholding_taxes', function (Blueprint $table) {
            $table->dropColumn('deduction_order');
        });
    }
}

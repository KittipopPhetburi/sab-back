<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeductionFormatToWithholdingTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withholding_taxes', function (Blueprint $table) {
            // Add deduction_format field for radio box (รูปแบบการหัก)
            $table->string('deduction_format', 50)->nullable()->after('deduction_other');
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
            $table->dropColumn('deduction_format');
        });
    }
}

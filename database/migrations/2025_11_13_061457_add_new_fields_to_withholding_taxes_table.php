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
        Schema::table('withholding_taxes', function (Blueprint $table) {
            // Check and add payer address if not exists
            if (!Schema::hasColumn('withholding_taxes', 'payer_address')) {
                $table->text('payer_address')->nullable()->after('payer_name');
            }
            
            // Check and add representative fields if not exist
            if (!Schema::hasColumn('withholding_taxes', 'representative_tax_id')) {
                $table->string('representative_tax_id', 13)->nullable()->after('payer_address');
            }
            if (!Schema::hasColumn('withholding_taxes', 'representative_name')) {
                $table->string('representative_name')->nullable()->after('representative_tax_id');
            }
            if (!Schema::hasColumn('withholding_taxes', 'representative_address')) {
                $table->text('representative_address')->nullable()->after('representative_name');
            }
            
            // Check and add deduction mode fields if not exist
            if (!Schema::hasColumn('withholding_taxes', 'deduction_mode')) {
                $table->string('deduction_mode', 50)->nullable()->after('representative_address');
            }
            if (!Schema::hasColumn('withholding_taxes', 'deduction_other')) {
                $table->string('deduction_other')->nullable()->after('deduction_mode');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('withholding_taxes', function (Blueprint $table) {
            $table->dropColumn([
                'payer_address',
                'representative_tax_id',
                'representative_name',
                'representative_address',
                'deduction_mode',
                'deduction_other',
                // 'recipient_type', // Uncomment if you added it
            ]);
        });
    }
};
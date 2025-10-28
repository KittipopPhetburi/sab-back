<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToReceiveVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receive_vouchers', function (Blueprint $table) {
            $table->unsignedBigInteger('payer_id')->nullable()->after('payer');
            $table->string('payment_method', 50)->nullable()->after('receive_method');
            $table->date('payment_date')->nullable()->after('receive_date');
            $table->string('tax_type', 20)->default('excluding')->after('withholding_tax_amount');
            $table->string('salesperson', 255)->nullable()->after('tax_type');
            $table->json('items')->nullable()->after('salesperson');
            $table->text('notes')->nullable()->after('items');
            $table->decimal('discount', 5, 2)->default(0)->after('notes');
            $table->decimal('vat_rate', 5, 2)->default(7)->after('discount');
            $table->decimal('subtotal', 15, 2)->default(0)->after('vat_rate');
            $table->decimal('discount_amount', 15, 2)->default(0)->after('subtotal');
            $table->decimal('after_discount', 15, 2)->default(0)->after('discount_amount');
            $table->decimal('vat', 15, 2)->default(0)->after('after_discount');
            $table->decimal('grand_total', 15, 2)->default(0)->after('vat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receive_vouchers', function (Blueprint $table) {
            $table->dropColumn([
                'payer_id',
                'payment_method',
                'payment_date',
                'tax_type',
                'salesperson',
                'items',
                'notes',
                'discount',
                'vat_rate',
                'subtotal',
                'discount_amount',
                'after_discount',
                'vat',
                'grand_total'
            ]);
        });
    }
}

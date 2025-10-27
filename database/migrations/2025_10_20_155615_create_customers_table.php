<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name', 255);
            $table->string('type', 50);
            $table->string('branch_name', 100)->nullable();
            $table->string('tax_id', 50)->nullable();
            $table->string('contact_person', 100)->nullable();
            $table->string('phone', 50);
            $table->string('email', 255);
            $table->text('address')->nullable();
            $table->text('note')->nullable();
            $table->string('account_name', 255)->nullable();
            $table->string('bank_account', 50)->nullable();
            $table->string('bank_name', 100)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
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
        Schema::dropIfExists('customers');
    }
}

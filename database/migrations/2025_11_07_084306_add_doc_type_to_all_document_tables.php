<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocTypeToAllDocumentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
 */
    public function up()
{
    Schema::table('quotations', function (Blueprint $table) {
        $table->enum('doc_type', ['original', 'copy'])->default('original')->after('status');
    });
    
    Schema::table('invoices', function (Blueprint $table) {
        $table->enum('doc_type', ['original', 'copy'])->default('original')->after('status');
    });
    
    Schema::table('receipts', function (Blueprint $table) {
        $table->enum('doc_type', ['original', 'copy'])->default('original')->after('status');
    });
    
    Schema::table('purchase_orders', function (Blueprint $table) {
        $table->enum('doc_type', ['original', 'copy'])->default('original')->after('status');
    });
}

    public function down()
{
    Schema::table('quotations', function (Blueprint $table) {
        $table->dropColumn('doc_type');
    });
    Schema::table('invoices', function (Blueprint $table) {
        $table->dropColumn('doc_type');
    });
    Schema::table('receipts', function (Blueprint $table) {
        $table->dropColumn('doc_type');
    });
    Schema::table('purchase_orders', function (Blueprint $table) {
        $table->dropColumn('doc_type');
    });
}
}

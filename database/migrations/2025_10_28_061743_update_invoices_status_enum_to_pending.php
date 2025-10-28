<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateInvoicesStatusEnumToPending extends Migration
{
    public function up()
    {
        // Alter the enum to include 'pending' instead of 'sent'
        DB::statement("ALTER TABLE invoices MODIFY COLUMN status ENUM('draft', 'pending', 'paid', 'cancelled') DEFAULT 'draft'");
    }

    public function down()
    {
        // Revert back
        DB::statement("ALTER TABLE invoices MODIFY COLUMN status ENUM('draft', 'sent', 'paid', 'cancelled') DEFAULT 'draft'");
    }
}

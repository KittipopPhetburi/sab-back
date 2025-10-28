<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MigrateTaxInvoicesToInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // ย้ายข้อมูลจาก tax_invoices ที่เป็น invoice ไปยัง invoices table
        $taxInvoices = DB::table('tax_invoices')
            ->where('document_type', 'invoice')
            ->get();

        foreach ($taxInvoices as $taxInvoice) {
            DB::table('invoices')->insert([
                'invoice_no' => $taxInvoice->doc_number,
                'invoice_date' => $taxInvoice->doc_date,
                'customer_code' => $taxInvoice->customer_code,
                'customer_name' => $taxInvoice->customer_name,
                'customer_address' => $taxInvoice->customer_address,
                'customer_tax_id' => $taxInvoice->customer_tax_id,
                'customer_phone' => null, // ไม่มีใน tax_invoices
                'customer_email' => null, // ไม่มีใน tax_invoices
                'reference_doc' => $taxInvoice->selected_document,
                'shipping_address' => $taxInvoice->shipping_address,
                'shipping_phone' => $taxInvoice->shipping_phone,
                'items' => $taxInvoice->items,
                'notes' => $taxInvoice->notes,
                'discount' => $taxInvoice->discount,
                'vat_rate' => $taxInvoice->vat_rate,
                'subtotal' => $taxInvoice->subtotal,
                'discount_amount' => $taxInvoice->discount_amount,
                'after_discount' => $taxInvoice->after_discount,
                'vat' => $taxInvoice->vat,
                'grand_total' => $taxInvoice->grand_total,
                'status' => $taxInvoice->status,
                'due_date' => null, // ไม่มีใน tax_invoices
                'created_at' => $taxInvoice->created_at,
                'updated_at' => $taxInvoice->updated_at,
            ]);
        }

        // ลบข้อมูล invoice ออกจาก tax_invoices (optional - ถ้าต้องการเก็บไว้ก็ comment บรรทัดนี้)
        // DB::table('tax_invoices')->where('document_type', 'invoice')->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // ย้อนกลับ: ลบข้อมูลที่ย้ายไป
        DB::table('invoices')->truncate();
    }
}

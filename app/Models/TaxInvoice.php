<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'doc_number',
        'document_type',
        'doc_date',
        'customer_code',
        'customer_name',
        'customer_address',
        'customer_tax_id',
        'selected_document',
        'shipping_address',
        'shipping_phone',
        'items',
        'notes',
        'discount',
        'vat_rate',
        'subtotal',
        'discount_amount',
        'after_discount',
        'vat',
        'grand_total',
        'status',
    ];

    protected $casts = [
        'items' => 'array',
        'doc_date' => 'date',
        'discount' => 'decimal:2',
        'vat_rate' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'after_discount' => 'decimal:2',
        'vat' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];
}

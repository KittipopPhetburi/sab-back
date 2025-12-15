<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'invoice_date',
        'customer_code',
        'customer_name',
        'seller_name',
        'customer_address',
        'customer_tax_id',
        'customer_phone',
        'customer_email',
        'reference_doc',
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
        'due_date',
        'doc_type',
    ];

    protected $casts = [
        'items' => 'array',
        'invoice_date' => 'date',
        'due_date' => 'date',
        'discount' => 'decimal:2',
        'vat_rate' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'after_discount' => 'decimal:2',
        'vat' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    protected $appends = ['doc_type_label'];

    /**
     * Get the Thai label for doc_type
     */
    public function getDocTypeLabelAttribute()
    {
        $labels = [
            'original' => 'ต้นฉบับ',
            'copy' => 'สำเนา',
        ];

        return isset($labels[$this->doc_type]) ? $labels[$this->doc_type] : $this->doc_type;
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_number',
        'date',
        'supplier',
        'supplier_code',
        'supplier_name',
        'supplier_address',
        'supplier_tax_id',
        'supplier_phone',
        'supplier_email',
        'reference_doc',
        'shipping_address',
        'shipping_phone',
        'items',
        'description',
        'notes',
        'discount',
        'vat_rate',
        'subtotal',
        'discount_amount',
        'after_discount',
        'vat',
        'grand_total',
        'amount',
        'status',
        'expected_delivery_date',
        'buyer_name',
        'buyer_phone',
        'buyer_email',
        'doc_type',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
        'items' => 'array',
        'discount' => 'decimal:2',
        'vat_rate' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'after_discount' => 'decimal:2',
        'vat' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'expected_delivery_date' => 'date',
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


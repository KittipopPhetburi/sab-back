<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_number',
        'date',
        'seller_name',
        'seller_phone',
        'seller_email',
        'customer',
        'customer_code',
        'customer_name',
        'customer_address',
        'customer_tax_id',
        'customer_phone',
        'customer_email',
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
        'valid_until',
        'doc_type',
    ];

    protected $casts = [
        'date' => 'date',
        'valid_until' => 'date',
        'amount' => 'decimal:2',
        'items' => 'array',
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
        switch ($this->doc_type) {
            case 'original':
                return 'ต้นฉบับ';
            case 'copy':
                return 'สำเนา';
            default:
                return $this->doc_type;
        }
    }

}


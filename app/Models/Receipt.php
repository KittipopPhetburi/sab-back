<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_no',
        'date',
        'customer',
        'customer_code',
        'customer_branch_name',
        'seller_name',
        'salesperson',
        'branch_name',
        'customer_address',
        'customer_tax_id',
        'customer_phone',
        'customer_email',
        'shipping_address',
        'shipping_phone',
        'discount',
        'vat_rate',
        'subtotal',
        'discount_amount',
        'after_discount',
        'vat',
        'grand_total',
        'invoice_ref',
        'amount',
        'description',
        'qty',
        'unit',
        'items',
        'notes',
        'status',
        'doc_type',
    ];

    protected $casts = [
        'items' => 'array',
        'date' => 'date',
        'amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'after_discount' => 'decimal:2',
        'vat' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    protected $appends = ['doc_type_label'];

    public function getDocTypeLabelAttribute()
    {
        return match($this->doc_type) {
            'original' => 'ตนฉบบ',
            'copy' => 'สำเนา',
            default => $this->doc_type,
        };
    }
}
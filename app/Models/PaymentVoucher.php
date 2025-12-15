<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentVoucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_no',
        'date',
        'payee',
        'payee_id',
        'description',
        'amount',
        'status',
        'payment_method',
        'withholding_tax_no',
        'withholding_tax_amount',
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
        'grand_total',
        'doc_type',
    ];

    protected $casts = [
        'date' => 'date',
        'payment_date' => 'date',
        'amount' => 'decimal:2',
        'withholding_tax_amount' => 'decimal:2',
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

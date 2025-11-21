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
        'seller_name',
        'customer_address',
        'customer_tax_id',
        'customer_phone',
        'customer_email',
        'invoice_ref',
        'amount',
        'description',
        'status',
        'doc_type',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    protected $appends = ['doc_type_label'];

    /**
     * Get the Thai label for doc_type
     */
    public function getDocTypeLabelAttribute()
    {
        return match($this->doc_type) {
            'original' => 'ต้นฉบับ',
            'copy' => 'สำเนา',
            default => $this->doc_type,
        };
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type',
        'category_id',
        'quantity',
        'unit',
        'purchase_price',
        'sale_price',
        'description',
        'status',
        // Legacy fields for backward compatibility
        'price',
        'stock',
    ];

    public function category()
{
    return $this->belongsTo(Category::class, 'category_id');
}
}



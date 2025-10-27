<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type',
        'branch_name',
        'tax_id',
        'contact_person',
        'phone',
        'email',
        'address',
        'note',
        'account_name',
        'bank_account',
        'bank_name',
        'status',
    ];
}

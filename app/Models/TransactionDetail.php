<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'transactions_id',
        'products_id',
        'stores_id',
        'price',
        'qty',
        'shipping_status',
        'resi',
        'code',
        'address_one',
        'address_two',
        'provinces_id',
        'regencies_id',
        'zip_code',
        'country',
        'phone_number',

    ];

    protected $hidden = [];

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'id', 'transactions_id');
    }
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'products_id');
    }
    public function store()
    {
        return $this->hasOne(Store::class, 'id', 'stores_id');
    }
}

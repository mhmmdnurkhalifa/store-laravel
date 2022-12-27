<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsGallery extends Model
{
    protected $fillable = ['photos', 'products_id'];

    protected $hidden = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id', 'id'); //->wthTranshed untuk memanggil data yang sudah dihapus
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'users_id', 'categories_id', 'stores_id', 'price', 'qty', 'description', 'slug'];

    protected $hidden = [];

    public function galleries()
    {
        return $this->hasMany(ProductsGallery::class, 'products_id', 'id'); //->wthTranshed untuk memanggil data yang sudah dihapus
    }
    
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'users_id');
    }

    public function store()
    {
        return $this->hasOne(Store::class, 'id', 'stores_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id', 'id');
    }
}

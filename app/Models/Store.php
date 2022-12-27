<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;

    protected $fillable = ['users_id', 'store_name', 'account_number', 'store_status'];

    protected $hidden = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'users_id');
    }

}

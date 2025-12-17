<?php

namespace App\Models;

use App\HasTrash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory, SoftDeletes, HasTrash;

    protected $fillable = ['name','address','phone'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

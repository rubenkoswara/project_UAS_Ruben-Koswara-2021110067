<?php

namespace App\Models;

use App\HasTrash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes, HasTrash;

    protected $fillable = [
        'user_id',
        'total',
        'status',
        'payment_method',
        'shipping_info',
        'payment_proof',   // ← WAJIB ADA
        'receipt',         // foto resi
        'delivery_proof',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function returns()
    {
        return $this->hasMany(ReturnRequest::class);
    }
}

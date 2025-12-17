<?php

namespace App\Models;

use App\HasTrash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnRequest extends Model
{
    use HasFactory, HasTrash, SoftDeletes;

    protected $table = 'returns';

    protected $fillable = [
        'order_id',
        'order_item_id',
        'user_id',
        'status',
        'reason',         
        'item_proof',  
        'shipment_proof',           
        'admin_reason',   
        'refund_proof',   
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isReviewed()
    {
        return in_array($this->status, ['reviewed', 'rejected']);
    }

    public function isShipped()
    {
        return $this->status === 'shipped';
    }

    public function isReceived()
    {
        return in_array($this->status, ['received', 'received_rejected']);
    }
}

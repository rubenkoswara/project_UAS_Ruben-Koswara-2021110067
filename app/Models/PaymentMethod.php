<?php

namespace App\Models;

use App\HasTrash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use HasFactory, SoftDeletes, HasTrash;

    protected $fillable = [
        'name','bank_name','account_number','account_name'
    ];
}

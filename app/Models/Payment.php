<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'order_id', 
        'user_id', 
        'amount', 
        'received_amount', 
        'change_amount', 
        'payment_method', 
        'transaction_id', 
        'status'
    ];

    protected $casts = [
        'amount' => 'float',
        'received_amount' => 'float',
        'change_amount' => 'float'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 
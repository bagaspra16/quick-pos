<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = ['number', 'capacity', 'status', 'barcode'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function activeOrder()
    {
        return $this->orders()
            ->whereIn('status', ['pending', 'processing'])
            ->latest()
            ->first();
    }
} 
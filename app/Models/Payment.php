<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'transaction_id',
        'total_price',
        'transaction_status',
        'serial_number',
        'payment_type',
        'payment_code',
        'pdf_url',
        'delivery_cost',
        'delivery_service',
        'status_code',
        'created_by',
        'updated_by',
        'session_id'
    ];

    public function order(): HasOne
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
}

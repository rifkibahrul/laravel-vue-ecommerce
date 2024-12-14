<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'address', 'city', 'province', 'zipcode', 'user_id'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_id', 'user_id');
    }
}

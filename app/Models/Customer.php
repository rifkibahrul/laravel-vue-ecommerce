<?php

namespace App\Models;

use App\Enums\AddressType;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    protected $fillable = ['first_name', 'last_name', 'phone', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customerAddress(): HasOne
    {
        return $this->hasOne(CustomerAddress::class, 'user_id', 'user_id');
    }
}
<?php

namespace App\Models;

use App\Models\Traits\CanBeDefault;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use CanBeDefault, HasFactory;

    protected $fillable = [
        'user_id',
        'country_id',
        'name',
        'address_1',
        'city',
        'postal_code',
        'default'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
}

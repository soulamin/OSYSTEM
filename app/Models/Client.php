<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'document',
        'phone',
        'email',
        'zip',
        'street',
        'number',
        'complement',
        'district',
        'city',
        'state',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}

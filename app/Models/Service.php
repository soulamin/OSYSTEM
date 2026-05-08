<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'value',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
        ];
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_service')
            ->withPivot(['quantity', 'unit_value'])
            ->withTimestamps();
    }
}

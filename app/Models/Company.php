<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'cnpj',
        'logo_image',
        'zip',
        'street',
        'number',
        'complement',
        'district',
        'city',
        'state',
        'phone',
        'email',
    ];
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSetting extends Model
{
    protected $table = 'email_settings';

    protected $fillable = [
        'enabled',
        'mailer',
        'host',
        'port',
        'username',
        'password_encrypted',
        'encryption',
        'from_address',
        'from_name',
    ];

    protected $casts = [
        'enabled' => 'bool',
        'port' => 'int',
    ];
}

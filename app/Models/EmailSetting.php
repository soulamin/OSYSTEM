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
        'body_html',
        'body_html_opened',
        'body_html_closed',
    ];

    protected $casts = [
        'enabled' => 'bool',
        'port' => 'int',
    ];
}

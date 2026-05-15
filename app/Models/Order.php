<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    public const STATUS_ABERTA = 'aberta';
    public const STATUS_EM_ANDAMENTO = 'em_andamento';
    public const STATUS_FINALIZADA = 'finalizada';
    public const STATUS_CANCELADA = 'cancelada';

    protected $fillable = [
        'number',
        'client_id',
        'category_id',
        'client_name',
        'client_document',
        'responsible_user_id',
        'status',
        'opened_at',
        'closed_at',
        'notes',
        'solution',
        'signature_image',
        'signature_signed_at',
        'pdf_path',
        'pdf_generated_at',
        'total_value',
    ];

    protected function casts(): array
    {
        return [
            'opened_at' => 'datetime',
            'closed_at' => 'datetime',
            'signature_signed_at' => 'datetime',
            'pdf_generated_at' => 'datetime',
            'total_value' => 'decimal:2',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(OrderCategory::class, 'category_id');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'order_service')
            ->withPivot(['quantity', 'unit_value'])
            ->withTimestamps();
    }
}

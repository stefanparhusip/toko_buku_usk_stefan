<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'created_at',
        'read_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    /**
     * User who sends this message.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * User who receives this message.
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}

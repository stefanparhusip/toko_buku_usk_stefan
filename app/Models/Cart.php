<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'quantity',
        'total_price',
    ];

    /**
     * Get the user that owns this cart item.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that belongs to this cart item.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}

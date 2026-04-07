<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public const PAYMENT_COD = 'COD';
    public const PAYMENT_BANK_TRANSFER = 'BANK_TRANSFER';

    public const STATUS_PENDING = 'pending';
    public const STATUS_WAITING_VERIFICATION = 'menunggu verifikasi';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_COMPLETED = 'completed';

    protected $fillable = [
        'user_id',
        'order_code',
        'nama_penerima',
        'phone',
        'address',
        'city',
        'postal_code',
        'total_price',
        'total_payment',
        'status',
        'payment_method',
        'resi',
    ];

    protected $appends = [
        'display_total',
    ];

    /**
     * Get the user that owns this order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all order details that belong to this order.
     */
    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * Keep total display stable for old and new schema.
     */
    public function getDisplayTotalAttribute(): int
    {
        return (int) ($this->total_price ?? $this->total_payment ?? 0);
    }
}

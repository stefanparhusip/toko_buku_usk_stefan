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
    public const PAYMENT_BANK_TRANSFER = 'transfer';
    public const PAYMENT_BANK_TRANSFER_LEGACY = 'BANK_TRANSFER';
    public const PAYMENT_OFFLINE = 'offline';

    public const PAYMENT_STATUS_PENDING = 'pending';
    public const PAYMENT_STATUS_PAID = 'paid';

    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_SHIPPED = 'shipped';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

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
        'payment_status',
        'receipt_number',
        'resi',
    ];

    protected $appends = [
        'display_total',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function getDisplayTotalAttribute(): int
    {
        return (int) ($this->total_price ?? $this->total_payment ?? 0);
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match ((string) $this->payment_method) {
            self::PAYMENT_COD => 'COD',
            self::PAYMENT_BANK_TRANSFER,
            self::PAYMENT_BANK_TRANSFER_LEGACY => 'Transfer',
            self::PAYMENT_OFFLINE => 'Bayar Langsung',
            default => (string) $this->payment_method,
        };
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match ((string) $this->payment_status) {
            self::PAYMENT_STATUS_PAID => 'Paid',
            default => 'Pending',
        };
    }

    public function isBankTransferPayment(): bool
    {
        return in_array((string) $this->payment_method, [self::PAYMENT_BANK_TRANSFER, self::PAYMENT_BANK_TRANSFER_LEGACY], true);
    }

    public function isOfflinePayment(): bool
    {
        return (string) $this->payment_method === self::PAYMENT_OFFLINE;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ((string) $this->status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PAID => 'Paid',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_SHIPPED => 'Shipped',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled',
            default => ucfirst((string) $this->status),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ((string) $this->status) {
            self::STATUS_PENDING => 'text-bg-warning',
            self::STATUS_PAID => 'text-bg-primary',
            self::STATUS_PROCESSING => 'bg-purple text-white',
            self::STATUS_SHIPPED => 'bg-orange text-white',
            self::STATUS_COMPLETED => 'text-bg-success',
            self::STATUS_CANCELLED => 'text-bg-danger',
            default => 'text-bg-secondary',
        };
    }

    public function canTransitionTo(string $targetStatus): bool
    {
        $allowedTransitions = [
            self::STATUS_PENDING => [self::STATUS_PAID, self::STATUS_CANCELLED],
            self::STATUS_PAID => [self::STATUS_PROCESSING, self::STATUS_CANCELLED],
            self::STATUS_PROCESSING => [self::STATUS_SHIPPED],
            self::STATUS_SHIPPED => [self::STATUS_COMPLETED],
            self::STATUS_COMPLETED => [],
            self::STATUS_CANCELLED => [],
        ];

        return in_array($targetStatus, $allowedTransitions[(string) $this->status] ?? [], true);
    }
}

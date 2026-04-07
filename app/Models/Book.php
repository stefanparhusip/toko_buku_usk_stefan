<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'author',
        'publisher',
        'year',
        'price',
        'stock',
        'description',
        'image',
        'image_url',
        'is_featured',
        'is_recommended',
        'is_new',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_recommended' => 'boolean',
        'is_new' => 'boolean',
    ];

    /**
     * Get the category that owns this book.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all order details for this book.
     */
    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * Get all carts containing this book.
     */
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get formatted rupiah price for display.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format((int) $this->price, 0, ',', '.');
    }

    /**
     * Resolve book image source from external URL or local storage file.
     */
    public function getImageSourceAttribute(): ?string
    {
        if (! empty($this->image_url)) {
            return $this->image_url;
        }

        if (! empty($this->image)) {
            return asset('storage/' . $this->image);
        }

        return null;
    }
}

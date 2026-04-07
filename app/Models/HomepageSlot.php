<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomepageSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'position',
        'name',
        'title',
        'description',
        'image',
        'image_url',
        'book_id',
        'link',
        'type',
        'is_active',
    ];

    protected $casts = [
        'position' => 'integer',
        'book_id' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the book assigned to this slot when type is book.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Resolve slot image source from external URL or local storage file.
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomepageSlotItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'slot_id',
        'slot_position',
        'title',
        'description',
        'image',
        'image_url',
        'button_text',
        'link',
        'order_number',
        'is_active',
    ];

    protected $casts = [
        'slot_id' => 'integer',
        'slot_position' => 'integer',
        'order_number' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Parent slot for this item.
     */
    public function slot(): BelongsTo
    {
        return $this->belongsTo(HomepageSlot::class, 'slot_id');
    }

    /**
     * Resolve item image source from storage file.
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

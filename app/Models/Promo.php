<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'discount',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function scopeActiveAndValid(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->where(function (Builder $q) {
                $q->whereNull('start_date')
                    ->orWhereDate('start_date', '<=', now()->toDateString());
            })
            ->where(function (Builder $q) {
                $q->whereNull('end_date')
                    ->orWhereDate('end_date', '>=', now()->toDateString());
            });
    }
}

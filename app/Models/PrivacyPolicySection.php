<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PrivacyPolicySection extends Model
{
    protected $fillable = [
        'slug',
        'title_ar',
        'title_en',
        'subtitle_ar',
        'subtitle_en',
        'details_ar',
        'details_en',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getLocalizedTitleAttribute(): string
    {
        return app()->isLocale('en')
            ? ($this->title_en ?: $this->title_ar)
            : $this->title_ar;
    }

    public function getLocalizedSubtitleAttribute(): ?string
    {
        return app()->isLocale('en')
            ? ($this->subtitle_en ?: $this->subtitle_ar)
            : $this->subtitle_ar;
    }

    public function getLocalizedDetailsAttribute(): string
    {
        return app()->isLocale('en')
            ? ($this->details_en ?: $this->details_ar)
            : $this->details_ar;
    }
}

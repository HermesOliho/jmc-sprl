<?php

namespace App\Models;

use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $icon
 * @property array<int, string>|null $deliverables
 * @property array<int, string>|null $benefits
 * @property bool $is_featured
 * @property int $home_sort_order
 * @property bool $is_active
 * @property int $sort_order
 * @property string|null $image_alt
 * @property string $image_position
 */
#[Fillable([
    'slug',
    'title',
    'description',
    'icon',
    'deliverables',
    'benefits',
    'is_featured',
    'home_sort_order',
    'is_active',
    'sort_order',
    'image_alt',
    'image_position',
])]
class Service extends Model implements HasMedia
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory, InteractsWithMedia;

    /**
     * @var list<string>
     */
    protected $appends = ['cover_url'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('card')
            ->fit(Fit::Crop, 1200, 675)
            ->nonQueued();

        $this->addMediaConversion('thumb')
            ->fit(Fit::Crop, 640, 360)
            ->nonQueued();
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'deliverables' => 'array',
            'benefits' => 'array',
            'is_featured' => 'boolean',
            'home_sort_order' => 'integer',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * @param  Builder<Service>  $query
     * @return Builder<Service>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * @param  Builder<Service>  $query
     * @return Builder<Service>
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * @param  Builder<Service>  $query
     * @return Builder<Service>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }

    /**
     * @param  Builder<Service>  $query
     * @return Builder<Service>
     */
    public function scopeHomeOrdered(Builder $query): Builder
    {
        return $query->orderBy('home_sort_order')->orderBy('sort_order');
    }

    public function getCoverUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('cover', 'card')
            ?: $this->getFirstMediaUrl('cover')
            ?: null;
    }
}

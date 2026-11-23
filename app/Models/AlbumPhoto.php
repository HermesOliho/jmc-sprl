<?php

namespace App\Models;

use Database\Factories\AlbumPhotoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * @property int $album_id
 * @property string|null $caption
 * @property string|null $alt_text
 * @property bool $is_published
 * @property int $sort_order
 * @property string|null $thumb_url
 * @property string|null $card_url
 * @property string|null $large_url
 * @property-read string $alt
 * @property-read Album|null $album
 */
#[Fillable(['album_id', 'caption', 'alt_text', 'is_published', 'sort_order'])]
class AlbumPhoto extends Model implements HasMedia
{
    /** @use HasFactory<AlbumPhotoFactory> */
    use HasFactory, InteractsWithMedia;

    /**
     * @var list<string>
     */
    protected $appends = ['thumb_url', 'card_url', 'large_url'];

    /**
     * @return BelongsTo<Album, $this>
     */
    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Fit::Crop, 480, 480)
            ->nonQueued();

        $this->addMediaConversion('card')
            ->fit(Fit::Crop, 1200, 800)
            ->nonQueued();

        $this->addMediaConversion('large')
            ->fit(Fit::Max, 1920, 1920)
            ->nonQueued();
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * @param  Builder<AlbumPhoto>  $query
     * @return Builder<AlbumPhoto>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * @param  Builder<AlbumPhoto>  $query
     * @return Builder<AlbumPhoto>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function getThumbUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('image', 'thumb')
            ?: $this->getFirstMediaUrl('image')
            ?: null;
    }

    public function getCardUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('image', 'card')
            ?: $this->getFirstMediaUrl('image')
            ?: null;
    }

    public function getLargeUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('image', 'large')
            ?: $this->getFirstMediaUrl('image')
            ?: null;
    }

    public function getAltAttribute(): string
    {
        return $this->alt_text
            ?: $this->caption
            ?: $this->album?->title
            ?: 'Photo de l’album';
    }

    protected static function booted(): void
    {
        static::deleting(function (AlbumPhoto $photo): void {
            $photo->album()
                ->where('cover_photo_id', $photo->id)
                ->update(['cover_photo_id' => null]);
        });
    }
}

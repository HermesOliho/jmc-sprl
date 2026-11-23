<?php

namespace App\Models;

use Database\Factories\AlbumFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string|null $description
 * @property string|null $location
 * @property Carbon|null $event_date
 * @property bool $is_published
 * @property int $sort_order
 * @property int|null $cover_photo_id
 * @property string|null $cover_url
 */
#[Fillable([
    'slug',
    'title',
    'description',
    'location',
    'event_date',
    'is_published',
    'sort_order',
    'cover_photo_id',
])]
class Album extends Model
{
    /** @use HasFactory<AlbumFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $appends = ['cover_url'];

    /**
     * @return HasMany<AlbumPhoto, $this>
     */
    public function photos(): HasMany
    {
        return $this->hasMany(AlbumPhoto::class);
    }

    /**
     * @return BelongsTo<AlbumPhoto, $this>
     */
    public function coverPhoto(): BelongsTo
    {
        return $this->belongsTo(AlbumPhoto::class, 'cover_photo_id');
    }

    /**
     * @return HasOne<AlbumPhoto, $this>
     */
    public function firstPublishedPhoto(): HasOne
    {
        return $this->hasOne(AlbumPhoto::class)->published()->ordered();
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * @param  Builder<Album>  $query
     * @return Builder<Album>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * @param  Builder<Album>  $query
     * @return Builder<Album>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderBy('sort_order')
            ->orderByDesc('event_date')
            ->orderByDesc('id');
    }

    public function getCoverUrlAttribute(): ?string
    {
        $photo = $this->coverPhoto;

        if ($photo === null || ! $photo->is_published) {
            $photo = $this->firstPublishedPhoto;
        }

        return $photo?->card_url;
    }

    protected static function booted(): void
    {
        static::deleting(function (Album $album): void {
            $album->photos()->get()->each->delete();
        });
    }
}

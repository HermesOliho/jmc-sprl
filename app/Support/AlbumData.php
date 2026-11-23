<?php

namespace App\Support;

use App\Models\Album;
use App\Models\AlbumPhoto;

class AlbumData
{
    /**
     * @return array<string, mixed>
     */
    public static function card(Album $album): array
    {
        return [
            'slug' => $album->slug,
            'title' => $album->title,
            'description' => $album->description,
            'location' => $album->location,
            'event_date' => $album->event_date?->toDateString(),
            'cover_url' => $album->cover_url,
            'photo_count' => (int) ($album->published_photos_count ?? 0),
            'url' => route('album.show', $album->slug),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function detail(Album $album): array
    {
        return self::card($album);
    }

    /**
     * @return array<string, mixed>
     */
    public static function photo(AlbumPhoto $photo, ?Album $album = null): array
    {
        $album ??= $photo->album;

        return [
            'id' => $photo->id,
            'caption' => $photo->caption,
            'alt' => $photo->alt_text
                ?: $photo->caption
                ?: $album?->title
                ?: 'Photo de l’album',
            'thumb_url' => $photo->thumb_url,
            'card_url' => $photo->card_url,
            'large_url' => $photo->large_url,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function latestPhoto(AlbumPhoto $photo): array
    {
        $album = $photo->album;

        return [
            ...self::photo($photo, $album),
            'album' => [
                'title' => $album?->title ?? '',
                'slug' => $album?->slug ?? '',
                'url' => $album !== null ? route('album.show', $album->slug) : '',
                'event_date' => $album?->event_date?->toDateString(),
            ],
        ];
    }

    /**
     * @param  iterable<int, AlbumPhoto>  $photos
     * @return array<int, array<string, mixed>>
     */
    public static function latestPhotos(iterable $photos): array
    {
        $result = [];

        foreach ($photos as $photo) {
            $result[] = self::latestPhoto($photo);
        }

        return $result;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\AlbumPhoto;
use App\Support\AlbumData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class AlbumController extends Controller
{
    public function index(): Response
    {
        $albums = Album::query()
            ->published()
            ->ordered()
            ->with(['coverPhoto.media', 'firstPublishedPhoto.media'])
            ->withCount([
                'photos as published_photos_count' => fn (Builder $query): Builder => $query->published(),
            ])
            ->paginate(12)
            ->withQueryString()
            ->through(fn (Album $album): array => AlbumData::card($album));

        return Inertia::render('Public/Album/Index', [
            'seo' => config('site.pages.album'),
            'albums' => $albums,
        ]);
    }

    public function show(Album $album): Response
    {
        abort_unless($album->is_published, 404);

        $album->load([
            'coverPhoto.media',
            'firstPublishedPhoto.media',
        ])->loadCount([
            'photos as published_photos_count' => fn (Builder $query): Builder => $query->published(),
        ]);

        $photos = $album->photos()
            ->published()
            ->ordered()
            ->with('media')
            ->paginate(24)
            ->withQueryString()
            ->through(fn (AlbumPhoto $photo): array => AlbumData::photo($photo, $album));

        $description = Str::limit(
            $album->description ?: 'Découvrez les photos de l’album '.$album->title.' de JMC Services S.P.R.L.',
            155,
        );

        return Inertia::render('Public/Album/Show', [
            'seo' => [
                'title' => $album->title,
                'description' => $description,
                'path' => '/album/'.$album->slug,
                'type' => 'CollectionPage',
                'og_image' => $album->cover_url,
            ],
            'album' => AlbumData::detail($album),
            'photos' => $photos,
        ]);
    }
}

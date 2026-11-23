<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAlbumRequest;
use App\Http\Requests\Admin\UpdateAlbumRequest;
use App\Models\Album;
use App\Models\AlbumPhoto;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class AlbumController extends Controller
{
    public function index(): Response
    {
        $this->authorize('viewAny', Album::class);

        $albums = Album::query()
            ->ordered()
            ->with(['coverPhoto.media', 'firstPublishedPhoto.media'])
            ->withCount([
                'photos',
                'photos as published_photos_count' => fn (Builder $query): Builder => $query->published(),
            ])
            ->get()
            ->map(fn (Album $album): array => [
                'id' => $album->id,
                'slug' => $album->slug,
                'title' => $album->title,
                'location' => $album->location,
                'event_date' => $album->event_date?->toDateString(),
                'is_published' => $album->is_published,
                'sort_order' => $album->sort_order,
                'cover_url' => $album->cover_url,
                'photo_count' => $album->photos_count,
                'published_photo_count' => $album->published_photos_count,
                'created_at' => $album->created_at?->toDateTimeString(),
            ]);

        return Inertia::render('Admin/Albums/Index', [
            'albums' => $albums,
        ]);
    }

    public function create(): Response
    {
        $this->authorize('create', Album::class);

        return Inertia::render('Admin/Albums/Create');
    }

    public function store(StoreAlbumRequest $request): RedirectResponse
    {
        $this->authorize('create', Album::class);

        $validated = $request->validated();

        $slug = filled($validated['slug'] ?? null)
            ? Str::slug($validated['slug'])
            : Str::slug($validated['title']);

        $album = Album::query()->create([
            'slug' => $this->uniqueSlug($slug),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'location' => $validated['location'] ?? null,
            'event_date' => $validated['event_date'] ?? null,
            'is_published' => $request->boolean('is_published'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return Redirect::route('admin.albums.edit', $album)
            ->with('status', 'Album créé avec succès. Ajoutez maintenant vos photos.');
    }

    public function edit(Album $album): Response
    {
        $this->authorize('update', $album);

        $album->load([
            'coverPhoto.media',
            'firstPublishedPhoto.media',
        ])->loadCount([
            'photos',
            'photos as published_photos_count' => fn (Builder $query): Builder => $query->published(),
        ]);

        $photos = $album->photos()
            ->ordered()
            ->with('media')
            ->get()
            ->map(fn (AlbumPhoto $photo): array => [
                'id' => $photo->id,
                'caption' => $photo->caption,
                'alt_text' => $photo->alt_text,
                'is_published' => $photo->is_published,
                'sort_order' => $photo->sort_order,
                'thumb_url' => $photo->thumb_url,
                'is_cover' => $album->cover_photo_id === $photo->id,
            ]);

        return Inertia::render('Admin/Albums/Edit', [
            'album' => [
                'id' => $album->id,
                'slug' => $album->slug,
                'title' => $album->title,
                'description' => $album->description,
                'location' => $album->location,
                'event_date' => $album->event_date?->toDateString(),
                'is_published' => $album->is_published,
                'sort_order' => $album->sort_order,
                'cover_url' => $album->cover_url,
                'photo_count' => $album->photos_count,
                'published_photo_count' => $album->published_photos_count,
            ],
            'photos' => $photos,
        ]);
    }

    public function update(UpdateAlbumRequest $request, Album $album): RedirectResponse
    {
        $this->authorize('update', $album);

        $validated = $request->validated();

        $slug = filled($validated['slug'] ?? null)
            ? $this->uniqueSlug(Str::slug($validated['slug']), $album->id)
            : $album->slug;

        $album->update([
            'slug' => $slug,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'location' => $validated['location'] ?? null,
            'event_date' => $validated['event_date'] ?? null,
            'is_published' => $request->boolean('is_published'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return Redirect::route('admin.albums.edit', $album)
            ->with('status', 'Album mis à jour avec succès.');
    }

    public function destroy(Album $album): RedirectResponse
    {
        $this->authorize('delete', $album);

        $album->delete();

        return Redirect::route('admin.albums.index')
            ->with('status', 'Album supprimé avec succès.');
    }

    private function uniqueSlug(string $source, ?int $ignoreId = null): string
    {
        $base = $source !== '' ? $source : Str::random(8);
        $candidate = $base;
        $counter = 2;

        while (Album::query()
            ->where('slug', $candidate)
            ->when($ignoreId !== null, fn (Builder $query): Builder => $query->whereKeyNot($ignoreId))
            ->exists()
        ) {
            $candidate = $base.'-'.$counter;
            $counter++;
        }

        return $candidate;
    }
}

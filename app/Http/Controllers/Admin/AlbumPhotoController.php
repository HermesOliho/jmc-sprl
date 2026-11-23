<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReorderAlbumPhotosRequest;
use App\Http\Requests\Admin\StoreAlbumPhotosRequest;
use App\Http\Requests\Admin\UpdateAlbumPhotoRequest;
use App\Models\Album;
use App\Models\AlbumPhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AlbumPhotoController extends Controller
{
    public function store(StoreAlbumPhotosRequest $request, Album $album): RedirectResponse
    {
        $this->authorize('create', AlbumPhoto::class);

        /** @var array<int, UploadedFile> $files */
        $files = $request->file('photos', []);
        $sortOrder = (int) ($album->photos()->max('sort_order') ?? -1) + 1;

        DB::transaction(function () use ($album, $files, &$sortOrder): void {
            foreach ($files as $file) {
                $photo = $album->photos()->create([
                    'caption' => null,
                    'alt_text' => null,
                    'is_published' => true,
                    'sort_order' => $sortOrder++,
                ]);

                $photo->addMedia($file)
                    ->usingName(Str::slug($album->title.' '.$photo->id))
                    ->toMediaCollection('image');

                if ($album->cover_photo_id === null) {
                    $album->update(['cover_photo_id' => $photo->id]);
                }
            }
        });

        return Redirect::route('admin.albums.edit', $album)
            ->with('status', 'Photos ajoutées avec succès.');
    }

    public function update(UpdateAlbumPhotoRequest $request, Album $album, AlbumPhoto $albumPhoto): RedirectResponse
    {
        $this->authorize('update', $albumPhoto);
        $this->ensureBelongsToAlbum($album, $albumPhoto);

        $validated = $request->validated();

        $attributes = [];

        if ($request->exists('caption')) {
            $attributes['caption'] = $validated['caption'] ?? null;
        }

        if ($request->exists('alt_text')) {
            $attributes['alt_text'] = $validated['alt_text'] ?? null;
        }

        if ($request->exists('is_published')) {
            $attributes['is_published'] = $request->boolean('is_published');
        }

        $albumPhoto->update($attributes);

        if ($request->boolean('is_cover')) {
            $album->update(['cover_photo_id' => $albumPhoto->id]);
        }

        return Redirect::route('admin.albums.edit', $album)
            ->with('status', 'Photo mise à jour avec succès.');
    }

    public function reorder(ReorderAlbumPhotosRequest $request, Album $album): RedirectResponse
    {
        $this->authorize('update', $album);

        /** @var array<int, int> $photoIds */
        $photoIds = $request->validated('photo_ids');

        DB::transaction(function () use ($album, $photoIds): void {
            foreach ($photoIds as $position => $photoId) {
                $album->photos()
                    ->whereKey($photoId)
                    ->update(['sort_order' => $position]);
            }
        });

        return Redirect::route('admin.albums.edit', $album)
            ->with('status', 'Ordre des photos mis à jour.');
    }

    public function destroy(Album $album, AlbumPhoto $albumPhoto): RedirectResponse
    {
        $this->authorize('delete', $albumPhoto);
        $this->ensureBelongsToAlbum($album, $albumPhoto);

        $albumPhoto->delete();

        return Redirect::route('admin.albums.edit', $album)
            ->with('status', 'Photo supprimée avec succès.');
    }

    private function ensureBelongsToAlbum(Album $album, AlbumPhoto $albumPhoto): void
    {
        abort_unless($albumPhoto->album_id === $album->id, 404);
    }
}

<?php

use App\Models\Album;
use App\Models\AlbumPhoto;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

beforeEach(function () {
    config()->set('inertia.testing.ensure_pages_exist', false);
    Storage::fake('public');
    config()->set('media-library.disk_name', 'public');
});

function uploadAlbumPhoto(Album $album, array $attributes = []): AlbumPhoto
{
    $photo = AlbumPhoto::factory()->for($album)->create($attributes);
    $photo->addMedia(UploadedFile::fake()->image('photo-'.$photo->id.'.jpg', 1200, 800))
        ->toMediaCollection('image');

    return $photo;
}

test('un administrateur peut ajouter plusieurs photos à un album', function () {
    $user = adminUser();
    $album = Album::factory()->create();

    $response = $this->actingAs($user)->post(route('admin.albums.photos.store', $album), [
        'photos' => [
            UploadedFile::fake()->image('une.jpg', 1200, 800),
            UploadedFile::fake()->image('deux.png', 1200, 800),
        ],
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.albums.edit', $album));

    $photos = $album->photos()->ordered()->get();

    expect($photos)->toHaveCount(2);
    expect($photos[0]->sort_order)->toBe(0);
    expect($photos[1]->sort_order)->toBe(1);
    expect($photos[0]->getFirstMedia('image'))->not->toBeNull();
    expect($photos[1]->getFirstMedia('image'))->not->toBeNull();

    $album->refresh();

    expect($album->cover_photo_id)->toBe($photos[0]->id);
});

test('les photos ajoutées sont publiées par défaut', function () {
    $user = adminUser();
    $album = Album::factory()->create();

    $this->actingAs($user)->post(route('admin.albums.photos.store', $album), [
        'photos' => [UploadedFile::fake()->image('photo.jpg', 1200, 800)],
    ])->assertSessionHasNoErrors();

    expect($album->photos()->first()?->is_published)->toBeTrue();
});

test('un fichier non image est refusé', function () {
    $user = adminUser();
    $album = Album::factory()->create();

    $this->actingAs($user)
        ->post(route('admin.albums.photos.store', $album), [
            'photos' => [UploadedFile::fake()->create('document.pdf', 100, 'application/pdf')],
        ])
        ->assertSessionHasErrors('photos.0');

    expect($album->photos()->count())->toBe(0);
});

test('un administrateur peut modifier les informations d’une photo', function () {
    $user = adminUser();
    $album = Album::factory()->create();
    $photo = uploadAlbumPhoto($album);

    $this->actingAs($user)
        ->patch(route('admin.albums.photos.update', [$album, $photo]), [
            'caption' => 'Vue du chantier',
            'alt_text' => 'Chantier en cours à Durba',
            'is_published' => false,
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.albums.edit', $album));

    $photo->refresh();

    expect($photo->caption)->toBe('Vue du chantier');
    expect($photo->alt_text)->toBe('Chantier en cours à Durba');
    expect($photo->is_published)->toBeFalse();
});

test('un administrateur peut effacer la légende d’une photo', function () {
    $user = adminUser();
    $album = Album::factory()->create();
    $photo = uploadAlbumPhoto($album, ['caption' => 'Ancienne légende']);

    $this->actingAs($user)
        ->patch(route('admin.albums.photos.update', [$album, $photo]), [
            'caption' => '',
            'alt_text' => '',
        ])
        ->assertSessionHasNoErrors();

    $photo->refresh();

    expect($photo->caption)->toBeNull();
    expect($photo->alt_text)->toBeNull();
});

test('définir une photo comme couverture ne modifie pas sa légende', function () {
    $user = adminUser();
    $album = Album::factory()->create();
    $photo = uploadAlbumPhoto($album, ['caption' => 'Légende conservée']);

    $this->actingAs($user)
        ->patch(route('admin.albums.photos.update', [$album, $photo]), [
            'is_cover' => true,
        ])
        ->assertSessionHasNoErrors();

    $photo->refresh();
    $album->refresh();

    expect($album->cover_photo_id)->toBe($photo->id);
    expect($photo->caption)->toBe('Légende conservée');
});

test('un administrateur peut réordonner les photos', function () {
    $user = adminUser();
    $album = Album::factory()->create();
    $first = uploadAlbumPhoto($album, ['sort_order' => 0]);
    $second = uploadAlbumPhoto($album, ['sort_order' => 1]);
    $third = uploadAlbumPhoto($album, ['sort_order' => 2]);

    $this->actingAs($user)
        ->patch(route('admin.albums.photos.reorder', $album), [
            'photo_ids' => [$third->id, $first->id, $second->id],
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.albums.edit', $album));

    expect($album->photos()->whereKey($third->id)->value('sort_order'))->toBe(0);
    expect($album->photos()->whereKey($first->id)->value('sort_order'))->toBe(1);
    expect($album->photos()->whereKey($second->id)->value('sort_order'))->toBe(2);
});

test('supprimer une photo de couverture libère la couverture de l’album', function () {
    $user = adminUser();
    $album = Album::factory()->create();
    $photo = uploadAlbumPhoto($album);
    $album->update(['cover_photo_id' => $photo->id]);
    $mediaId = $photo->getFirstMedia('image')?->id;

    $this->actingAs($user)
        ->delete(route('admin.albums.photos.destroy', [$album, $photo]))
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.albums.edit', $album));

    $album->refresh();

    expect($album->cover_photo_id)->toBeNull();
    expect(AlbumPhoto::query()->find($photo->id))->toBeNull();
    expect(Media::query()->find($mediaId))->toBeNull();
});

test('une photo d’un autre album renvoie une page 404', function () {
    $user = adminUser();
    $album = Album::factory()->create();
    $otherAlbum = Album::factory()->create();
    $photo = uploadAlbumPhoto($otherAlbum);

    $this->actingAs($user)
        ->patch(route('admin.albums.photos.update', [$album, $photo]), [
            'caption' => 'Tentative',
        ])
        ->assertNotFound();

    expect($photo->fresh()?->caption)->not->toBe('Tentative');
});

test('les non-administrateurs ne peuvent pas ajouter de photos', function () {
    $user = User::factory()->create();
    $album = Album::factory()->create();

    $this->actingAs($user)
        ->post(route('admin.albums.photos.store', $album), [
            'photos' => [UploadedFile::fake()->image('photo.jpg', 1200, 800)],
        ])
        ->assertForbidden();
});

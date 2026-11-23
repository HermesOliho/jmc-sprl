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

function createManagedAlbumPhoto(Album $album): AlbumPhoto
{
    $photo = AlbumPhoto::factory()->for($album)->create();
    $photo->addMedia(UploadedFile::fake()->image('photo-'.$photo->id.'.jpg', 1200, 800))
        ->toMediaCollection('image');

    return $photo;
}

test('les administrateurs voient la liste des albums', function () {
    $user = adminUser();
    Album::factory()->count(2)->create();

    $this->actingAs($user)
        ->get(route('admin.albums.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Admin/Albums/Index')
            ->has('albums', 2)
        );
});

test('les non-administrateurs ne peuvent pas gérer les albums', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.albums.index'))
        ->assertForbidden();
});

test('un administrateur peut créer un album', function () {
    $user = adminUser();

    $response = $this->actingAs($user)->post(route('admin.albums.store'), [
        'title' => 'Chantier de Durba',
        'slug' => '',
        'description' => 'Photos du chantier.',
        'location' => 'Durba',
        'event_date' => '2026-05-12',
        'is_published' => true,
        'sort_order' => 4,
    ]);

    $album = Album::query()->where('slug', 'chantier-de-durba')->first();

    expect($album)->not->toBeNull();

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.albums.edit', $album));

    expect($album->title)->toBe('Chantier de Durba');
    expect($album->location)->toBe('Durba');
    expect($album->event_date?->toDateString())->toBe('2026-05-12');
    expect($album->is_published)->toBeTrue();
    expect($album->sort_order)->toBe(4);
});

test('le slug est généré depuis le titre et reste unique', function () {
    $user = adminUser();
    Album::factory()->create(['slug' => 'album-test']);

    $this->actingAs($user)->post(route('admin.albums.store'), [
        'title' => 'Album Test',
    ])->assertSessionHasNoErrors();

    expect(Album::query()->where('slug', 'album-test-2')->exists())->toBeTrue();
});

test('un administrateur peut modifier un album', function () {
    $user = adminUser();
    $album = Album::factory()->create([
        'title' => 'Ancien titre',
        'slug' => 'ancien-titre',
        'is_published' => false,
    ]);

    $response = $this->actingAs($user)->put(route('admin.albums.update', $album), [
        'title' => 'Nouveau titre',
        'slug' => 'nouveau-titre',
        'description' => 'Nouvelle description.',
        'location' => 'Kinshasa',
        'event_date' => '2026-06-01',
        'is_published' => true,
        'sort_order' => 2,
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.albums.edit', $album));

    $album->refresh();

    expect($album->title)->toBe('Nouveau titre');
    expect($album->slug)->toBe('nouveau-titre');
    expect($album->description)->toBe('Nouvelle description.');
    expect($album->location)->toBe('Kinshasa');
    expect($album->is_published)->toBeTrue();
    expect($album->sort_order)->toBe(2);
});

test('un administrateur peut ouvrir le formulaire de création', function () {
    $user = adminUser();

    $this->actingAs($user)
        ->get(route('admin.albums.create'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/Albums/Create'));
});

test('un administrateur peut ouvrir la page de gestion d’un album', function () {
    $user = adminUser();
    $album = Album::factory()->create(['title' => 'Album à gérer']);
    $photo = createManagedAlbumPhoto($album);
    $album->update(['cover_photo_id' => $photo->id]);

    $this->actingAs($user)
        ->get(route('admin.albums.edit', $album))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Admin/Albums/Edit')
            ->where('album.id', $album->id)
            ->has('photos', 1)
            ->where('photos.0.is_cover', true)
        );
});

test('un titre est obligatoire pour créer un album', function () {
    $user = adminUser();

    $this->actingAs($user)
        ->post(route('admin.albums.store'), [])
        ->assertSessionHasErrors('title');
});

test('supprimer un album supprime aussi ses photos et leurs médias', function () {
    $user = adminUser();
    $album = Album::factory()->create();
    $photo = createManagedAlbumPhoto($album);
    $mediaId = $photo->getFirstMedia('image')?->id;

    $this->actingAs($user)
        ->delete(route('admin.albums.destroy', $album))
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.albums.index'));

    expect(Album::query()->find($album->id))->toBeNull();
    expect(AlbumPhoto::query()->find($photo->id))->toBeNull();
    expect(Media::query()->find($mediaId))->toBeNull();
});

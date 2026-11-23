<?php

use App\Models\Album;
use App\Models\AlbumPhoto;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    config()->set('inertia.testing.ensure_pages_exist', false);
    Storage::fake('public');
    config()->set('media-library.disk_name', 'public');
});

function createAlbumPhoto(Album $album, array $attributes = []): AlbumPhoto
{
    $photo = AlbumPhoto::factory()->for($album)->create($attributes);
    $photo->addMedia(UploadedFile::fake()->image('photo-'.$photo->id.'.jpg', 1200, 800))
        ->toMediaCollection('image');

    return $photo;
}

test('la page album expose uniquement les albums publiés dans l’ordre', function () {
    Album::factory()->published()->create(['title' => 'Deuxième', 'slug' => 'deuxieme', 'sort_order' => 2]);
    Album::factory()->published()->create(['title' => 'Premier', 'slug' => 'premier', 'sort_order' => 1]);
    Album::factory()->create(['title' => 'Brouillon', 'slug' => 'brouillon']);

    $this->get('/album')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Public/Album/Index')
            ->has('albums.data', 2)
            ->where('albums.data.0.slug', 'premier')
            ->where('albums.data.1.slug', 'deuxieme')
        );
});

test('la page album expose la couverture et le nombre de photos publiées', function () {
    $album = Album::factory()->published()->create(['slug' => 'chantier']);
    $first = createAlbumPhoto($album, ['sort_order' => 1, 'is_published' => true]);
    createAlbumPhoto($album, ['sort_order' => 2, 'is_published' => true]);
    createAlbumPhoto($album, ['sort_order' => 3, 'is_published' => false]);

    $this->get('/album')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Public/Album/Index')
            ->where('albums.data.0.cover_url', $first->card_url)
            ->where('albums.data.0.photo_count', 2)
        );
});

test('le détail d’un album expose uniquement ses photos publiées dans l’ordre', function () {
    $album = Album::factory()->published()->create([
        'slug' => 'chantier-durba',
        'title' => 'Chantier de Durba',
    ]);
    $second = createAlbumPhoto($album, ['sort_order' => 2, 'is_published' => true]);
    $first = createAlbumPhoto($album, ['sort_order' => 1, 'is_published' => true]);
    createAlbumPhoto($album, ['sort_order' => 0, 'is_published' => false]);

    $this->get(route('album.show', $album->slug))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Public/Album/Show')
            ->where('album.slug', 'chantier-durba')
            ->has('photos.data', 2)
            ->where('photos.data.0.id', $first->id)
            ->where('photos.data.1.id', $second->id)
            ->where('photos.data.0.alt', $first->alt)
        );
});

test('le détail d’un album expose ses métadonnées SEO', function () {
    $album = Album::factory()->published()->create([
        'slug' => 'chantier-seo',
        'title' => 'Chantier SEO',
    ]);
    $photo = createAlbumPhoto($album, ['sort_order' => 1]);

    $this->get(route('album.show', $album->slug))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('seo.title', 'Chantier SEO')
            ->where('seo.path', '/album/chantier-seo')
            ->where('seo.type', 'CollectionPage')
            ->where('seo.og_image', $photo->card_url)
        );
});

test('un album non publié renvoie une page 404', function () {
    $album = Album::factory()->create(['slug' => 'brouillon']);

    $this->get(route('album.show', $album->slug))->assertNotFound();
});

test('un slug d’album inconnu renvoie une page 404', function () {
    $this->get('/album/album-inexistant')->assertNotFound();
});

test('l’accueil expose les huit dernières photos publiées', function () {
    $album = Album::factory()->published()->create(['slug' => 'album-publie']);
    $draftAlbum = Album::factory()->create(['slug' => 'album-brouillon']);

    $photos = collect();

    foreach (range(1, 9) as $position) {
        $photos->push(createAlbumPhoto($album, [
            'created_at' => now()->subMinutes(20 - $position),
        ]));
    }

    createAlbumPhoto($album, ['is_published' => false, 'created_at' => now()]);
    createAlbumPhoto($draftAlbum, ['created_at' => now()]);

    $this->get('/')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Public/Home')
            ->has('latestPhotos', 8)
            ->where('latestPhotos.0.id', $photos->last()->id)
            ->where('latestPhotos.0.album.slug', 'album-publie')
        );
});

test('l’accueil ne transmet aucune photo quand la galerie est vide', function () {
    $this->get('/')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Public/Home')
            ->has('latestPhotos', 0)
        );
});

test('l’ancienne url galerie redirige vers l’album', function () {
    $this->get('/galerie')->assertRedirect('/album');
});

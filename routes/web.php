<?php

use App\Http\Controllers\Admin\AlbumController as AdminAlbumController;
use App\Http\Controllers\Admin\AlbumPhotoController as AdminAlbumPhotoController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PartnerController as AdminPartnerController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\TeamMemberController as AdminTeamMemberController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Models\Album;
use App\Models\AlbumPhoto;
use App\Models\Partner;
use App\Models\Service;
use App\Models\TeamMember;
use App\Support\AlbumData;
use App\Support\ServiceData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Route::get('/', function () {
    $partners = Partner::query()
        ->active()
        ->ordered()
        ->get()
        ->map(fn (Partner $partner): array => [
            'name' => $partner->name,
            'logo' => $partner->logo_url,
            'description' => $partner->description,
            'website_url' => $partner->website_url,
        ])
        ->filter(fn (array $partner): bool => filled($partner['logo']))
        ->values();

    $services = Service::query()
        ->active()
        ->featured()
        ->homeOrdered()
        ->with('media')
        ->get();

    $latestPhotos = AlbumPhoto::query()
        ->published()
        ->whereHas('album', fn (Builder $query): Builder => $query->published())
        ->with(['album', 'media'])
        ->latest()
        ->orderByDesc('id')
        ->limit(8)
        ->get();

    return Inertia::render('Public/Home', [
        'seo' => config('site.pages.home'),
        'partners' => $partners,
        'services' => ServiceData::collection($services),
        'latestPhotos' => AlbumData::latestPhotos($latestPhotos),
    ]);
})->name('home');

Route::get('/a-propos', function () {
    $teamMembers = TeamMember::query()
        ->active()
        ->ordered()
        ->get()
        ->map(fn (TeamMember $member): array => [
            'name' => $member->name,
            'role' => $member->role,
            'description' => $member->bio,
            'avatar' => $member->photo_url,
            'email' => $member->email,
            'phone' => $member->phone,
            'social' => $member->social_links ?? [],
        ])
        ->values();

    return Inertia::render('Public/About', [
        'seo' => config('site.pages.about'),
        'teamMembers' => $teamMembers,
    ]);
})->name('about');

Route::get('/services', function () {
    $services = Service::query()
        ->active()
        ->ordered()
        ->with('media')
        ->get();

    return Inertia::render('Public/Services', [
        'seo' => config('site.pages.services'),
        'services' => ServiceData::collection($services),
    ]);
})->name('services');

Route::get('/album', [AlbumController::class, 'index'])->name('album.index');

Route::get('/album/{album:slug}', [AlbumController::class, 'show'])->name('album.show');

Route::get('/contact', function () {
    $services = Service::query()
        ->active()
        ->ordered()
        ->get(['slug', 'title']);

    return Inertia::render('Public/Contact', [
        'seo' => config('site.pages.contact'),
        'services' => $services->map(fn (Service $service): array => [
            'slug' => $service->slug,
            'title' => $service->title,
        ])->values()->all(),
    ]);
})->name('contact');

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');

Route::get('/mentions-legales', function () {
    return Inertia::render('Public/LegalNotice', [
        'seo' => config('site.pages.legal'),
    ]);
})->name('legal');

Route::get('/politique-de-confidentialite', function () {
    return Inertia::render('Public/PrivacyPolicy', [
        'seo' => config('site.pages.privacy'),
    ]);
})->name('privacy');

/*
|--------------------------------------------------------------------------
| Redirections de transition
|--------------------------------------------------------------------------
|
| Les anciennes entrées de navigation sans page dédiée sont redirigées
| vers la page la plus proche afin de ne pas laisser de liens morts.
|
*/

Route::redirect('/demande-devis', '/contact?subject=devis', 301);
Route::redirect('/realisations', '/services', 301);
Route::redirect('/carrieres', '/contact?subject=stage', 301);
Route::redirect('/actualites', '/a-propos', 301);
Route::redirect('/galerie', '/album', 301);

Route::get('/services/{slug}', function (string $slug) {
    return redirect('/services#'.$slug, 301);
})->where('slug', '[a-z0-9-]+')->name('services.redirect');

Route::get('/sitemap.xml', function () {
    $sitemap = Sitemap::create();

    foreach (config('site.pages') as $page) {
        if (($page['robots'] ?? null) === 'noindex, nofollow') {
            continue;
        }

        $sitemap->add(
            Url::create(config('site.url').$page['path'])
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority($page['path'] === '/' ? 1.0 : 0.8),
        );
    }

    if (Schema::hasTable('albums')) {
        Album::query()
            ->published()
            ->ordered()
            ->get(['slug', 'updated_at'])
            ->each(function (Album $album) use ($sitemap): void {
                $sitemap->add(
                    Url::create(config('site.url').'/album/'.$album->slug)
                        ->setLastModificationDate($album->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                        ->setPriority(0.7),
                );
            });
    }

    return $sitemap->toResponse(request());
})->name('sitemap');

Route::middleware(['auth', 'verified', 'can:access-admin'])->group(function () {
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', AdminUserController::class)->except(['show']);
        Route::resource('partners', AdminPartnerController::class)->except(['show']);
        Route::resource('team-members', AdminTeamMemberController::class)->except(['show']);
        Route::resource('services', AdminServiceController::class)->except(['show']);
        Route::resource('albums', AdminAlbumController::class)->except(['show']);

        Route::prefix('albums/{album}')->name('albums.')->group(function () {
            Route::post('photos', [AdminAlbumPhotoController::class, 'store'])->name('photos.store');
            Route::patch('photos/reorder', [AdminAlbumPhotoController::class, 'reorder'])->name('photos.reorder');
            Route::patch('photos/{albumPhoto}', [AdminAlbumPhotoController::class, 'update'])
                ->whereNumber('albumPhoto')
                ->name('photos.update');
            Route::delete('photos/{albumPhoto}', [AdminAlbumPhotoController::class, 'destroy'])
                ->whereNumber('albumPhoto')
                ->name('photos.destroy');
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

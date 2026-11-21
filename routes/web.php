<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PartnerController as AdminPartnerController;
use App\Http\Controllers\Admin\TeamMemberController as AdminTeamMemberController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Models\Partner;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Route;
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

    return Inertia::render('Public/Home', [
        'seo' => config('site.pages.home'),
        'partners' => $partners,
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
    return Inertia::render('Public/Services', [
        'seo' => config('site.pages.services'),
    ]);
})->name('services');

Route::get('/contact', function () {
    return Inertia::render('Public/Contact', [
        'seo' => config('site.pages.contact'),
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

Route::get('/services/{slug}', function (string $slug) {
    return redirect('/services#'.$slug, 301);
})->where('slug', '[a-z0-9-]+');

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

    return $sitemap->toResponse(request());
})->name('sitemap');

Route::middleware(['auth', 'verified', 'can:access-admin'])->group(function () {
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', AdminUserController::class)->except(['show']);
        Route::resource('partners', AdminPartnerController::class)->except(['show']);
        Route::resource('team-members', AdminTeamMemberController::class)->except(['show']);
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

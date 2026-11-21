<?php

namespace App\Http\Middleware;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'can' => [
                    'accessAdmin' => $request->user()?->can('access-admin') ?? false,
                ],
            ],
            'site' => fn () => [
                'name' => config('site.name'),
                'short_name' => config('site.short_name'),
                'legal_name' => config('site.legal_name'),
                'tagline' => config('site.tagline'),
                'slogan' => config('site.slogan'),
                'description' => config('site.description'),
                'url' => config('site.url'),
                'locale' => config('site.locale'),
                'logo' => config('site.logo'),
                'logo_dark' => config('site.logo_dark'),
                'og_image' => config('site.og_image'),
                'contact' => config('site.contact'),
                'social' => config('site.social'),
                'contact_subjects' => config('site.contact_subjects'),
            ],
            'footer_services' => function () {
                if (! Schema::hasTable('services')) {
                    return [];
                }

                return Service::query()
                    ->active()
                    ->ordered()
                    ->limit(4)
                    ->get(['slug', 'title'])
                    ->map(fn (Service $service): array => [
                        'slug' => $service->slug,
                        'title' => $service->title,
                    ])
                    ->values()
                    ->all();
            },
            'flash' => [
                'status' => fn () => $request->session()->get('status'),
                'error' => fn () => $request->session()->get('error'),
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
        ];
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServiceRequest;
use App\Http\Requests\Admin\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    /**
     * @var array<int, string>
     */
    public const ICON_OPTIONS = [
        'building2',
        'hard-hat',
        'landmark',
        'zap',
        'home',
        'globe',
        'package',
        'truck',
        'croissant',
        'factory',
        'cog',
        'droplets',
        'hammer',
        'paintbrush',
        'shopping-cart',
        'sprout',
        'clock',
        'shield-check',
        'search',
        'users',
        'heart',
        'circle-check',
        'calendar',
        'file-text',
    ];

    public function index(): Response
    {
        $this->authorize('viewAny', Service::class);

        $services = Service::query()
            ->ordered()
            ->with('media')
            ->get()
            ->map(fn (Service $service): array => [
                'id' => $service->id,
                'slug' => $service->slug,
                'title' => $service->title,
                'description' => $service->description,
                'icon' => $service->icon,
                'is_featured' => $service->is_featured,
                'home_sort_order' => $service->home_sort_order,
                'is_active' => $service->is_active,
                'sort_order' => $service->sort_order,
                'cover_url' => $service->cover_url,
            ]);

        return Inertia::render('Admin/Services/Index', [
            'services' => $services,
        ]);
    }

    public function create(): Response
    {
        $this->authorize('create', Service::class);

        return Inertia::render('Admin/Services/Create', [
            'iconOptions' => self::ICON_OPTIONS,
        ]);
    }

    public function store(StoreServiceRequest $request): RedirectResponse
    {
        $this->authorize('create', Service::class);

        $validated = $request->validated();

        $slug = filled($validated['slug'] ?? null)
            ? Str::slug($validated['slug'])
            : Str::slug($validated['title']);

        $base = $slug !== '' ? $slug : Str::random(8);
        $candidate = $base;
        $counter = 2;

        while (Service::query()->where('slug', $candidate)->exists()) {
            $candidate = $base.'-'.$counter;
            $counter++;
        }

        $service = Service::query()->create([
            'slug' => $candidate,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'icon' => $validated['icon'],
            'deliverables' => $this->normalizeList($validated['deliverables'] ?? null),
            'benefits' => $this->normalizeList($validated['benefits'] ?? null),
            'is_featured' => $request->boolean('is_featured', false),
            'home_sort_order' => $validated['home_sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $validated['sort_order'] ?? 0,
            'image_alt' => $validated['image_alt'] ?? null,
            'image_position' => $validated['image_position'] ?? 'center',
        ]);

        if ($request->hasFile('cover')) {
            $service->addMediaFromRequest('cover')->toMediaCollection('cover');
        }

        return Redirect::route('admin.services.index')->with('status', 'Service créé avec succès.');
    }

    public function edit(Service $service): Response
    {
        $this->authorize('update', $service);

        return Inertia::render('Admin/Services/Edit', [
            'iconOptions' => self::ICON_OPTIONS,
            'service' => [
                'id' => $service->id,
                'slug' => $service->slug,
                'title' => $service->title,
                'description' => $service->description,
                'icon' => $service->icon,
                'deliverables' => $service->deliverables ?? [],
                'benefits' => $service->benefits ?? [],
                'is_featured' => $service->is_featured,
                'home_sort_order' => $service->home_sort_order,
                'is_active' => $service->is_active,
                'sort_order' => $service->sort_order,
                'image_alt' => $service->image_alt,
                'image_position' => $service->image_position,
                'cover_url' => $service->cover_url,
            ],
        ]);
    }

    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        $this->authorize('update', $service);

        $validated = $request->validated();

        $service->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'icon' => $validated['icon'],
            'deliverables' => $this->normalizeList($validated['deliverables'] ?? null),
            'benefits' => $this->normalizeList($validated['benefits'] ?? null),
            'is_featured' => $request->boolean('is_featured'),
            'home_sort_order' => $validated['home_sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $validated['sort_order'] ?? 0,
            'image_alt' => $validated['image_alt'] ?? null,
            'image_position' => $validated['image_position'] ?? 'center',
        ]);

        if ($request->boolean('remove_cover')) {
            $service->clearMediaCollection('cover');
        }

        if ($request->hasFile('cover')) {
            $service->addMediaFromRequest('cover')->toMediaCollection('cover');
        }

        return Redirect::route('admin.services.index')->with('status', 'Service mis à jour avec succès.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $this->authorize('delete', $service);

        $service->delete();

        return Redirect::route('admin.services.index')->with('status', 'Service supprimé avec succès.');
    }

    /**
     * @return array<int, string>|null
     */
    private function normalizeList(mixed $value): ?array
    {
        if (! is_array($value)) {
            return null;
        }

        $items = collect($value)
            ->map(fn ($item): string => trim((string) $item))
            ->filter(fn (string $item): bool => $item !== '')
            ->values()
            ->all();

        return $items === [] ? null : $items;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePartnerRequest;
use App\Http\Requests\Admin\UpdatePartnerRequest;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class PartnerController extends Controller
{
    public function index(): Response
    {
        $this->authorize('viewAny', Partner::class);

        $partners = Partner::query()
            ->ordered()
            ->get()
            ->map(fn (Partner $partner): array => [
                'id' => $partner->id,
                'name' => $partner->name,
                'description' => $partner->description,
                'website_url' => $partner->website_url,
                'is_active' => $partner->is_active,
                'sort_order' => $partner->sort_order,
                'logo_url' => $partner->logo_url,
                'created_at' => $partner->created_at?->toDateTimeString(),
            ]);

        return Inertia::render('Admin/Partners/Index', [
            'partners' => $partners,
        ]);
    }

    public function create(): Response
    {
        $this->authorize('create', Partner::class);

        return Inertia::render('Admin/Partners/Create');
    }

    public function store(StorePartnerRequest $request): RedirectResponse
    {
        $this->authorize('create', Partner::class);

        $validated = $request->validated();

        $partner = Partner::query()->create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'website_url' => $validated['website_url'] ?? null,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        if ($request->hasFile('logo')) {
            $partner->addMediaFromRequest('logo')->toMediaCollection('logo');
        }

        return Redirect::route('admin.partners.index')->with('status', 'Partenaire créé avec succès.');
    }

    public function edit(Partner $partner): Response
    {
        $this->authorize('update', $partner);

        return Inertia::render('Admin/Partners/Edit', [
            'partner' => [
                'id' => $partner->id,
                'name' => $partner->name,
                'description' => $partner->description,
                'website_url' => $partner->website_url,
                'is_active' => $partner->is_active,
                'sort_order' => $partner->sort_order,
                'logo_url' => $partner->logo_url,
            ],
        ]);
    }

    public function update(UpdatePartnerRequest $request, Partner $partner): RedirectResponse
    {
        $this->authorize('update', $partner);

        $validated = $request->validated();

        $partner->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'website_url' => $validated['website_url'] ?? null,
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        if ($request->hasFile('logo')) {
            $partner->addMediaFromRequest('logo')->toMediaCollection('logo');
        }

        return Redirect::route('admin.partners.index')->with('status', 'Partenaire mis à jour avec succès.');
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        $this->authorize('delete', $partner);

        $partner->delete();

        return Redirect::route('admin.partners.index')->with('status', 'Partenaire supprimé avec succès.');
    }
}

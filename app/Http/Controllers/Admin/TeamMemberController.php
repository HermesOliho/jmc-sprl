<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeamMemberRequest;
use App\Http\Requests\Admin\UpdateTeamMemberRequest;
use App\Models\TeamMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class TeamMemberController extends Controller
{
    public function index(): Response
    {
        $this->authorize('viewAny', TeamMember::class);

        $members = TeamMember::query()
            ->ordered()
            ->get()
            ->map(fn (TeamMember $member): array => [
                'id' => $member->id,
                'name' => $member->name,
                'role' => $member->role,
                'bio' => $member->bio,
                'email' => $member->email,
                'phone' => $member->phone,
                'social_links' => $member->social_links ?? [],
                'is_active' => $member->is_active,
                'sort_order' => $member->sort_order,
                'photo_url' => $member->photo_url,
            ]);

        return Inertia::render('Admin/TeamMembers/Index', [
            'members' => $members,
        ]);
    }

    public function create(): Response
    {
        $this->authorize('create', TeamMember::class);

        return Inertia::render('Admin/TeamMembers/Create');
    }

    public function store(StoreTeamMemberRequest $request): RedirectResponse
    {
        $this->authorize('create', TeamMember::class);

        $validated = $request->validated();

        $member = TeamMember::query()->create([
            'name' => $validated['name'],
            'role' => $validated['role'],
            'bio' => $validated['bio'] ?? null,
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'social_links' => $this->normalizeSocialLinks($request->input('social_links')),
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        if ($request->hasFile('photo')) {
            $member->addMediaFromRequest('photo')->toMediaCollection('photo');
        }

        return Redirect::route('admin.team-members.index')->with('status', 'Membre créé avec succès.');
    }

    public function edit(TeamMember $teamMember): Response
    {
        $this->authorize('update', $teamMember);

        return Inertia::render('Admin/TeamMembers/Edit', [
            'member' => [
                'id' => $teamMember->id,
                'name' => $teamMember->name,
                'role' => $teamMember->role,
                'bio' => $teamMember->bio,
                'email' => $teamMember->email,
                'phone' => $teamMember->phone,
                'social_links' => $teamMember->social_links ?? [],
                'is_active' => $teamMember->is_active,
                'sort_order' => $teamMember->sort_order,
                'photo_url' => $teamMember->photo_url,
            ],
        ]);
    }

    public function update(UpdateTeamMemberRequest $request, TeamMember $teamMember): RedirectResponse
    {
        $this->authorize('update', $teamMember);

        $validated = $request->validated();

        $teamMember->update([
            'name' => $validated['name'],
            'role' => $validated['role'],
            'bio' => $validated['bio'] ?? null,
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'social_links' => $this->normalizeSocialLinks($request->input('social_links')),
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        if ($request->hasFile('photo')) {
            $teamMember->addMediaFromRequest('photo')->toMediaCollection('photo');
        }

        return Redirect::route('admin.team-members.index')->with('status', 'Membre mis à jour avec succès.');
    }

    public function destroy(TeamMember $teamMember): RedirectResponse
    {
        $this->authorize('delete', $teamMember);

        $teamMember->delete();

        return Redirect::route('admin.team-members.index')->with('status', 'Membre supprimé avec succès.');
    }

    /**
     * @return array<int, array{name: string, url: string}>
     */
    private function normalizeSocialLinks(mixed $links): array
    {
        if (! is_array($links)) {
            return [];
        }

        return collect($links)
            ->filter(fn ($link): bool => is_array($link) && filled($link['name'] ?? null) && filled($link['url'] ?? null))
            ->map(fn (array $link): array => [
                'name' => (string) $link['name'],
                'url' => (string) $link['url'],
            ])
            ->values()
            ->all();
    }
}

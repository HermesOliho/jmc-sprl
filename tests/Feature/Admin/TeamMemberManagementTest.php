<?php

use App\Models\TeamMember;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    config()->set('inertia.testing.ensure_pages_exist', false);
    Storage::fake('public');
    config()->set('media-library.disk_name', 'public');
});

test('authenticated users can view the team members list', function () {
    $user = adminUser();
    TeamMember::factory()->count(2)->create();

    $this->actingAs($user)
        ->get(route('admin.team-members.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Admin/TeamMembers/Index')
            ->has('members', 2)
        );
});

test('authenticated users can create a team member with photo and social links', function () {
    $user = adminUser();

    $response = $this->actingAs($user)->post(route('admin.team-members.store'), [
        'name' => 'Jane Doe',
        'role' => 'Directrice',
        'bio' => 'Bio courte',
        'email' => 'jane@example.com',
        'phone' => '+243000000',
        'is_active' => true,
        'sort_order' => 1,
        'photo' => UploadedFile::fake()->image('photo.jpg', 200, 200),
        'social_links' => [
            ['name' => 'LinkedIn', 'url' => 'https://www.linkedin.com/in/jane-doe'],
            ['name' => 'X', 'url' => 'https://x.com/janedoe'],
        ],
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.team-members.index'));

    $member = TeamMember::query()->where('email', 'jane@example.com')->first();

    expect($member)->not->toBeNull();
    expect($member->name)->toBe('Jane Doe');
    expect($member->role)->toBe('Directrice');
    expect($member->bio)->toBe('Bio courte');
    expect($member->is_active)->toBeTrue();
    expect($member->social_links)->toHaveCount(2);
    expect($member->getFirstMedia('photo'))->not->toBeNull();
});

test('authenticated users can update a team member', function () {
    $user = adminUser();
    $member = TeamMember::factory()->create([
        'name' => 'Ancien Nom',
        'is_active' => true,
    ]);
    $member->addMedia(UploadedFile::fake()->image('old.jpg', 200, 200))
        ->usingFileName('old.jpg')
        ->toMediaCollection('photo');

    $response = $this->actingAs($user)->post(route('admin.team-members.update', $member), [
        '_method' => 'put',
        'name' => 'Nouveau Nom',
        'role' => 'Nouveau rôle',
        'bio' => 'Nouvelle bio',
        'email' => 'nouveau@example.com',
        'phone' => '',
        'is_active' => false,
        'sort_order' => 5,
        'photo' => UploadedFile::fake()->image('new.jpg', 200, 200),
        'social_links' => [
            ['name' => 'LinkedIn', 'url' => 'https://www.linkedin.com/in/nouveau'],
        ],
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.team-members.index'));

    $member->refresh();

    expect($member->name)->toBe('Nouveau Nom');
    expect($member->role)->toBe('Nouveau rôle');
    expect($member->is_active)->toBeFalse();
    expect($member->sort_order)->toBe(5);
    expect($member->social_links)->toHaveCount(1);
    expect($member->getFirstMedia('photo'))->not->toBeNull();
});

test('authenticated users can delete a team member', function () {
    $user = adminUser();
    $member = TeamMember::factory()->create();

    $response = $this->actingAs($user)->delete(route('admin.team-members.destroy', $member));

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.team-members.index'));

    expect(TeamMember::query()->find($member->id))->toBeNull();
});

test('team member photo cannot be an svg', function () {
    $user = adminUser();

    $response = $this->actingAs($user)->post(route('admin.team-members.store'), [
        'name' => 'Test',
        'role' => 'Role',
        'photo' => UploadedFile::fake()->create('photo.svg', 10, 'image/svg+xml'),
    ]);

    $response->assertSessionHasErrors('photo');
});

test('about page displays only active team members in order', function () {
    TeamMember::factory()->create([
        'name' => 'Inactif',
        'is_active' => false,
        'sort_order' => 0,
    ]);
    TeamMember::factory()->create([
        'name' => 'Second',
        'is_active' => true,
        'sort_order' => 2,
    ]);
    TeamMember::factory()->create([
        'name' => 'Premier',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $this->get(route('about'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Public/About')
            ->has('teamMembers', 2)
            ->where('teamMembers.0.name', 'Premier')
            ->where('teamMembers.1.name', 'Second')
        );
});

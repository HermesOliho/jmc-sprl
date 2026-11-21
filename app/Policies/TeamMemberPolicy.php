<?php

namespace App\Policies;

use App\Models\TeamMember;
use App\Models\User;

class TeamMemberPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('access-admin');
    }

    public function view(User $user, TeamMember $teamMember): bool
    {
        return $user->can('access-admin');
    }

    public function create(User $user): bool
    {
        return $user->can('access-admin');
    }

    public function update(User $user, TeamMember $teamMember): bool
    {
        return $user->can('access-admin');
    }

    public function delete(User $user, TeamMember $teamMember): bool
    {
        return $user->can('access-admin');
    }
}

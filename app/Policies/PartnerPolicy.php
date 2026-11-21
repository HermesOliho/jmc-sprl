<?php

namespace App\Policies;

use App\Models\Partner;
use App\Models\User;

class PartnerPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('access-admin');
    }

    public function view(User $user, Partner $partner): bool
    {
        return $user->can('access-admin');
    }

    public function create(User $user): bool
    {
        return $user->can('access-admin');
    }

    public function update(User $user, Partner $partner): bool
    {
        return $user->can('access-admin');
    }

    public function delete(User $user, Partner $partner): bool
    {
        return $user->can('access-admin');
    }
}

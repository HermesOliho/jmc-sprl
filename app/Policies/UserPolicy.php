<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('access-admin');
    }

    public function view(User $user, User $model): bool
    {
        return $user->can('access-admin');
    }

    public function create(User $user): bool
    {
        return $user->can('access-admin');
    }

    public function update(User $user, User $model): bool
    {
        return $user->can('access-admin');
    }

    public function delete(User $user, User $model): bool
    {
        return $user->can('access-admin') && $user->id !== $model->id;
    }
}

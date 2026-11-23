<?php

namespace App\Policies;

use App\Models\AlbumPhoto;
use App\Models\User;

class AlbumPhotoPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('access-admin');
    }

    public function view(User $user, AlbumPhoto $albumPhoto): bool
    {
        return $user->can('access-admin');
    }

    public function create(User $user): bool
    {
        return $user->can('access-admin');
    }

    public function update(User $user, AlbumPhoto $albumPhoto): bool
    {
        return $user->can('access-admin');
    }

    public function delete(User $user, AlbumPhoto $albumPhoto): bool
    {
        return $user->can('access-admin');
    }
}

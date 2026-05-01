<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Galery;
use Illuminate\Auth\Access\HandlesAuthorization;

class GaleryPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Galery');
    }

    public function view(AuthUser $authUser, Galery $galery): bool
    {
        return $authUser->can('View:Galery');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Galery');
    }

    public function update(AuthUser $authUser, Galery $galery): bool
    {
        return $authUser->can('Update:Galery');
    }

    public function delete(AuthUser $authUser, Galery $galery): bool
    {
        return $authUser->can('Delete:Galery');
    }

}
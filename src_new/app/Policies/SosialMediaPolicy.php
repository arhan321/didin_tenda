<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\SosialMedia;
use Illuminate\Auth\Access\HandlesAuthorization;

class SosialMediaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:SosialMedia');
    }

    public function view(AuthUser $authUser, SosialMedia $sosialMedia): bool
    {
        return $authUser->can('View:SosialMedia');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SosialMedia');
    }

    public function update(AuthUser $authUser, SosialMedia $sosialMedia): bool
    {
        return $authUser->can('Update:SosialMedia');
    }

    public function delete(AuthUser $authUser, SosialMedia $sosialMedia): bool
    {
        return $authUser->can('Delete:SosialMedia');
    }

}
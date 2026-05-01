<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Addon;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddonPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Addon');
    }

    public function view(AuthUser $authUser, Addon $addon): bool
    {
        return $authUser->can('View:Addon');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Addon');
    }

    public function update(AuthUser $authUser, Addon $addon): bool
    {
        return $authUser->can('Update:Addon');
    }

    public function delete(AuthUser $authUser, Addon $addon): bool
    {
        return $authUser->can('Delete:Addon');
    }

}
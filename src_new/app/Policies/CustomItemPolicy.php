<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\CustomItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomItemPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CustomItem');
    }

    public function view(AuthUser $authUser, CustomItem $customItem): bool
    {
        return $authUser->can('View:CustomItem');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CustomItem');
    }

    public function update(AuthUser $authUser, CustomItem $customItem): bool
    {
        return $authUser->can('Update:CustomItem');
    }

    public function delete(AuthUser $authUser, CustomItem $customItem): bool
    {
        return $authUser->can('Delete:CustomItem');
    }

}
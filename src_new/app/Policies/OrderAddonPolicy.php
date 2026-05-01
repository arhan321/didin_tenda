<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\OrderAddon;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderAddonPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:OrderAddon');
    }

    public function view(AuthUser $authUser, OrderAddon $orderAddon): bool
    {
        return $authUser->can('View:OrderAddon');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:OrderAddon');
    }

    public function update(AuthUser $authUser, OrderAddon $orderAddon): bool
    {
        return $authUser->can('Update:OrderAddon');
    }

    public function delete(AuthUser $authUser, OrderAddon $orderAddon): bool
    {
        return $authUser->can('Delete:OrderAddon');
    }

}
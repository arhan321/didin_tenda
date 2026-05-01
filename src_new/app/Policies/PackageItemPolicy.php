<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PackageItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class PackageItemPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PackageItem');
    }

    public function view(AuthUser $authUser, PackageItem $packageItem): bool
    {
        return $authUser->can('View:PackageItem');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PackageItem');
    }

    public function update(AuthUser $authUser, PackageItem $packageItem): bool
    {
        return $authUser->can('Update:PackageItem');
    }

    public function delete(AuthUser $authUser, PackageItem $packageItem): bool
    {
        return $authUser->can('Delete:PackageItem');
    }

}
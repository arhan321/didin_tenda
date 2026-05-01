<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Beranda;
use Illuminate\Auth\Access\HandlesAuthorization;

class BerandaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Beranda');
    }

    public function view(AuthUser $authUser, Beranda $beranda): bool
    {
        return $authUser->can('View:Beranda');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Beranda');
    }

    public function update(AuthUser $authUser, Beranda $beranda): bool
    {
        return $authUser->can('Update:Beranda');
    }

    public function delete(AuthUser $authUser, Beranda $beranda): bool
    {
        return $authUser->can('Delete:Beranda');
    }

}
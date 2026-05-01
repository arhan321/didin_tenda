<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Footer;
use Illuminate\Auth\Access\HandlesAuthorization;

class FooterPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Footer');
    }

    public function view(AuthUser $authUser, Footer $footer): bool
    {
        return $authUser->can('View:Footer');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Footer');
    }

    public function update(AuthUser $authUser, Footer $footer): bool
    {
        return $authUser->can('Update:Footer');
    }

    public function delete(AuthUser $authUser, Footer $footer): bool
    {
        return $authUser->can('Delete:Footer');
    }

}
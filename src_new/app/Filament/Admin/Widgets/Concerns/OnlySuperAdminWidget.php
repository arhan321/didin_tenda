<?php

declare(strict_types=1);

namespace App\Filament\Widgets\Concerns;

trait OnlySuperAdminWidget
{
    public static function canView(): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        if (method_exists($user, 'hasRole')) {
            return $user->hasRole('super_admin');
        }

        if (method_exists($user, 'roles')) {
            return $user->roles()
                ->where('name', 'super_admin')
                ->exists();
        }

        return false;
    }
}
<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
  public function run()
    {
        // Menambahkan izin untuk owner full access
        $super_admin = Permission::all();
        Role::findOrFail(1)->permissions()->sync($super_admin->pluck('id'));

        // admin permission
        $admin_permission = Permission::where(function ($query) {
            $query->whereBetween('id', [17, 22])
                  ->orWhereBetween('id', [23, 24])
                  ->orWhere('id', 27)
                  ->orWhere('id', 29)
                  ->orWhere('id', 32)
                  ->orWhere('id', 34)
                  ->orWhere('id', 37)
                  ->orWhere('id', 39)
                  ->orWhereBetween('id', [40, 45]);
        })->get();
        Role::findOrFail(2)->permissions()->sync($admin_permission->pluck('id'));

        // // Menambahkan izin untuk waiter fnb access & history_order
        // $waiter_permissions = Permission::where(function ($query) {
        //     $query->whereBetween('id', [74, 104])
        //           ->orWhereBetween('id', [105, 107])
        //           ->orWhere('id', 108);
        // })->get();
        // Role::findOrFail(4)->permissions()->sync($waiter_permissions->pluck('id'));

        // // Menambahkan izin untuk kepala_cheff fnb access & history_order
        // $kepalachef_permissions = Permission::where(function ($query) {
        //     $query->whereBetween('id', [74, 104])
        //           ->orWhereBetween('id', [105, 107])
        //           ->orWhere('id', 108);
        // })->get();
        // Role::findOrFail(5)->permissions()->sync($kepalachef_permissions->pluck('id'));

        // // Menambahkan izin untuk bartender fnb access & history_order
        // $bartender_permissions = Permission::where(function ($query) {
        //     $query->whereBetween('id', [74, 104])
        //           ->orWhereBetween('id', [105, 107])
        //           ->orWhere('id', 108);
        // })->get();
        // Role::findOrFail(6)->permissions()->sync($bartender_permissions->pluck('id'));
            
    }
}

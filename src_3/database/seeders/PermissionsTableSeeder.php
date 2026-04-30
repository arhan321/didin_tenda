<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'management_client_access',
            ],
            [
                'id'    => 18,
                'title' => 'client_access',
            ],
            [
                'id'    => 19,
                'title' => 'client_create',
            ],
            [
                'id'    => 20,
                'title' => 'client_edit',
            ],
            [
                'id'    => 21,
                'title' => 'client_show',
            ],
            [
                'id'    => 22,
                'title' => 'client_delete',
            ],
            [
                'id'    => 23,
                'title' => 'management_sdm_access',
            ],
            [
                'id'    => 24,
                'title' => 'position_access',
            ],
            [
                'id'    => 25,
                'title' => 'position_create',
            ],
            [
                'id'    => 26,
                'title' => 'position_edit',
            ],
            [
                'id'    => 27,
                'title' => 'position_show',
            ],
            [
                'id'    => 28,
                'title' => 'position_delete',
            ],
            [
                'id'    => 29,
                'title' => 'karyawan_access',
            ],
            [
                'id'    => 30,
                'title' => 'karyawan_create',
            ],
            [
                'id'    => 31,
                'title' => 'karyawan_edit',
            ],
            [
                'id'    => 32,
                'title' => 'karyawan_show',
            ],
            [
                'id'    => 33,
                'title' => 'karyawan_delete',
            ],
            [
                'id'    => 34,
                'title' => 'productmanagement_access',
            ],
            [
                'id'    => 35,
                'title' => 'vendor_create',
            ],
            [
                'id'    => 36,
                'title' => 'vendor_edit',
            ],
            [
                'id'    => 37,
                'title' => 'vendor_show',
            ],
            [
                'id'    => 38,
                'title' => 'vendor_delete',
            ],
            [
                'id'    => 39,
                'title' => 'vendor_access',
            ],
            [
                'id'    => 40,
                'title' => 'categoryproduct_create',
            ],
            [
                'id'    => 41,
                'title' => 'categoryproduct_edit',
            ],
            [
                'id'    => 42,
                'title' => 'categoryproduct_show',
            ],
            [
                'id'    => 43,
                'title' => 'categoryproduct_delete',
            ],
            [
                'id'    => 44,
                'title' => 'categoryproduct_access',
            ],
            [
                'id'    => 45,
                'title' => 'product_create',
            ],
            [
                'id'    => 46,
                'title' => 'product_edit',
            ],
            [
                'id'    => 47,
                'title' => 'product_show',
            ],
            [
                'id'    => 48,
                'title' => 'product_delete',
            ],
            [
                'id'    => 49,
                'title' => 'product_access',
            ],
            [
                'id'    => 50,
                'title' => 'order_create',
            ],
            [
                'id'    => 51,
                'title' => 'order_edit',
            ],
            [
                'id'    => 52,
                'title' => 'order_show',
            ],
            [
                'id'    => 53,
                'title' => 'order_delete',
            ],
            [
                'id'    => 54,
                'title' => 'order_access',
            ],
            [
                'id'    => 55,
                'title' => 'monitoring_create',
            ],
            [
                'id'    => 56,
                'title' => 'monitoring_edit',
            ],
            [
                'id'    => 57,
                'title' => 'monitoring_show',
            ],
            [
                'id'    => 58,
                'title' => 'monitoring_delete',
            ],
            [
                'id'    => 59,
                'title' => 'monitoring_access',
            ],
            [
                'id'    => 60,
                'title' => 'sahabatech_create',
            ],
            [
                'id'    => 61,
                'title' => 'sahabatech_edit',
            ],
            [
                'id'    => 62,
                'title' => 'sahabatech_show',
            ],
            [
                'id'    => 63,
                'title' => 'sahabatech_delete',
            ],
            [
                'id'    => 64,
                'title' => 'sahabatech_access',
            ],
            [
                'id'    => 65,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
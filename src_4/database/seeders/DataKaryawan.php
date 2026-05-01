<?php

namespace Database\Seeders;

use App\Models\Tim;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DataKaryawan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $karyawan = [
            [
                'id'    => 1,
                'name' => 'Arhan malik alrasyid', 
                'position' => 'owner',
                'status' => 'bekerja',
            ],
            // [
            //     'id'    => 2,
            //     'name' => 'Febru ardiansyah satmoko',
            //     'position' => 'manager_umum',
            //     'status' => 'bekerja',
            // ],
            // [
            //     'id'    => 3,
            //     'name' => 'enep',
            //     'position' => 'kasir',
            //     'status' => 'bekerja',
            // ],
            // [
            //     'id'   => 4,
            //     'name' => 'Fiolin merdi graciliea',
            //     'position' => 'waiter',
            //     'status' => 'bekerja',
            // ],
            // [
            //     'id'    => 5,
            //     'name' => 'adella',
            //     'position' => 'kepala_chef',
            //     'status' => 'bekerja',
            // ],
           
        ];

        Tim::insert($karyawan);
    }
}

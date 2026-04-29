<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vendors')->insert([
            [
                'nama_vendor' => 'PT. Mitra Integrasi Informatika',
                'alamat_vendor' => 'Jl. Raya Bogor KM 26, Ciracas, Jakarta Timur',
            ],
        ]);
    }
}

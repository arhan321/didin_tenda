<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

            // // Membuat instance faker
            // $faker = Faker::create();

            // // Loop untuk membuat 1500 data palsu
            // for ($i = 0; $i < 7000; $i++) {
            //     DB::table('clients')->insert([
            //         'nama_client' => $faker->company,
            //         'alamat_client' => $faker->address,
            //         'branch_client' => $faker->city,
            //         'nomor_telfon1_client' => $faker->phoneNumber,
            //         'nomor_telfon2_client' => $faker->phoneNumber,
            //         'faximile_client' => $faker->phoneNumber,
            //         'email_client' => $faker->unique()->safeEmail,
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //     ]);
            // }
            DB::table('clients')->insert([
                [
                    'nama_client' => 'Tunas BMW',
                    'alamat_client' => 'Jl. Boulevard Timur No. 1, Bekasi',
                    'branch_client' => 'Bekasi Showroom',
                    'nomor_telfon1_client' => '08123456789',
                    'nomor_telfon2_client' => '0628123456789',
                    'email_client' => 'bekasi@bmw-tunas.co.id',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nama_client' => 'Tunas BMW',
                    'alamat_client' => 'Jl. Tomang Raya No. 19, Jakarta Barat',
                    'branch_client' => 'Tomang Showroom',
                    'nomor_telfon1_client' => '0215633152',
                    'nomor_telfon2_client' => '081293252493',
                    'email_client' => 'tomang@bmw-tunas.co.id',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nama_client' => 'Tunas BMW',
                    'alamat_client' => 'Jl. Tomang Raya No. 19, Jakarta Barat',
                    'branch_client' => 'Tomang Workshop',
                    'nomor_telfon1_client' => '0215633152',
                    'nomor_telfon2_client' => '083873261695',
                    'email_client' => 'workshop.tomang@bmw-tunas.co.id',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nama_client' => 'Tunas BMW',
                    'alamat_client' => 'Jl. Prof. DR. Soepomo No. 174, Jakarta Selatan',
                    'branch_client' => 'Tebet Showroom',
                    'nomor_telfon1_client' => '0218301805',
                    'nomor_telfon2_client' => '08995697010',
                    'email_client' => 'tebet.showroom@bmw-tunas.co.id',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nama_client' => 'Tunas BMW',
                    'alamat_client' => 'Jl. Prof. DR. Soepomo No. 174, Jakarta Selatan',
                    'branch_client' => 'Tebet Workshop',
                    'nomor_telfon1_client' => '0218301805',
                    'nomor_telfon2_client' => '089629677062',
                    'email_client' => 'workshop.tebet@bmw-tunas.co.id',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
            
        
    }
}

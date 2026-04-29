<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//   // Membuat instance faker
//   $faker = Faker::create();

//   // Loop untuk membuat 500 data palsu
//   for ($i = 0; $i < 500; $i++) {
//       DB::table('products')->insert([
//           'name' => $faker->word . ' ' . $faker->word,
//           'description' => $faker->sentence,
//           'price' => $faker->randomFloat(2, 10000, 10000000), // Harga antara 10 ribu hingga 10 juta
//           'jangka_waktu' => '1 bulan',
//           'stock' => $faker->numberBetween(1, 100),
//           'category' => $faker->randomElement(['Printer', 'Laptop', 'Mesin Foto Copy', 'ATK']),
//           'created_at' => now(),
//           'updated_at' => now(),
//       ]);
//   }
        
        DB::table('products')->insert([
            [
                'name' => 'Kyocera ECOSYS M2040dn KX',
                // 'description' => 'Printer laser berkualitas tinggi untuk kantor',
                'harga_beli' => 900000.00,
                'harga_sewa' => 1000000.00,
                'jangka_waktu' => '1 bulan',
                // 'stock_awal' => 100,
                // 'stock_outstanding' => 100,
                // 'category_id' => 1,
                // 'vendor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Footer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FooterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $footer = [
            [
                'id' => 1,
                'logo_restoran' => 'HANS BAR AND RESTAURANT',
                'detail' => 'HANS BAR AND RESTAURANT',
                'alamat' => 'Aloha Playground, Pasir putih PIK 2 JKT29909, INA',
                'phone' => '+62 828990 0990',
                'faximile' => '+62 828990 0990',
                'email' => 'hansvocresto@gmail.com',
                'opening_day' => 'Monday - Sunday',
                'opening_hours' => '09:00:00', // Format waktu
                'closing_hours' => '22:00:00', // Format waktu
                'copyright' => 'Hans Bar And Restaurant. All Rights Reserved',
                'desain_by' => 'Hans bar and restaurant',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
           
        ];

        Footer::insert($footer);
    }
}

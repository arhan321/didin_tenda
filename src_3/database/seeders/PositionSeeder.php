<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('positions')->insert([
            [
                'nama_posisi' => 'Manager',
                'deskripsi_posisi' => 'Bertanggung jawab atas operasional tim',
                'tugas_posisi' => 'Mengawasi kegiatan tim, membuat laporan',
                'gaji_pokok' => 10000000,
                'tunjangan_makan' => 1000000,
                'tunjangan_transport' => 1000000,
                'tunjangan_kesehatan' => 500000,
                'tunjangan_ketenagakerjaan' => 1500000,
                'total_gaji' => 14000000, // Total gaji dihitung dari gaji pokok + tunjangan
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_posisi' => 'IT Support',
                'deskripsi_posisi' => 'Membantu tim IT dalam troubleshooting',
                'tugas_posisi' => 'Menangani masalah IT dan memberikan dukungan teknis',
                'gaji_pokok' => 5000000,
                'tunjangan_makan' => 500000,
                'tunjangan_transport' => 500000,
                'tunjangan_kesehatan' => 250000,
                'tunjangan_ketenagakerjaan' => 750000,
                'total_gaji' => 7000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_posisi' => 'Staff Administrasi',
                'deskripsi_posisi' => 'Mengelola administrasi perusahaan',
                'tugas_posisi' => 'Melakukan pengarsipan, penjadwalan, dan korespondensi',
                'gaji_pokok' => 4000000,
                'tunjangan_makan' => 400000,
                'tunjangan_transport' => 400000,
                'tunjangan_kesehatan' => 200000,
                'tunjangan_ketenagakerjaan' => 600000,
                'total_gaji' => 5600000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_posisi' => 'Marketing',
                'deskripsi_posisi' => 'Mengembangkan strategi pemasaran',
                'tugas_posisi' => 'Merancang dan menjalankan kampanye pemasaran',
                'gaji_pokok' => 6000000,
                'tunjangan_makan' => 600000,
                'tunjangan_transport' => 600000,
                'tunjangan_kesehatan' => 300000,
                'tunjangan_ketenagakerjaan' => 900000,
                'total_gaji' => 8400000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_posisi' => 'HRD',
                'deskripsi_posisi' => 'Bertanggung jawab atas manajemen sumber daya manusia',
                'tugas_posisi' => 'Rekrutmen, pelatihan, dan evaluasi karyawan',
                'gaji_pokok' => 8000000,
                'tunjangan_makan' => 800000,
                'tunjangan_transport' => 800000,
                'tunjangan_kesehatan' => 400000,
                'tunjangan_ketenagakerjaan' => 1200000,
                'total_gaji' => 11200000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

<?php

namespace App\Charts;

use Carbon\Carbon;
use App\Models\Order;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class MontlyIncome
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\AreaChart
    {
        // Mendapatkan tahun saat ini
        $currentYear = Carbon::now()->year;

        $monthsFull = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        // Mengambil data berdasarkan field "start" dan filter berdasarkan tahun saat ini
        $incomeData = Order::selectRaw('SUM(price) as total_income, MONTH(start) as month')
            ->whereYear('start', $currentYear)  // Filter berdasarkan tahun di kolom "start"
            ->whereNotNull('start')  // Pastikan kolom "start" tidak null
            ->where('status_bayar', 'Sudah bayar')   // Hanya menghitung yang "Sudah bayar"
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Inisialisasi data pendapatan per bulan
        $monthlyIncome = array_fill(0, 12, 0); 

        // Isi array bulanan dengan data pendapatan yang ditemukan
        foreach ($incomeData as $data) {
            $monthlyIncome[$data->month - 1] = $data->total_income; 
        }

        // Membuat chart dengan keterangan tahun di judul/subtitle
        return $this->chart->areaChart()
            ->setTitle('Pendapatan CV. TRI ASTRA PERSADA ' . $currentYear) // Menampilkan tahun saat ini di judul
            ->setSubtitle('Pendapatan Perbulan Berdasarkan Order (Field Start) untuk Tahun ' . $currentYear)
            ->addData('Pendapatan', $monthlyIncome)
            ->setXAxis($monthsFull);
    }
}

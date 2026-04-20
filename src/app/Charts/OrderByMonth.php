<?php

namespace App\Charts;

use Carbon\Carbon;
use App\Models\Order;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class OrderByMonth
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\HorizontalBar
    {
        $currentYear = Carbon::now()->year;

        // Array bulan
        $monthsFull = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        // Array warna untuk setiap bulan
        $colors = [
            '#FF5733', '#33FF57', '#3357FF', '#FF33A1', '#57FF33', '#FFBD33',
            '#33FFBD', '#8D33FF', '#FF338D', '#338DFF', '#BDFF33', '#FF5733'
        ];

        // Query dengan filter status_bayar "Sudah bayar" dan berdasarkan tanggal 'start'
        $orderData = Order::selectRaw('COUNT(*) as total_orders, MONTH(start) as month')
            ->whereYear('start', $currentYear)
            ->whereNotNull('start')  // Pastikan kolom start tidak null
            ->where('status_bayar', 'Sudah bayar') // Filter hanya untuk order "Sudah bayar"
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyOrders = array_fill(0, 12, 0);

        foreach ($orderData as $data) {
            $monthlyOrders[$data->month - 1] = $data->total_orders;
        }

        return $this->chart->horizontalBarChart()
            ->setTitle('Jumlah Order per Bulan ' . $currentYear)
            ->setSubtitle('Data order berdasarkan tanggal mulai (start) untuk tahun ' . $currentYear)
            ->addData('Jumlah Order', $monthlyOrders)
            ->setXAxis($monthsFull)
            ->setColors($colors); // Menambahkan warna untuk setiap bulan
    }
}

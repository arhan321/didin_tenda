<?php

namespace App\Http\Controllers\Admin;

// use App\Models\Order;
use App\Models\Client;
use App\Models\Product;
use App\Models\Karyawan;
// use App\Charts\Montlyincome;
// use App\Charts\OrderByMonth;
use App\Models\OrdersBarang;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // $totalClients = Client::count(); 
        // $totalorders = Order::count();
        // $totalproducts = Product::count();
        // $totalemployee = Karyawan::count();
        // $totalordersbarang = OrdersBarang::count();

        // Cek email pengguna yang sedang login
        $user = Auth::user();
        $excludedEmails = ['sahabatech@gmail.com','alif@gmail.com']; // Array berisi email yang tidak bisa melihat chart
        
        // Menggunakan in_array untuk pengecekan
        $canViewCharts = !in_array($user->email, $excludedEmails); // Tidak bisa melihat widget dan chart jika email ada dalam array

        // Kondisional: hanya kirim data widget dan chart jika pengguna bisa melihatnya
        return view('home', [
            // 'chart' => $canViewCharts ? $chart->build() : null, // Jika tidak bisa, kirim null
            // 'chart2' => $canViewCharts ? $chart2->build() : null, // Jika tidak bisa, kirim null
            // 'totalClients' => $canViewCharts ? $totalClients : null, // Jika tidak bisa, kirim null
            // 'totalorders' => $canViewCharts ? $totalorders : null, // Jika tidak bisa, kirim null
            // 'totalproducts' => $canViewCharts ? $totalproducts : null, // Jika tidak bisa, kirim null
            // 'totalemployee' => $canViewCharts ? $totalemployee : null, // Jika tidak bisa, kirim null
            'canViewCharts' => $canViewCharts // Kirim flag ini ke view untuk logika tampilan
            
        ]);
    }
}







    // {
    //     $totalClients = Client::count(); 
    //     $totalorders = Order::count();
    //     $totalproducts = Product::count();
    //     $totalemployee = Karyawan::count();

    //     return view('home', [
    //         'chart' => $chart->build(),
    //         'chart2' => $chart2->build(),
    //         'totalClients' => $totalClients, 
    //         'totalorders' => $totalorders,
    //         'totalproducts' => $totalproducts,
    //         'totalemployee' =>$totalemployee
    //     ]);


    // }
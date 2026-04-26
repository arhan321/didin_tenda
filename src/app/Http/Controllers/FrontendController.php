<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home(){
        // $Home = Home::all();
        return view ('frontend.index');
    }
    public function paket(){
        // $Home = Home::all();
        return view ('frontend.paket-custom');
    }

    public function cart(){
        // $Home = Home::all();
        return view ('frontend.cart');
    }

    public function history(){
        return view ('frontend.history');
    }

    public function detail_paket(){
        return view ('frontend.paket');
    }

    public function pesanan () {
        return view ('frontend.pesanan');
    }

    public function profile()
{
    return view('frontend.profile');
}
}

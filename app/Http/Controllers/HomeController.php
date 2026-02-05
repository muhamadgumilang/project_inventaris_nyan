<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userId = \Illuminate\Support\Facades\Auth::id();
        
        // Items available for borrowing (with stock)
        $availableBarang = \App\Models\Barang::with(['kategori', 'lokasi'])
            ->where('jumlah', '>', 0)
            ->latest()
            ->take(8)
            ->get();
            
        // User's own borrowings
        $myPeminjaman = \App\Models\Peminjaman::where('user_id', $userId)
            ->with('barang')
            ->latest()
            ->take(5)
            ->get();
            
        // Stats for the user
        $myActiveLoans = \App\Models\Peminjaman::where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->count();
            
        $totalItemsAvailable = \App\Models\Barang::where('jumlah', '>', 0)->sum('jumlah');
        $totalCategories = \App\Models\Kategori::count();

        // Also providing all barang for the quick borrowing modal/form
        $allBarang = \App\Models\Barang::where('jumlah', '>', 0)->get();
        
        return view('home', compact(
            'availableBarang',
            'myPeminjaman',
            'myActiveLoans',
            'totalItemsAvailable',
            'totalCategories',
            'allBarang'
        ));
    }
}
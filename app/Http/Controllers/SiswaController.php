<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function dashboard()
    {
        $menus = Menu::orderBy('kategori')
            ->orderBy('nama_menu')
            ->get();

        $pesanans = Pesanan::with('menu')
            ->where('user_id', session('user_id'))
            ->orderBy('id', 'desc')
            ->get();

        return view('siswa.dashboard', compact('menus', 'pesanans'));
    }

    public function storePesanan(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => ['required', 'integer', 'exists:menu,id'],
            'jumlah' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        $menu = Menu::findOrFail($validated['menu_id']);

        $jumlah = $validated['jumlah'];
        $totalHarga = $menu->harga * $jumlah;

        
Pesanan::create([
    'user_id' => session('user_id'),
    'menu_id' => $menu->id,
    'jumlah' => $jumlah,
    'total_harga' => $totalHarga,
    'status' => 'Menunggu Konfirmasi',
    'status_pembayaran' => 'Belum Dibayar',
]);


        return redirect()
            ->route('siswa.dashboard')
            ->with('success', 'Pesanan berhasil dibuat.');
    }

    public function riwayatPesanan()
    {
        $pesanans = Pesanan::with('menu')
            ->where('user_id', session('user_id'))
            ->orderBy('id', 'desc')
            ->get();

        return view('siswa.riwayat', compact('pesanans'));
    }
}

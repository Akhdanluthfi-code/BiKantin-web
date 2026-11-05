<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function dashboard()
    {
        $pesanans = Pesanan::with(['user', 'menu'])
            ->orderBy('id', 'desc')
            ->get();

        return view('kasir.dashboard', compact('pesanans'));
    }

    public function konfirmasiPembayaran($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        if ($pesanan->status_pembayaran === 'Lunas') {
            return redirect()
                ->route('kasir.dashboard')
                ->with('error', 'Pembayaran pesanan ini sudah dikonfirmasi.');
        }

        $pesanan->status_pembayaran = 'Lunas';
        $pesanan->save();

        return redirect()
            ->route('kasir.dashboard')
            ->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }
}

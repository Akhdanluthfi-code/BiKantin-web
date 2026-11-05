<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $menus = Menu::orderBy('id', 'desc')->get();

        $pesanans = Pesanan::with(['user', 'menu'])
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.dashboard', compact('menus', 'pesanans'));
    }

    
public function storeMenu(Request $request)
{
    $validated = $request->validate([
        'nama_menu' => ['required', 'string', 'max:100'],
        'harga' => ['required', 'integer', 'min:0'],
        'kategori' => ['required', 'string', 'max:50'],
        'deskripsi' => ['nullable', 'string'],
        'foto' => ['nullable', 'string', 'max:255'],
    ]);

    Menu::create($validated);

    return redirect()
        ->route('admin.dashboard')
        ->with('success', 'Menu berhasil ditambahkan.');
}

public function updateMenu(Request $request, $id)
{
    $validated = $request->validate([
        'nama_menu' => ['required', 'string', 'max:100'],
        'harga' => ['required', 'integer', 'min:0'],
        'kategori' => ['required', 'string', 'max:50'],
        'deskripsi' => ['nullable', 'string'],
        'foto' => ['nullable', 'string', 'max:255'],
    ]);

    $menu = Menu::findOrFail($id);
    $menu->update($validated);

    return redirect()
        ->route('admin.dashboard')
        ->with('success', 'Menu berhasil diperbarui.');
}

    public function deleteMenu($id)
    {
        $menu = Menu::findOrFail($id);

        // Menu tidak dihapus jika masih digunakan oleh pesanan.
        if (Pesanan::where('menu_id', $menu->id)->exists()) {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'Menu tidak dapat dihapus karena sudah digunakan dalam pesanan.');
        }

        $menu->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Menu berhasil dihapus.');
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:Menunggu Konfirmasi,Sedang Dimasak,Siap Diambil,Selesai',
            ],
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status = $validated['status'];
        $pesanan->save();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }
}

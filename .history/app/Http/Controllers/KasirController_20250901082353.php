<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index()
    {
        $barangs = Barang::where('stok', '>', 0)->get();
        $transaksis = Transaksi::latest()->get();
        return view('kasir.index', compact('barangs', 'transaksis'));
    }

    public function tambahBarang(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'stok' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
        ]);

        // Cari barang dengan nama & harga yang sama
        $barang = Barang::where('nama', $request->nama)
            ->where('harga', $request->harga)
            ->first();

        if ($barang) {
            // Kalau sudah ada (nama & harga sama), tambahkan stok
            $barang->stok += $request->stok;
            $barang->save();
        } else {
            // Kalau belum ada atau harganya beda, buat barang baru
            Barang::create([
                'nama' => $request->nama,
                'stok' => $request->stok,
                'harga' => $request->harga,
            ]);
        }

        return back()->with('success', 'Barang berhasil ditambahkan!');
    }



    public function transaksi(Request $request)
    {
        $barang = Barang::findOrFail($request->barang_id);

        if ($barang->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        $total = $barang->harga * $request->jumlah;

        Transaksi::create([
            'barang_id' => $barang->id,
            'jumlah' => $request->jumlah,
            'total_harga' => $total,
        ]);

        $barang->decrement('stok', $request->jumlah);

        return back()->with('success', 'Transaksi berhasil!');
    }
}

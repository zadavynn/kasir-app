<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KasirController extends Controller
{
    // Halaman Tambah Barang
    public function index()
    {
        // Ambil semua barang dengan stok > 0 (opsional, bisa dihilangkan jika tidak dipakai di halaman tambah barang)
        $barangs = Barang::where('stok', '>', 0)->get();

        // Tidak perlu ambil transaksi di halaman tambah barang
        return view('kasir.index', compact('barangs'));
    }

    // Proses tambah barang
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

        return redirect()->route('kasir.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    // Halaman Transaksi
    public function showTransaksi()
    {
        $now = Carbon::now('Asia/Jakarta');

        // Ambil transaksi bulan berjalan (WIB)
        $transaksis = Transaksi::with('barang')
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->orderBy('created_at', 'desc')
            ->get();

        $barangs = Barang::where('stok', '>', 0)->get();

        return view('kasir.transaksi', compact('transaksis', 'barangs'));
    }

    // Proses transaksi
    public function transaksi(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($barang->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi!');
        }

        $total = $barang->harga * $request->jumlah;

        Transaksi::create([
            'barang_id' => $barang->id,
            'jumlah' => $request->jumlah,
            'total_harga' => $total,
        ]);

        $barang->decrement('stok', $request->jumlah);

        return redirect()->route('kasir.transaksi.view')->with('success', 'Transaksi berhasil!');
    }
}

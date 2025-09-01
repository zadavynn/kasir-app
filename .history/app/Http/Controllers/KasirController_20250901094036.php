<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KasirController extends Controller
{
    // Halaman Tambah Barang
    public function index()
    {
        return view('index');
    }

    // Proses tambah barang
    public function tambahBarang(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'stok' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0.01',
        ]);

        Barang::updateOrCreate(
            ['nama' => $request->nama, 'harga' => $request->harga],
            ['stok' => DB::raw("stok + {$request->stok}")]
        );

        return redirect()->route('kasir.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    // Halaman Transaksi
    public function showTransaksi()
    {
        $now = Carbon::now('Asia/Jakarta');

        $transaksis = Transaksi::with('barang')
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->orderByDesc('created_at')
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

        DB::transaction(function () use ($request) {
            $barang = Barang::lockForUpdate()->findOrFail($request->barang_id);

            if ($barang->stok < $request->jumlah) {
                throw new \Exception('Stok tidak mencukupi!');
            }

            $total = $barang->harga * $request->jumlah;

            Transaksi::create([
                'barang_id'   => $barang->id,
                'jumlah'      => $request->jumlah,
                'total_harga' => $total,
            ]);

            $barang->decrement('stok', $request->jumlah);
        });

        return redirect()->route('kasir.transaksi.view')->with('success', 'Transaksi berhasil!');
    }
}

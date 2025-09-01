<!DOCTYPE html>
<html>
<head>
    <title>Sistem Kasir Sederhana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

    <h2 class="mb-3">Sistem Kasir</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <!-- Tambah Barang -->
        <div class="col-md-6">
            <h4>Tambah Barang</h4>
            <form method="POST" action="{{ route('kasir.barang') }}">
                @csrf
                <input type="text" name="nama" placeholder="Nama Barang" class="form-control mb-2" required>
                <input type="number" name="stok" placeholder="Stok" class="form-control mb-2" required>
                <input type="number" step="0.01" name="harga" placeholder="Harga" class="form-control mb-2" required>
                <button class="btn btn-primary">Tambah</button>
            </form>
        </div>

        <!-- Transaksi -->
        <div class="col-md-6">
            <h4>Transaksi</h4>
            <form method="POST" action="{{ route('kasir.transaksi') }}">
                @csrf
                <select name="barang_id" class="form-control mb-2" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->id }}">{{ $barang->nama }} (Stok: {{ $barang->stok }})</option>
                    @endforeach
                </select>
                <input type="number" name="jumlah" placeholder="Jumlah" class="form-control mb-2" required>
                <button class="btn btn-success">Bayar</button>
            </form>
        </div>
    </div>

    <!-- Daftar Transaksi -->
    <h4 class="mt-4">Riwayat Transaksi</h4>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Barang</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
            <th>Tanggal</th>
        </tr>
        @foreach($transaksis as $t)
            <tr>
                <td>{{ $t->id }}</td>
                <td>{{ $t->barang->nama }}</td>
                <td>{{ $t->jumlah }}</td>
                <td>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                <td>{{ $t->created_at->format('d-m-Y H:i') }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>

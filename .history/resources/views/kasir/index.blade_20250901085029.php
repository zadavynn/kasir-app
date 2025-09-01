<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sistem Kasir Sederhana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        /* Membuat tabel riwayat transaksi scrollable di layar kecil */
        .table-responsive {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <h2 class="mb-4 text-center">Sistem Kasir</h2>

        {{-- Alert Success & Error --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Form Tambah Barang -->
            <div class="col-lg-6 col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Tambah Barang</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('kasir.barang') }}" id="formTambahBarang" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Barang</label>
                                <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan nama barang" required />
                                <div class="invalid-feedback">Nama barang wajib diisi.</div>
                            </div>
                            <div class="mb-3">
                                <label for="stok" class="form-label">Stok</label>
                                <input type="number" id="stok" name="stok" class="form-control" placeholder="Jumlah stok" min="1" required />
                                <div class="invalid-feedback">Stok harus berupa angka minimal 1.</div>
                            </div>
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga (Rp)</label>
                                <input type="number" id="harga" name="harga" class="form-control" placeholder="Harga satuan" min="0.01" step="0.01" required />
                                <div class="invalid-feedback">Harga harus lebih dari 0.</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="reset" class="btn btn-secondary">Reset</button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Form Transaksi -->
            <div class="col-lg-6 col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Transaksi</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('kasir.transaksi') }}" id="formTransaksi" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="barang_id" class="form-label">Pilih Barang</label>
                                <select id="barang_id" name="barang_id" class="form-select" required>
                                    <option value="" selected disabled>-- Pilih Barang --</option>
                                    @foreach ($barangs as $barang)
                                        <option value="{{ $barang->id }}">
                                            {{ $barang->nama }} (Stok: {{ $barang->stok }}, Rp{{ number_format($barang->harga, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Silakan pilih barang.</div>
                            </div>
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah barang" min="1" required />
                                <div class="invalid-feedback">Jumlah harus minimal 1.</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="reset" class="btn btn-secondary">Reset</button>
                                <button type="submit" class="btn btn-success">Bayar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Transaksi -->
        <div class="mt-5">
            <h4 class="mb-3">Riwayat Transaksi</h4>
            <div class="table-responsive shadow-sm rounded">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th scope="col" style="width: 5%;">ID</th>
                            <th scope="col">Barang</th>
                            <th scope="col" style="width: 10%;">Jumlah</th>
                            <th scope="col" style="width: 15%;">Total Harga</th>
                            <th scope="col" style="width: 20%;">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksis as $t)
                            <tr>
                                <td>{{ $t->id }}</td>
                                <td>{{ $t->barang->nama }}</td>
                                <td>{{ $t->jumlah }}</td>
                                <td>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                                <td>{{ $t->created_at->format('d-m-Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS + Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Form validation script -->
    <script>
        (() => {
            'use strict'

            // Ambil semua form yang butuh validasi
            const forms = document.querySelectorAll('form')

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>

</html>

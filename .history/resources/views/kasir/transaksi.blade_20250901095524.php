@extends('layout.sidebar')

@section('title', 'Halaman Transaksi Kasir')

@section('content')
<div class="d-flex">
    <div class="flex-grow-1 p-4">
        <h2 class="mb-4">Transaksi</h2>

        {{-- Alert Success & Error --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-success">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert-error">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="POST" action="route('kasir.transaksi.view')
" id="formTransaksi" novalidate>
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
                        <input type="number" id="jumlah" name="jumlah" class="form-control"
                            placeholder="Jumlah barang" min="1" required />
                        <div class="invalid-feedback">Jumlah harus minimal 1.</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-success">Bayar</button>
                    </div>
                </form>
            </div>
        </div>

        <h4 class="mb-3">Riwayat Transaksi Bulan Ini</h4>
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
                            <td>{{ $t->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada transaksi bulan ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Script validasi form --}}
<script>
    (() => {
        'use strict'

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

        // Notifikasi otomatis hilang setelah 5 detik
        setTimeout(() => {
            const alertSuccess = document.getElementById('alert-success')
            const alertError = document.getElementById('alert-error')
            if (alertSuccess) {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alertSuccess)
                bsAlert.close()
            }
            if (alertError) {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alertError)
                bsAlert.close()
            }
        }, 5000)
    })()
</script>
@endsection

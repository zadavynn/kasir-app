@extends('layout.sidebar')

@section('title', 'Halaman Dashboard')

@section('content')
    <div class="d-flex">
        <div class="flex-grow-1 p-4">
            <h2 class="mb-4">Tambah Barang</h2>

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

            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('kasir.barang.store') }}" id="formTambahBarang" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Barang</label>
                            <input type="text" id="nama" name="nama" class="form-control"
                                placeholder="Masukkan nama barang" required />
                            <div class="invalid-feedback">Nama barang wajib diisi.</div>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" id="stok" name="stok" class="form-control"
                                placeholder="Jumlah stok" min="1" required />
                            <div class="invalid-feedback">Stok harus berupa angka minimal 1.</div>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga (Rp)</label>
                            <input type="number" id="harga" name="harga" class="form-control"
                                placeholder="Harga satuan" min="0.01" step="0.01" required />
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
    </div>

    {{-- Script validasi form --}}
    <script>
        (() => {
            'use strict'

            // Validasi form
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

            // Fungsi auto dismiss alert
            function autoDismissAlert(id, delay = 5000) {
                const alertEl = document.getElementById(id)
                if (alertEl) {
                    setTimeout(() => {
                        // hilangkan class 'show' → otomatis fade out
                        alertEl.classList.remove('show')

                        // tunggu animasi fade selesai (500ms default Bootstrap)
                        setTimeout(() => {
                            const bsAlert = bootstrap.Alert.getOrCreateInstance(alertEl)
                            bsAlert.close()
                        }, 500)
                    }, delay)
                }
            }

            // Jalankan untuk success & error
            autoDismissAlert('alert-success')
            autoDismissAlert('alert-error')
        })()
    </script>

@endsection

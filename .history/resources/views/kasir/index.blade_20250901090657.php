@extends('layout.sidebar')

@section('title', 'Halaman Dashboard Kasir')

@section('content')

    {{-- resources/views/index.blade.php --}}
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Tambah Barang - Sistem Kasir</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    </head>

    <body>
        <div class="d-flex">
            @include('layouts.sidebar')

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
                        <form method="POST" action="{{ route('kasir.barang') }}" id="formTambahBarang" novalidate>
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

        <!-- Bootstrap JS + Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Form validation script -->
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

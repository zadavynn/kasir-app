<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
</head>

<body>
    {{-- resources/views/layouts/sidebar.blade.php --}}
    <nav class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 250px; min-height: 100vh;">
        <a href="{{ url('/') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">
            <span class="fs-4 fw-bold">Sistem Kasir</span>
        </a>
        <hr />
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item mb-1">
                <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : 'link-dark' }}">
                    <i class="bi bi-box-seam me-2"></i> Tambah Barang
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('kasir.transaksi.view') }}"
                    class="nav-link {{ request()->is('transaksi') ? 'active' : 'link-dark' }}">
                    <i class="bi bi-cash-stack me-2"></i> Transaksi
                </a>
            </li>
        </ul>
        <hr />
        <div class="text-muted small">&copy; {{ date('Y') }} Sistem Kasir</div>
    </nav>


</body>

</html>

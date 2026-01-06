@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mb-4">
        {{-- Header dengan Flexbox agar Judul di Kiri dan Tombol di Kanan --}}
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span class="fw-bold">Detail Kategori</span>
            
            {{-- TOMBOL DOWNLOAD PDF --}}
            {{-- Mengarah ke route yang sudah kita buat di web.php --}}
            <a href="{{ url('categories/pdf/' . $category->id) }}" class="btn btn-light btn-sm text-primary fw-bold" target="_blank">
                🖨️ Download PDF
            </a>
        </div>

        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <td width="150"><strong>Kode</strong></td>
                    <td>: {{ $category->kode }}</td>
                </tr>
                <tr>
                    <td><strong>Nama</strong></td>
                    <td>: {{ $category->nama }}</td>
                </tr>
            </table>
        </div>
    </div>

    <h4>List Items dalam Kategori Ini:</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Kode Item</th>
                    <th>Nama Item</th>
                    <th>Harga Beli</th>
                    <th>Supplier</th>
                </tr>
            </thead>
            <tbody>
                @forelse($category->items as $item)
                <tr>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                    <td>{{ $item->supplier }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted p-4">
                        <em>Belum ada item yang terhubung dengan kategori ini.</em>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-3">
        <a href="{{ url('categories') }}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
    </div>
</div>
@endsection
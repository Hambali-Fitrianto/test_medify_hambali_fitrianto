@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Detail Kategori</div>
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
            <thead>
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
                    <td>Rp {{ number_format($item->harga_beli) }}</td>
                    <td>{{ $item->supplier }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Belum ada item yang terhubung dengan kategori ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <a href="{{ url('categories') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Kategori</a>
</div>
@endsection
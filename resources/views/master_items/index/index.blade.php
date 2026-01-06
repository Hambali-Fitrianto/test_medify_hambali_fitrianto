@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        {{-- Menggunakan col-md-12 agar tabel lebar penuh --}}
        <div class="col-md-12"> 
            
            {{-- Header & Tombol Action --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0 text-secondary">Master Items</h4>
                <div>
                    {{-- Tombol Shortcut ke Kategori (Opsional, memudahkan navigasi) --}}
                    <a href="{{ url('categories') }}" class="btn btn-outline-secondary me-2">
                        Kelola Kategori
                    </a>
                    {{-- Tombol Tambah Item Baru --}}
                    <a href="{{ url('master-items/form/new') }}" class="btn btn-primary">
                        + Item Baru
                    </a>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <strong>Daftar Data Barang</strong>
                </div>

                <div class="card-body">
                    {{-- Bagian Filter --}}
                    <div class="mb-4 p-3 bg-light rounded border">
                        @include('master_items.index.filter')
                    </div>
                    
                    {{-- Bagian Tabel --}}
                    <div class="table-responsive">
                        @include('master_items.index.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    {{-- Memanggil script JS khusus halaman ini --}}
    @include('master_items.index.js')
@endsection
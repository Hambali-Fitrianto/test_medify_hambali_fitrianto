@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Daftar Kategori Items</h3>
    <a href="{{ url('categories/form/new') }}" class="btn btn-primary mb-3">Tambah Kategori</a>
    
    {{-- Filter --}}
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" id="filter-kode" class="form-control" placeholder="Cari Kode...">
                </div>
                <div class="col-md-4">
                    <input type="text" id="filter-nama" class="form-control" placeholder="Cari Nama...">
                </div>
                <div class="col-md-4">
                    <button onclick="loadCategories()" class="btn btn-secondary w-100">Filter</button>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-striped" id="table-category">
        <thead class="table-dark">
            <tr>
                <th>Kode</th>
                <th>Nama Kategori</th>
                <th width="20%">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@endsection

@section('js')
<script>
$(document).ready(function(){ loadCategories(); });

function loadCategories() {
    $.ajax({
        url: "{{ url('categories/search') }}",
        data: {
            kode: $('#filter-kode').val(),
            nama: $('#filter-nama').val()
        },
        success: function(res) {
            let rows = '';
            if(res.data.length > 0) {
                $.each(res.data, function(i, val){
                    let editUrl = "{{ url('categories/form/edit') }}/" + val.id;
                    let viewUrl = "{{ url('categories/view') }}/" + val.id;
                    let delUrl = "{{ url('categories/delete') }}/" + val.id;
                    
                    rows += `<tr>
                        <td>${val.kode}</td>
                        <td>${val.nama}</td>
                        <td>
                            <a href="${viewUrl}" class="btn btn-info btn-sm">View</a>
                            <a href="${editUrl}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="${delUrl}" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kategori ini?')">Hapus</a>
                        </td>
                    </tr>`;
                });
            } else {
                rows = `<tr><td colspan="3" class="text-center">Data tidak ditemukan</td></tr>`;
            }
            $('#table-category tbody').html(rows);
        }
    });
}
</script>
@endsection
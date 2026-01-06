{{-- Pastikan enctype="multipart/form-data" ada, jika tidak upload foto akan gagal --}}
<form method="POST" enctype="multipart/form-data">
    @csrf
    
    {{-- Kode Barang (Hanya muncul saat Edit) --}}
    @if($method == 'edit')
    <div class="form-group mb-3">
        <label>Kode Barang</label>
        <input type="text" class="form-control" name="kode_barang" required readonly value="{{$item->kode ?? ''}}">
    </div>
    @endif

    {{-- Nama Item --}}
    <div class="form-group mb-3">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required value="{{$item->nama ?? ''}}">
    </div>

    {{-- Harga Beli --}}
    <div class="form-group mb-3">
        <label>Harga Beli</label>
        <input type="number" class="form-control" name="harga_beli" required value="{{$item->harga_beli ?? ''}}">
    </div>

    {{-- Laba --}}
    <div class="form-group mb-3">
        <label>Laba (dalam persen)</label>
        <input type="number" class="form-control" name="laba" required value="{{$item->laba ?? ''}}">
    </div>

    {{-- Supplier --}}
    @php $selected = $item->supplier ?? ''; @endphp
    <div class="form-group mb-3">
        <label>Supplier</label>
        <select class="form-control" required name="supplier">
            <option @if($selected == '') selected @endif value="">--Pilih--</option>
            <option @if($selected == 'Tokopaedi') selected @endif>Tokopaedi</option>
            <option @if($selected == 'Bukulapuk') selected @endif>Bukulapuk</option>
            <option @if($selected == 'TokoBagas') selected @endif>TokoBagas</option>
            <option @if($selected == 'E Commurz') selected @endif>E Commurz</option>
            <option @if($selected == 'Blublu') selected @endif>Blublu</option>
        </select>
    </div>

    {{-- Jenis --}}
    @php $selected = $item->jenis ?? ''; @endphp
    <div class="form-group mb-3">
        <label>Jenis</label>
        <select class="form-control" required name="jenis">
            <option @if($selected == '') selected @endif value="">--Pilih--</option>
            <option @if($selected == 'Obat') selected @endif>Obat</option>
            <option @if($selected == 'Alkes') selected @endif>Alkes</option>
            <option @if($selected == 'Matkes') selected @endif>Matkes</option>
            <option @if($selected == 'Umum') selected @endif>Umum</option>
            <option @if($selected == 'ATK') selected @endif>ATK</option>
        </select>
    </div>

    {{-- === PERBAIKAN: Input Kategori Items (Checkbox List) === --}}
    <div class="form-group mb-3">
        <label class="mb-2"><strong>Kategori Items</strong> (Klik kotak untuk memilih)</label>
        
        {{-- Card Container agar rapi --}}
        <div class="card p-3" style="max-height: 250px; overflow-y: auto; background-color: #f9f9f9;">
            @if(isset($all_categories) && count($all_categories) > 0)
                @foreach($all_categories as $cat)
                    <div class="form-check mb-1">
                        {{-- Checkbox Input --}}
                        <input class="form-check-input" type="checkbox" 
                               name="categories[]" 
                               value="{{ $cat->id }}" 
                               id="cat_{{ $cat->id }}"
                               {{-- Cek apakah ID ini ada di array selected (khusus mode edit) --}}
                               @if(isset($selected_categories) && in_array($cat->id, $selected_categories)) checked @endif
                        >
                        
                        {{-- Label (Bisa diklik teksnya juga) --}}
                        <label class="form-check-label" for="cat_{{ $cat->id }}" style="cursor: pointer; user-select: none;">
                            {{ $cat->nama }} <span class="text-muted" style="font-size: 0.85em;">({{ $cat->kode }})</span>
                        </label>
                    </div>
                @endforeach
            @else
                <p class="text-muted mb-0">Belum ada data kategori.</p>
            @endif
        </div>
        <small class="text-muted mt-1 d-block">Anda bisa memilih lebih dari satu kategori sekaligus.</small>
    </div>
    {{-- ======================================================== --}}

    {{-- Input Foto --}}
    <div class="form-group mb-3">
        <label>Foto Item</label>
        <input type="file" class="form-control" name="foto" accept="image/*">
        
        {{-- Tampilkan preview jika foto sudah ada (mode edit) --}}
        @if(isset($item->foto) && $item->foto)
            <div class="mt-2 p-2 border rounded bg-light d-inline-block">
                <p class="mb-1 text-muted"><small>Foto Saat Ini:</small></p>
                <img src="{{ asset('uploads/'.$item->foto) }}" alt="Foto Item" style="max-width: 150px; height: auto;">
            </div>
        @endif
    </div>

    <button class="btn btn-primary mt-3 w-100">Simpan Data</button>

</form>
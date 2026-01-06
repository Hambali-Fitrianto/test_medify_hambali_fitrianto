{{-- Pastikan enctype="multipart/form-data" ada, jika tidak upload foto akan gagal --}}
<form method="POST" enctype="multipart/form-data">
    @csrf
    
    @if($method == 'edit')
    <div class="form-group mb-3">
        <label>Kode Barang</label>
        <input type="text" class="form-control" name="kode_barang" required readonly value="{{$item->kode ?? ''}}">
    </div>
    @endif

    <div class="form-group mb-3">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required value="{{$item->nama ?? ''}}">
    </div>

    <div class="form-group mb-3">
        <label>Harga Beli</label>
        <input type="number" class="form-control" name="harga_beli" required value="{{$item->harga_beli ?? ''}}">
    </div>

    <div class="form-group mb-3">
        <label>Laba (dalam persen)</label>
        <input type="number" class="form-control" name="laba" required value="{{$item->laba ?? ''}}">
    </div>

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

    {{-- INPUT KATEGORI DENGAN SELECT2 --}}
    <div class="form-group mb-3">
        <label><strong>Kategori Items</strong> (Bisa pilih lebih dari satu)</label>
        
        {{-- Gunakan class 'select2-multiple' untuk dikenali Javascript --}}
        <select class="form-control select2-multiple" name="categories[]" multiple="multiple" style="width: 100%">
            @foreach($all_categories as $cat)
                <option value="{{ $cat->id }}" 
                    {{-- Logic Selected: Cek apakah ID ada di array selected --}}
                    @if(in_array($cat->id, $selected_categories ?? [])) selected @endif
                >
                    {{ $cat->nama }} ({{ $cat->kode }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3">
        <label>Foto Item</label>
        <input type="file" class="form-control" name="foto" accept="image/*">
        
        @if(isset($item->foto) && $item->foto)
            <div class="mt-2 p-2 border rounded bg-light d-inline-block">
                <p class="mb-1 text-muted"><small>Foto Saat Ini:</small></p>
                <img src="{{ asset('uploads/'.$item->foto) }}" alt="Foto Item" style="max-width: 150px; height: auto;">
            </div>
        @endif
    </div>

    <button class="btn btn-primary mt-3 w-100">Simpan Data</button>
</form>
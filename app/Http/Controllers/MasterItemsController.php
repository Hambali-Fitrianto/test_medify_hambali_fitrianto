<?php

namespace App\Http\Controllers;

use App\Models\MasterItem;
use App\Models\Category; // Pastikan Model Category di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;
        $hargamin = $request->hargamin;
        $hargamax = $request->hargamax;

        $data_search = MasterItem::query();

        // Filter Kode
        if (!empty($kode)) {
            $data_search = $data_search->where('kode', $kode);
        }

        // Filter Nama
        if (!empty($nama)) {
            $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');
        }

        // --- FIX BUG FILTER HARGA (Dipisah agar bisa range) ---
        // Filter Harga Min
        if (!empty($hargamin)) {
            $data_search = $data_search->where('harga_beli', '>=', $hargamin);
        }

        // Filter Harga Max
        if (!empty($hargamax)) {
            $data_search = $data_search->where('harga_beli', '<=', $hargamax);
        }
        // -----------------------------------------------------

        // Select kolom yang diperlukan (termasuk foto)
        // $data_search = $data_search->select('id', 'kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier', 'foto')
        //                            ->orderBy('id', 'desc')
        //                            ->get();
        $data_search = $data_search->with('categories') 
                                ->select('id', 'kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier', 'foto')
                                ->orderBy('id', 'desc')
                                ->get();

        return json_encode([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = [];
            $selected_categories = []; // Array kosong untuk item baru
        } else {
            $item = MasterItem::find($id);
            // Ambil ID kategori yang sudah terpilih untuk item ini (Relasi Many to Many)
            $selected_categories = $item->categories->pluck('id')->toArray();
        }

        $data['item'] = $item;
        $data['method'] = $method;
        
        // Kirim data semua kategori ke view untuk pilihan di Select2
        $data['all_categories'] = Category::all();
        // Kirim data kategori yang sudah dipilih (untuk mode edit)
        $data['selected_categories'] = $selected_categories;

        return view('master_items.form.index', $data);
    }

    public function singleView($kode)
    {
        // Load juga relasi categories agar bisa ditampilkan di view detail
        $data['data'] = MasterItem::with('categories')->where('kode', $kode)->first();
        return view('master_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $data_item = new MasterItem;
            $kode = MasterItem::count('id');
            $kode = $kode + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
        } else {
            $data_item = MasterItem::find($id);
            $kode = $data_item->kode;
        }

        $data_item->nama = $request->nama;
        $data_item->harga_beli = $request->harga_beli;
        $data_item->laba = $request->laba;
        $data_item->kode = $kode;
        $data_item->supplier = $request->supplier;
        $data_item->jenis = $request->jenis;

        // --- UPLOAD FOTO ---
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            // Generate nama file unik
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads');
            
            // Pindahkan file ke folder public/uploads
            $file->move($destinationPath, $filename);

            // Hapus foto lama jika ada (agar hemat storage)
            if ($method != 'new' && $data_item->foto) {
                $oldFile = public_path('uploads/' . $data_item->foto);
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }
            
            // Simpan nama file baru ke database
            $data_item->foto = $filename;
        }
        // -------------------

        $data_item->save(); // Save dulu agar object memiliki ID

        // --- SIMPAN RELASI KATEGORI (Many to Many) ---
        // $request->categories dikirim dari form sebagai array ID
        if($request->has('categories')){
            // Sync akan menghapus relasi lama yang tidak dipilih dan menambahkan yang baru
            $data_item->categories()->sync($request->categories);
        } else {
            // Jika tidak ada yang dipilih, hapus semua relasi item ini
            $data_item->categories()->detach();
        }
        // ---------------------------------------------

        return redirect('master-items');
    }

    public function delete($id)
    {
        $item = MasterItem::find($id);
        
        // 1. Hapus Foto Fisik jika ada
        if ($item->foto) {
            $path = public_path('uploads/' . $item->foto);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        // 2. Hapus relasi kategori di tabel pivot
        $item->categories()->detach();

        // 3. Hapus data item
        $item->delete();
        
        return redirect('master-items');
    }

    // --- FUNGSI HELPER UNTUK RANDOM DATA (Optional) ---
    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach($data as $item)
        {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100,1000000);
            $item->laba = rand(10,99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi','Bukulapuk','TokoBagas','E Commurz','Blublu'];
        $random = rand(0,4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat','Alkes','Matkes','Umum','ATK'];
        $random = rand(0,4);
        return $array[$random];
    }
}
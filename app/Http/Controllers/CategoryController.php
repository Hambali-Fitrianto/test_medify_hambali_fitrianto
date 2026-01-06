<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index');
    }

    // API untuk Filter/Search di Index (AJAX)
    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;

        $query = Category::query();

        if (!empty($kode)) $query->where('kode', $kode);
        if (!empty($nama)) $query->where('nama', 'LIKE', '%' . $nama . '%');

        $data = $query->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    // Form View (New/Edit)
    public function formView($method, $id = 0)
    {
        $data['method'] = $method;
        $data['category'] = ($method == 'edit') ? Category::find($id) : null;
        return view('categories.form', $data);
    }

    // Submit Form (Save/Update)
    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $category = new Category();
        } else {
            $category = Category::find($id);
        }

        $category->kode = $request->kode;
        $category->nama = $request->nama;
        $category->save();

        return redirect('categories');
    }

    // Single View (Detail + List Items)
    public function singleView($id)
    {
        // Ambil kategori beserta items-nya
        $category = Category::with('items')->find($id);
        
        return view('categories.single', compact('category'));
    }
    
    public function delete($id)
    {
        $cat = Category::find($id);
        // Hapus relasi di pivot table dulu agar bersih (opsional tapi disarankan)
        $cat->items()->detach(); 
        $cat->delete();
        
        return redirect('categories');
    }

    public function generatePdf($id)
    {
        // 1. Ambil data kategori beserta item-nya
        $category = Category::with('items')->find($id);

        if (!$category) {
            return redirect('categories')->with('error', 'Data tidak ditemukan');
        }

        // 2. Siapkan data tanggal cetak
        $tanggal_cetak = date('d F Y, H:i:s');

        // 3. Load View PDF (Kita akan buat file ini di langkah selanjutnya)
        $pdf = Pdf::loadView('categories.pdf', compact('category', 'tanggal_cetak'));

        // 4. Download file PDF dengan nama unik
        return $pdf->download('Laporan_Kategori_' . $category->kode . '.pdf');
    }
}
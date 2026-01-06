<?php

namespace App\Exports;

use App\Models\MasterItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // Agar lebar kolom otomatis
use Maatwebsite\Excel\Concerns\WithStyles;     // Untuk styling (Bold header)
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MasterItemExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    private $rowNumber = 0;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Ambil data MasterItem beserta relasi categories
        return MasterItem::with('categories')->get();
    }

    /**
     * Judul Kolom (Header)
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Kategori',
            'Nama Items',
            'Nama Supplier',
            'Harga',
            'Laba (%)',
            'Harga Jual',
        ];
    }

    /**
     * Mapping Data per Baris
     */
    public function map($item): array
    {
        $this->rowNumber++;

        // 1. Ambil Nama Kategori dan gabungkan dengan koma
        // Contoh: "Obat, Umum"
        $kategori_list = $item->categories->pluck('nama')->implode(', ');

        // 2. Hitung Harga Jual
        // Rumus: Harga Beli + (Harga Beli * Laba / 100)
        $harga_jual = $item->harga_beli + ($item->harga_beli * $item->laba / 100);

        return [
            $this->rowNumber,               // 1. No
            $kategori_list,                 // 2. Nama Kategori (terpisah koma)
            $item->nama,                    // 3. Nama Items
            $item->supplier,                // 4. Nama Supplier
            $item->harga_beli,              // 5. Harga
            $item->laba,                    // 6. Laba
            $harga_jual,                    // 7. Harga Jual
        ];
    }

    /**
     * Styling Header (Bold)
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Baris 1 (Header) di-bold
            1 => ['font' => ['bold' => true]],
        ];
    }
}
<?php

namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssetExport implements FromCollection, WithHeadings
{
    /**
    * Mengambil data dari database
    */
    public function collection()
    {
        // Kode Aset tidak di-export lagi ke dalam template
        return Asset::select('asset_name', 'category_id', 'serial_number', 'location', 'item_status', 'status', 'purchase_date', 'purchase_price')->get();
    }

    /**
     * Membuat Baris Pertama (Header) di Excel
     */
    public function headings(): array
    {
        return [
            'Nama Aset',
            'ID Kategori',
            'Serial Number',
            'Lokasi',
            'Kepemilikan',
            'Kondisi',
            'Tanggal Beli',
            'Harga Beli'
        ];
    }
}
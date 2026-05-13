<?php

namespace App\Imports;

use App\Models\Asset;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AssetImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // 1. Generate Kode Aset Otomatis (Format: IT-HurufAcak)
        $generateKode = 'IT-' . strtoupper(Str::random(6));
        
        // 2. Pastikan kodenya benar-benar unik (belum ada di database)
        while (Asset::where('asset_code', $generateKode)->exists()) {
            $generateKode = 'IT-' . strtoupper(Str::random(6));
        }

        // 3. Simpan ke database
        return new Asset([
            'uuid'           => Str::uuid(),
            'asset_code'     => $generateKode, // Pakai kode yang barusan dibuat otomatis
            'asset_name'     => $row['nama_aset'],
            'category_id'    => $row['id_kategori'],
            'serial_number'  => $row['serial_number'] ?? null,
            'location'       => $row['lokasi'],
            'item_status'    => $row['kepemilikan'] ?? 'BMN',
            'status'         => $row['kondisi'] ?? 'active',
            'purchase_date'  => $row['tanggal_beli'] ?? null,
            'purchase_price' => $row['harga_beli'] ?? null,
        ]);
    }

    /**
     * Aturan Validasi (Kode Aset sudah kita hapus dari sini karena dibuat otomatis)
     */
    public function rules(): array
    {
        return [
            'nama_aset'      => 'required|string|max:255',
            'id_kategori'    => 'required|exists:categories,id',
            'lokasi'         => 'required|string',
            'kepemilikan'    => 'nullable|in:BMN,Pihak Ketiga,Barang Lainnya',
            'kondisi'        => 'nullable|in:active,broken,maintenance',
            'tanggal_beli'   => 'nullable|date_format:Y-m-d',
            'harga_beli'     => 'nullable|numeric',
        ];
    }

    /**
     * Pesan Error
     */
    public function customValidationMessages()
    {
        return [
            'nama_aset.required' => 'Kolom "Nama Aset" wajib diisi.',
            'id_kategori.required' => 'Kolom "ID Kategori" wajib diisi.',
            'id_kategori.exists' => 'ID Kategori ":input" tidak ditemukan di sistem.',
            'lokasi.required'    => 'Kolom "Lokasi" wajib diisi.',
            'kepemilikan.in'     => 'Isian "Kepemilikan" harus salah satu dari: BMN, Pihak Ketiga, Barang Lainnya.',
            'kondisi.in'         => 'Isian "Kondisi" harus salah satu dari: active, broken, maintenance.',
            'tanggal_beli.date_format' => 'Format "Tanggal Beli" harus YYYY-MM-DD (Contoh: 2024-05-13).',
            'harga_beli.numeric' => 'Kolom "Harga Beli" harus berisi angka saja tanpa titik/koma.',
        ];
    }
}
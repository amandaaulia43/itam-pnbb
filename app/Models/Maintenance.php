<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    // Izinkan kolom-kolom ini untuk diisi
    protected $fillable = [
        'asset_id', 
        'maintenance_date', 
        'description', 
        'action_taken', 
        'technician_name', 
        'repair_cost'
    ];

    // Relasi ke tabel Asset
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    // Tentukan kolom apa saja yang boleh diisi
    protected $fillable = [
        'asset_id',
        'c1',
        'c2',
        'c3',
        'c4',
        'c5',
    ];

    // Relasi balik ke Asset
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
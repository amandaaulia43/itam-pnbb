<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    // Mengizinkan kolom name untuk diisi lewat form
    protected $fillable = ['name'];
}
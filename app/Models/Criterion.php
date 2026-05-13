<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criterion extends Model
{
    // Paksa model ini menggunakan tabel 'criteria' (sesuai screenshot kamu)
    protected $table = 'criteria';
    
    protected $fillable = ['code', 'name', 'type', 'weight'];
}
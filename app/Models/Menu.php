<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Menu extends Model
{
    use HasFactory;

    // Primary key
    protected $primaryKey = 'id_menu';

    // Non aktifkan auto increment
    public $incrementing = false;
    protected $keyType = 'string';
    
    // Nama tabel
    protected $table = 'menu';

    // Kolom yang boleh diisi (fillable)
    protected $fillable = ['id_menu', 'nama_menu', 'harga_menu', 'gambar_menu'];
}

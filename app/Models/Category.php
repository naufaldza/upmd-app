<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Field yang boleh diisi manual
    protected $fillable = ['name', 'description'];

    // Relasi: Satu Kategori punya banyak Alat
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
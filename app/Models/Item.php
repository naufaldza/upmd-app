<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'category_id', 'inventory_code', 'name', 'brand', 
        'status', 'condition_status', 'description', 'image_url'
    ];

    // Relasi: Alat milik satu Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: Alat punya banyak riwayat peminjaman
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
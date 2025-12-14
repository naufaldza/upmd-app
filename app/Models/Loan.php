<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'user_id', 'item_id', 'purpose', 'loan_date', 
        'expected_return_date', 'actual_return_date', 
        'status', 'admin_note', 'return_condition'
    ];

    // Relasi: Peminjaman dilakukan oleh satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Peminjaman meminjam satu Alat
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
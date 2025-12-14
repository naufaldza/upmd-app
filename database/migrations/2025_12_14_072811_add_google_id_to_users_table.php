<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        // Menambahkan kolom google_id
        $table->string('google_id')->nullable()->after('email');
        
        // Sekalian kita tambahkan kolom role (untuk Admin/Mahasiswa)
        $table->string('role')->default('student')->after('google_id');
        
        // Kolom untuk NIM/NIP (opsional, persiapan masa depan)
        $table->string('nim_nip')->nullable()->after('name');
    });
}

    public function down(): void
    {
     Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['google_id', 'role', 'nim_nip']);
        });
    }
};

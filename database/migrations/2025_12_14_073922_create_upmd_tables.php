<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Kategori
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 2. Tabel Alat (Items) - INI YANG TADI HILANG
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('inventory_code')->unique();
            $table->string('name');
            $table->string('brand')->nullable();
            $table->enum('status', ['ready', 'borrowed', 'maintenance', 'lost'])->default('ready');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        // 3. Tabel Peminjaman (Loans)
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->text('purpose');
            $table->date('loan_date');
            $table->date('expected_return_date');
            $table->dateTime('actual_return_date')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'active', 'returned', 'overdue'])->default('pending');
            $table->text('admin_note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
        Schema::dropIfExists('items');
        Schema::dropIfExists('categories');
    }
};
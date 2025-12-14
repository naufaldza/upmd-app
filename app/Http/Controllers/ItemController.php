<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    // 1. Tampilkan Daftar Alat
    public function index()
    {
        $items = Item::with('category')->latest()->get();
        return view('items.index', compact('items'));
    }

    // 2. Form Tambah Alat
    public function create()
    {
        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    // 3. Simpan Alat Baru (Support Gambar)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'inventory_code' => 'required|unique:items',
            'category_id' => 'required',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // Upload Gambar jika ada
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $data['image_url'] = $path;
        }

        Item::create($data);

        return redirect()->route('items.index')->with('success', 'Alat berhasil ditambahkan!');
    }

    // 4. Form Edit Alat
    public function edit(Item $item)
    {
        $categories = Category::all();
        return view('items.edit', compact('item', 'categories'));
    }

    // 5. Update Alat (Support Ganti Gambar)
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required',
            'inventory_code' => 'required|unique:items,inventory_code,' . $item->id,
            'category_id' => 'required',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($item->image_url && Storage::disk('public')->exists($item->image_url)) {
                Storage::disk('public')->delete($item->image_url);
            }
            // Simpan gambar baru
            $path = $request->file('image')->store('items', 'public');
            $data['image_url'] = $path;
        }

        $item->update($data);

        return redirect()->route('items.index')->with('success', 'Data alat berhasil diperbarui!');
    }

    // 6. Hapus Alat
    public function destroy(Item $item)
    {
        if ($item->image_url) {
            Storage::disk('public')->delete($item->image_url);
        }
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Alat berhasil dihapus.');
    }
}
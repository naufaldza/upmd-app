<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    // 1. Halaman Katalog (Mahasiswa memilih alat)
    public function index(Request $request)
    {
        // Ambil data kategori untuk dropdown filter
        $categories = \App\Models\Category::all();

        // Query Alat dengan Filter
        $items = Item::where('status', 'ready')
            ->when($request->search, function ($query) use ($request) {
                // Filter berdasarkan Nama Alat ATAU Kode Inventaris
                $query->where(function($q) use ($request) {
                    $q->where('name', 'like', '%'.$request->search.'%')
                      ->orWhere('inventory_code', 'like', '%'.$request->search.'%');
                });
            })
            ->when($request->category_id, function ($query) use ($request) {
                // Filter berdasarkan Kategori
                $query->where('category_id', $request->category_id);
            })
            ->latest()
            ->get();

        return view('loans.catalog', compact('items', 'categories'));
    }

    // 2. Form Pengajuan Pinjam
    public function create(Item $item)
    {
        return view('loans.create', compact('item'));
    }

    // 3. Proses Simpan Peminjaman
    public function store(Request $request, Item $item)
    {
        $request->validate([
            'loan_date' => 'required|date|after_or_equal:today',
            'duration' => 'required|numeric|min:1|max:7',
            'purpose' => 'required|string|min:10',
        ]);

        // Hitung tanggal kembali otomatis
        $loanDate = \Carbon\Carbon::parse($request->loan_date);
        
        // PERBAIKAN DISINI: Tambahkan (int) agar dibaca sebagai angka
        $returnDate = $loanDate->copy()->addDays((int) $request->duration);

        // Simpan ke database
        Loan::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
            'loan_date' => $loanDate,
            'expected_return_date' => $returnDate,
            'purpose' => $request->purpose,
            'status' => 'pending', 
        ]);

        return redirect()->route('dashboard')->with('success', 'Pengajuan peminjaman berhasil dikirim! Menunggu konfirmasi Admin.');
    }

    // --- FITUR MAHASISWA (RIWAYAT) ---

    public function history()
    {
        // Ambil peminjaman milik user yang sedang login saja
        $loans = Loan::with('item')
                     ->where('user_id', Auth::id())
                     ->latest()
                     ->get();

        return view('loans.history', compact('loans'));
    }

    // --- FITUR KHUSUS ADMIN ---

    // 4. Daftar Semua Peminjaman Masuk
    public function adminIndex()
    {
        // Ambil semua data, urutkan yang pending paling atas
        $loans = Loan::with(['user', 'item'])
                     ->orderByRaw("FIELD(status, 'pending', 'active', 'approved', 'returned', 'rejected', 'overdue')")
                     ->latest()
                     ->get();
                     
        return view('loans.admin', compact('loans'));
    }

    // 5. Setujui Peminjaman
    public function approve(Loan $loan)
    {
        // Cek apakah alat masih ready? (Takutnya sudah di-approve admin lain)
        if($loan->item->status !== 'ready') {
            return back()->with('error', 'Gagal! Alat ini sedang dipinjam orang lain atau rusak.');
        }

        // Update status pinjaman
        $loan->update(['status' => 'approved']);

        // Update status alat jadi 'borrowed' (Supaya tidak muncul di katalog)
        $loan->item->update(['status' => 'borrowed']);

        return back()->with('success', 'Peminjaman disetujui! Alat sekarang statusnya "Dipinjam".');
    }

    // 6. Tolak Peminjaman
    public function reject(Loan $loan)
    {
        $loan->update(['status' => 'rejected']);
        
        // Alat tetap 'ready' karena ditolak
        return back()->with('success', 'Peminjaman ditolak.');
    }
    
    // 7. Selesaikan Peminjaman (Barang Kembali)
    public function complete(Loan $loan)
    {
        $loan->update([
            'status' => 'returned',
            'actual_return_date' => now(),
        ]);

        // Alat kembali 'ready'
        $loan->item->update(['status' => 'ready']);

        return back()->with('success', 'Alat sudah dikembalikan. Terima kasih!');
    }
}
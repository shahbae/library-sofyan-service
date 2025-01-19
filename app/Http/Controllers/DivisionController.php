<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter query untuk pagination dan pencarian
        $pageSize = $request->query('page_size', 10); // Jumlah data per halaman
        $page = $request->query('page', 1); // Halaman saat ini
        $searchQuery = $request->query('q', ''); // Kata kunci pencarian (default kosong)

        // Validasi input untuk parameter query
        $validated = $request->validate([
            'page_size' => 'integer|min:1|max:100', // page_size harus angka antara 1-100
            'page' => 'integer|min:1', // page harus angka >= 1
            'q' => 'nullable|string|max:255', // q (search) opsional dan maksimal 255 karakter
        ]);

        // Hitung offset untuk nomor urut asli
        $offset = ($page - 1) * $pageSize;

        // Query data dengan pencarian
        $division = Division::select(['id', 'name_divisi', 'name_pic']) // Pilih kolom yang diperlukan
            ->when($searchQuery, function ($query, $searchQuery) {
                $query->where('name_divisi', 'like', "%{$searchQuery}%")
                      ->orWhere('name_pic', 'like', "%{$searchQuery}%");
            })
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal terbaru
            ->paginate($pageSize, ['*'], 'page', $page);

        // Tambahkan nomor urut asli ke setiap item
        $dataWithIndex = $division->items();
        foreach ($dataWithIndex as $key => $item) {
            $item->nomor = $offset + $key + 1; // Hitung nomor urut asli
        }

        // Kembalikan respons JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Data divisi berhasil dimuat',
            'data' => $dataWithIndex, // Data pada halaman saat ini dengan nomor urut asli
            'total' => $division->total(), // Total data
            'current_page' => $division->currentPage(), // Halaman saat ini
            'last_page' => $division->lastPage(), // Halaman terakhir
        ], 200);
    }

    public function store(Request $request)
    {
        // Validasi input dari request
        $validated = $request->validate([
            'name_divisi' => 'required|string|max:255', // name_divisi wajib diisi, string, maksimal 255 karakter
            'name_pic' => 'required|string|max:255', // name_pic wajib diisi, string, maksimal 255 karakter
        ]);

        // Simpan data divisi baru
        $division = Division::create($validated);

        // Kembalikan respons JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Divisi berhasil ditambahkan',
            'data' => $division, // Data divisi yang baru ditambahkan
        ], 201);
    }

    public function show($id)
    {
        // Cari data divisi berdasarkan ID
        $division = Division::find($id);

        // Jika data tidak ditemukan, kirim respons error
        if (!$division) {
            return response()->json([
                'status' => 'error',
                'message' => 'Divisi tidak ditemukan',
            ], 404);
        }

        // Jika data ditemukan, kirim respons sukses beserta data divisi
        return response()->json([
            'status' => 'success',
            'message' => 'Data divisi berhasil dimuat',
            'data' => $division,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        // Cari data divisi berdasarkan ID
        $division = Division::find($id);

        // Jika data tidak ditemukan, kirim respons error
        if (!$division) {
            return response()->json([
                'status' => 'error',
                'message' => 'Divisi tidak ditemukan',
            ], 404);
        }

        // Validasi input dari request
        $validated = $request->validate([
            'name_divisi' => 'required|string|max:255', // name_divisi wajib diisi, string, maksimal 255 karakter
            'name_pic' => 'required|string|max:255', // name_pic wajib diisi, string, maksimal 255 karakter
        ]);

        // Update data divisi
        $division->update($validated);

        // Kembalikan respons JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Divisi berhasil diperbarui',
            'data' => $division, // Data divisi yang baru diperbarui
        ], 200);
    }

    public function destroy($id)
    {
        // Cari data divisi berdasarkan ID
        $division = Division::find($id);

        // Jika data tidak ditemukan, kirim respons error
        if (!$division) {
            return response()->json([
                'status' => 'error',
                'message' => 'Divisi tidak ditemukan',
            ], 404);
        }

        // Hapus data divisi
        $division->delete();

        // Kembalikan respons JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Divisi berhasil dihapus',
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnggotaRequest;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AnggotaController extends Controller
{
    /**
     * Display a listing of all anggota.
     */
    public function index()
    {
        $pageSize = request()->query('page_size', 10);
        $page = request()->query('page', 1);

        // Mengambil semua data anggota yang diurutkan berdasarkan yang terbaru
        $anggota = Anggota::select(['id', 'nama', 'email', 'no_hp', 'alamat', 'tanggal_daftar', 'status_anggota'])
        ->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal terbaru
        ->paginate($pageSize, ['*'], 'page', $page);


        // Mengembalikan data anggota dalam format JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Data anggota berhasil dimuat',
            'data' => $anggota->items(),
            'total' => $anggota->total(),
            'current_page' => $anggota->currentPage(),
            'last_page' => $anggota->lastPage(),
        ], 200);
    }

     /**
     * Store a newly created anggota in storage.
     */
    public function store(AnggotaRequest $request)
    {
        // Validasi data menggunakan Form Request
        $validated = $request->validated();

        // Simpan data anggota baru
        $anggota = Anggota::create(array_merge($validated, [
            'id' => Str::uuid(),
            'tanggal_daftar' => now(),
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'Anggota berhasil ditambahkan',
            'data' => $anggota,
        ], 201);
    }

    /**
     * Display the specified anggota.
     */
    public function show($id)
    {
        $anggota = Anggota::find($id);

        if (!$anggota) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anggota tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data anggota berhasil dimuat',
            'data' => $anggota,
        ], 200);
    }

    /**
     * Update the specified anggota in storage.
     */
    public function update(AnggotaRequest $request, $id)
    {
        // Validasi UUID menggunakan validator Laravel
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|uuid|exists:anggota,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'ID tidak valid atau tidak ditemukan.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Jika validasi gagal, Laravel akan otomatis mengembalikan respons error
        $validated = $request->validated();
        
        // Temukan anggota berdasarkan UUID
        $anggota = Anggota::find($id);
    
        // Jika anggota tidak ditemukan
        if (!$anggota) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anggota tidak ditemukan',
            ], 404);
        }
    
        // Lakukan pembaruan anggota
        $anggota->update($validated);
    
        return response()->json([
            'status' => 'success',
            'data' => $anggota,
        ], 200);
    }

    /**
     * Remove the specified anggota from storage.
     */
    public function destroy($id)
    {
        $anggota = Anggota::find($id);

        if (!$anggota) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anggota tidak ditemukan',
            ], 404);
        }

        $anggota->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Anggota berhasil dihapus',
        ], 200);
    }

    public function dashboard()
    {
        $totalAnggota = Anggota::count();
        $totalAnggotaAktif = Anggota::where('status_anggota', 'active')->count();

        return response()->json([
            'status' => 'success',
            'message' => 'Data dashboard berhasil dimuat',
            'data' => [
                'total_anggota' => $totalAnggota,
                'total_anggota_aktif' => $totalAnggotaAktif,
            ],
        ]);
    }
}

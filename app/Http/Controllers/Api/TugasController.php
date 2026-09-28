<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $tugas = Tugas::orderBy('id', 'desc')->get();
        return response()->json($tugas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'nullable|string|in:pending,in_progress,selesai',
            'prioritas' => 'nullable|string|in:rendah,sedang,tinggi',
            'deadline' => 'nullable|date',
        ]);

        $tugas = Tugas::create($validated);

        return response()->json([
            'message' => 'Tugas berhasil dibuat',
            'data' => $tugas
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $tugas = Tugas::findOrFail($id);
        return response()->json($tugas);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $tugas = Tugas::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'sometimes|required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'nullable|string|in:pending,in_progress,selesai',
            'prioritas' => 'nullable|string|in:rendah,sedang,tinggi',
            'deadline' => 'nullable|date',
        ]);

        $tugas->update($validated);

        return response()->json([
            'message' => 'Tugas berhasil diperbarui',
            'data' => $tugas
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $tugas = Tugas::findOrFail($id);
        $tugas->delete();

        return response()->json([
            'message' => 'Tugas berhasil dihapus'
        ]);
    }
}

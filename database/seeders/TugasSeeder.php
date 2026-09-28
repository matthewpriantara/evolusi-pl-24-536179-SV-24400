<?php

namespace Database\Seeders;

use App\Models\Tugas;
use Illuminate\Database\Seeder;

class TugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'judul' => 'Implementasi API Endpoint Tugas di Laravel',
                'deskripsi' => 'Membuat endpoint RESTful JSON GET /api/tugas serta konfigurasi CORS untuk integrasi frontend.',
                'status' => 'selesai',
                'prioritas' => 'tinggi',
                'deadline' => '2026-09-28',
            ],
            [
                'judul' => 'Membangun Frontend Vue 3 dengan Vite & Vue Router',
                'deskripsi' => 'Menyusun halaman ber-router dengan konsumsi API menggunakan konfigurasi VITE_API_URL.',
                'status' => 'in_progress',
                'prioritas' => 'tinggi',
                'deadline' => '2026-09-29',
            ],
            [
                'judul' => 'Rancang Pipeline GitHub Actions 4 Job',
                'deskripsi' => 'Membangun alur lint -> test -> build -> deploy dengan passing dist/ artifact dan rule branch main.',
                'status' => 'pending',
                'prioritas' => 'tinggi',
                'deadline' => '2026-09-30',
            ],
            [
                'judul' => 'Penyusunan Unit Test Vitest & Laporan Praktikum',
                'deskripsi' => 'Menulis unit test independen tanpa dependensi Laravel dan menyusun laporan PDF P4_NIM_Nama.',
                'status' => 'pending',
                'prioritas' => 'sedang',
                'deadline' => '2026-10-01',
            ],
        ];

        foreach ($data as $item) {
            Tugas::updateOrCreate(
                ['judul' => $item['judul']],
                $item
            );
        }
    }
}

<?php

namespace Tests\Feature;

use App\Models\Tugas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TugasApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_all_tugas_as_json(): void
    {
        Tugas::create([
            'judul' => 'Tugas Pengujian Unit',
            'deskripsi' => 'Deskripsi pengujian endpoint JSON',
            'status' => 'pending',
            'prioritas' => 'tinggi',
            'deadline' => '2026-09-30',
        ]);

        $response = $this->getJson('/api/tugas');

        $response->assertStatus(200)
                 ->assertJsonCount(1)
                 ->assertJsonFragment([
                     'judul' => 'Tugas Pengujian Unit',
                     'status' => 'pending',
                 ]);
    }

    public function test_can_create_new_tugas_via_api(): void
    {
        $payload = [
            'judul' => 'Tugas Baru dari API',
            'deskripsi' => 'Testing pembuatan tugas baru',
            'status' => 'in_progress',
            'prioritas' => 'sedang',
            'deadline' => '2026-10-05',
        ];

        $response = $this->postJson('/api/tugas', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'message' => 'Tugas berhasil dibuat',
                     'judul' => 'Tugas Baru dari API',
                 ]);

        $this->assertDatabaseHas('tugas', [
            'judul' => 'Tugas Baru dari API',
        ]);
    }
}

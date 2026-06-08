<?php

use App\Models\AppUser;
use App\Models\Ruangan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

// Helper untuk buat user login
function createAndLoginUser(): AppUser
{
    $user = AppUser::create([
        'nama'          => 'Test User',
        'email_its'     => 'test@student.its.ac.id',
        'password_hash' => Hash::make('password123'),
        'is_admin'      => false,
    ]);

    test()->actingAs($user);
    return $user;
}

// Helper untuk buat ruangan
function createRuangan(): Ruangan
{
    return Ruangan::create([
        'nama_ruangan'   => 'Ruang A101',
        'lokasi_ruangan' => 'Gedung A Lantai 1',
        'deskripsi'      => 'Ruang kuliah standar',
        'kapasitas'      => 40,
        'foto'           => null,
        'fasilitas'      => 'AC,Proyektor',
    ]);
}

test('peminjaman gagal jika user belum login', function () {
    $response = $this->postJson('/peminjaman', [
        'ruangan_id' => 1,
        'tanggal'    => now()->addDays(2)->format('Y-m-d'),
        'waktu'      => 'sesi1',
        'keterangan' => 'Keperluan kuliah',
    ]);

    $response->assertStatus(401);
});

test('peminjaman gagal jika ruangan tidak ada', function () {
    createAndLoginUser();

    $response = $this->postJson('/peminjaman', [
        'ruangan_id' => 9999,
        'tanggal'    => now()->addDays(2)->format('Y-m-d'),
        'waktu'      => 'sesi1',
        'keterangan' => 'Keperluan kuliah',
    ]);

    $response->assertStatus(422)
        ->assertJsonFragment(['success' => false]);
});

test('peminjaman gagal jika tanggal adalah hari ini atau sebelumnya', function () {
    createAndLoginUser();
    $ruangan = createRuangan();

    $response = $this->postJson('/peminjaman', [
        'ruangan_id' => $ruangan->ruanganid,
        'tanggal'    => now()->format('Y-m-d'),
        'waktu'      => 'sesi1',
        'keterangan' => 'Keperluan kuliah',
    ]);

    $response->assertStatus(422)
        ->assertJsonFragment(['success' => false]);
});

test('peminjaman gagal jika waktu tidak valid', function () {
    createAndLoginUser();
    $ruangan = createRuangan();

    $response = $this->postJson('/peminjaman', [
        'ruangan_id' => $ruangan->ruanganid,
        'tanggal'    => now()->addDays(2)->format('Y-m-d'),
        'waktu'      => 'sesi99',
        'keterangan' => 'Keperluan kuliah',
    ]);

    $response->assertStatus(422)
        ->assertJsonFragment(['success' => false]);
});

test('cek ketersediaan ruangan berhasil', function () {
    $user = createAndLoginUser(); //
    $ruangan = createRuangan();

    // 1. Kirim menggunakan postJson (sesuai dengan route:list aplikasi)
    $response = $this->withoutMiddleware()
        ->actingAs($user)
        ->postJson('/peminjaman/check-availability', [
            'ruangan_id' => $ruangan->ruanganid, // Sesuaikan kembali ke ruangan_id sesuai route name controller kalian
            'tanggal'    => now()->addDays(2)->format('Y-m-d'), //
            'waktu'      => 'sesi1', //
        ]);

    // 2. Verifikasi respon backend mengembalikan status 200 OK dan flag sukses
    $response->assertStatus(200) //
        ->assertJsonFragment([ //
            'success'   => true, //
            'available' => true, //
        ]);
});

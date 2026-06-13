<?php

use App\Models\AppUser;
use App\Models\Ruangan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

function createAdminRuanganUser(array $overrides = []): AppUser
{
    return AppUser::create(array_merge([
        'nama' => 'Admin Ruangan Test',
        'email_its' => 'adminruangan@test.its.ac.id',
        'password_hash' => Hash::make('password123'),
        'no_telepon' => '08123456789',
        'is_admin' => true,
    ], $overrides));
}

function createAdminRuanganData(array $overrides = []): Ruangan
{
    return Ruangan::create(array_merge([
        'nama_ruangan' => 'Ruang Admin Test',
        'lokasi_ruangan' => 'Gedung Admin Lantai 1',
        'deskripsi' => 'Ruangan untuk testing admin',
        'kapasitas' => 50,
        'foto' => null,
        'fasilitas' => 'AC,Proyektor',
    ], $overrides));
}

test('admin dapat melihat halaman index ruangan', function () {
    $admin = createAdminRuanganUser();
    createAdminRuanganData();

    $response = $this->actingAs($admin)
        ->get(route('admin.ruangan.index'));

    $response->assertStatus(200);
    $response->assertViewIs('admin.ruangan.index');
    $response->assertViewHas('ruangan');
});

test('admin dapat melihat halaman tambah ruangan', function () {
    $admin = createAdminRuanganUser();

    $response = $this->actingAs($admin)
        ->get(route('admin.ruangan.create'));

    $response->assertStatus(200);
    $response->assertViewIs('admin.ruangan.create');
});

test('admin dapat menyimpan ruangan baru tanpa foto', function () {
    $admin = createAdminRuanganUser();

    $response = $this->actingAs($admin)
        ->post(route('admin.ruangan.store'), [
            'nama_ruangan' => 'Ruang Baru Testing',
            'lokasi_ruangan' => 'Gedung Baru Lantai 2',
            'deskripsi' => 'Deskripsi ruangan baru',
            'kapasitas' => 75,
            'fasilitas' => 'AC,WiFi',
        ]);

    $response->assertRedirect(route('admin.ruangan.index'));
    $response->assertSessionHas('success', 'Ruangan berhasil ditambahkan!');

    $this->assertDatabaseHas('ruangan', [
        'nama_ruangan' => 'Ruang Baru Testing',
        'lokasi_ruangan' => 'Gedung Baru Lantai 2',
        'kapasitas' => 75,
        'fasilitas' => 'AC,WiFi',
    ]);
});

test('admin gagal menyimpan ruangan jika data wajib kosong', function () {
    $admin = createAdminRuanganUser();

    $response = $this->actingAs($admin)
        ->from(route('admin.ruangan.create'))
        ->post(route('admin.ruangan.store'), [
            'nama_ruangan' => '',
            'lokasi_ruangan' => '',
            'kapasitas' => '',
        ]);

    $response->assertRedirect(route('admin.ruangan.create'));
    $response->assertSessionHasErrors([
        'nama_ruangan',
        'lokasi_ruangan',
        'kapasitas',
    ]);
});

test('admin dapat melihat halaman edit ruangan', function () {
    $admin = createAdminRuanganUser();
    $ruangan = createAdminRuanganData();

    $response = $this->actingAs($admin)
        ->get(route('admin.ruangan.edit', $ruangan->ruanganid));

    $response->assertStatus(200);
    $response->assertViewIs('admin.ruangan.edit');
    $response->assertViewHas('ruangan');
});

test('admin diarahkan kembali jika edit ruangan tidak ditemukan', function () {
    $admin = createAdminRuanganUser();

    $response = $this->actingAs($admin)
        ->get(route('admin.ruangan.edit', 9999));

    $response->assertRedirect(route('admin.ruangan.index'));
    $response->assertSessionHas('error', 'Ruangan tidak ditemukan.');
});

test('admin dapat memperbarui ruangan tanpa mengganti foto', function () {
    $admin = createAdminRuanganUser();

    $ruangan = createAdminRuanganData([
        'foto' => null,
    ]);

    $response = $this->actingAs($admin)
        ->post(route('admin.ruangan.update', $ruangan->ruanganid), [
            'nama_ruangan' => 'Ruang Admin Updated',
            'lokasi_ruangan' => 'Gedung Updated',
            'deskripsi' => 'Deskripsi updated',
            'kapasitas' => 120,
            'fasilitas' => 'AC,WiFi,Proyektor',
        ]);

    $response->assertRedirect(route('admin.ruangan.index'));
    $response->assertSessionHas('success', 'Ruangan berhasil diperbarui!');

    $this->assertDatabaseHas('ruangan', [
        'ruanganid' => $ruangan->ruanganid,
        'nama_ruangan' => 'Ruang Admin Updated',
        'lokasi_ruangan' => 'Gedung Updated',
        'kapasitas' => 120,
        'fasilitas' => 'AC,WiFi,Proyektor',
    ]);
});

test('admin diarahkan kembali jika update ruangan tidak ditemukan', function () {
    $admin = createAdminRuanganUser();

    $response = $this->actingAs($admin)
        ->post(route('admin.ruangan.update', 9999), [
            'nama_ruangan' => 'Ruang Tidak Ada',
            'lokasi_ruangan' => 'Lokasi Tidak Ada',
            'deskripsi' => 'Data tidak ada',
            'kapasitas' => 10,
            'fasilitas' => 'AC',
        ]);

    $response->assertRedirect(route('admin.ruangan.index'));
    $response->assertSessionHas('error', 'Ruangan tidak ditemukan.');
});

test('admin dapat menghapus ruangan', function () {
    $admin = createAdminRuanganUser();
    $ruangan = createAdminRuanganData();

    $response = $this->actingAs($admin)
        ->delete(route('admin.ruangan.destroy', $ruangan->ruanganid));

    $response->assertRedirect(route('admin.ruangan.index'));
    $response->assertSessionHas('success', 'Ruangan berhasil dihapus!');

    $this->assertDatabaseMissing('ruangan', [
        'ruanganid' => $ruangan->ruanganid,
    ]);
});

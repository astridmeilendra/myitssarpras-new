<?php

use App\Models\AppUser;
use App\Models\Ruangan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

uses(RefreshDatabase::class);

function createDetailUser(array $overrides = []): AppUser
{
    return AppUser::create(array_merge([
        'nama' => 'User Detail Test',
        'email_its' => 'detail@test.its.ac.id',
        'password_hash' => Hash::make('password123'),
        'no_telepon' => '08123456789',
        'is_admin' => false,
    ], $overrides));
}

function createDetailRuangan(array $overrides = []): Ruangan
{
    return Ruangan::create(array_merge([
        'nama_ruangan' => 'Ruang Detail Test',
        'lokasi_ruangan' => 'Gedung Test Lantai 1',
        'deskripsi' => 'Ruangan untuk testing detail peminjaman',
        'kapasitas' => 40,
        'foto' => null,
        'fasilitas' => 'AC,Proyektor',
    ], $overrides));
}

function createDetailPeminjaman(AppUser $user, Ruangan $ruangan, array $overrides = []): int
{
    return DB::table('peminjaman')->insertGetId(array_merge([
        'userid' => $user->userid,
        'ruanganid' => $ruangan->ruanganid,
        'tanggal' => now()->addDays(2)->format('Y-m-d'),
        'nama_shift' => 'sesi1',
        'keterangan' => 'Keperluan testing detail peminjaman',
        'dokumen' => null,
    ], $overrides), 'peminjamanid');
}

function createDetailStatus(int $peminjamanId, string $status = 'Menunggu'): void
{
    DB::table('riwayat_status')->insert([
        'peminjamanid' => $peminjamanId,
        'nama_status' => $status,
        'waktu_update' => now(),
        'keterangan' => 'Status untuk testing',
    ]);
}

test('user bisa melihat detail peminjaman miliknya', function () {
    $user = createDetailUser();
    $ruangan = createDetailRuangan();

    $peminjamanId = createDetailPeminjaman($user, $ruangan);
    createDetailStatus($peminjamanId, 'Menunggu');

    $response = $this->actingAs($user)
        ->get(route('peminjaman.detail', $peminjamanId));

    $response->assertStatus(200);
    $response->assertViewIs('page.peminjaman.detail-peminjaman');
    $response->assertViewHas('peminjaman');
    $response->assertViewHas('riwayatStatus');
    $response->assertViewHas('statusTerakhir', 'Menunggu');
});

test('user tidak bisa melihat detail peminjaman milik user lain', function () {
    $pemilik = createDetailUser([
        'email_its' => 'pemilik@test.its.ac.id',
    ]);

    $userLain = createDetailUser([
        'nama' => 'User Lain',
        'email_its' => 'userlain@test.its.ac.id',
    ]);

    $ruangan = createDetailRuangan();
    $peminjamanId = createDetailPeminjaman($pemilik, $ruangan);
    createDetailStatus($peminjamanId, 'Menunggu');

    $response = $this->actingAs($userLain)
        ->get(route('peminjaman.detail', $peminjamanId));

    $response->assertRedirect(route('home'));
    $response->assertSessionHas('error', 'Peminjaman tidak ditemukan');
});

test('user bisa membatalkan peminjaman dengan status menunggu', function () {
    $user = createDetailUser();
    $ruangan = createDetailRuangan();

    $peminjamanId = createDetailPeminjaman($user, $ruangan);
    createDetailStatus($peminjamanId, 'Menunggu');

    $response = $this->actingAs($user)
        ->post(route('peminjaman.cancel', $peminjamanId));

    $response->assertRedirect(route('peminjaman.detail', $peminjamanId));
    $response->assertSessionHas('success', 'Peminjaman berhasil dibatalkan');

    $this->assertDatabaseHas('riwayat_status', [
        'peminjamanid' => $peminjamanId,
        'nama_status' => 'Dibatalkan',
        'keterangan' => 'Peminjaman dibatalkan oleh peminjam',
    ]);
});

test('user tidak bisa membatalkan peminjaman milik user lain', function () {
    $pemilik = createDetailUser([
        'email_its' => 'pemilikcancel@test.its.ac.id',
    ]);

    $userLain = createDetailUser([
        'nama' => 'User Lain Cancel',
        'email_its' => 'userlaincancel@test.its.ac.id',
    ]);

    $ruangan = createDetailRuangan();
    $peminjamanId = createDetailPeminjaman($pemilik, $ruangan);
    createDetailStatus($peminjamanId, 'Menunggu');

    $response = $this->actingAs($userLain)
        ->post(route('peminjaman.cancel', $peminjamanId));

    $response->assertRedirect(route('riwayat'));
    $response->assertSessionHas('error', 'Peminjaman tidak ditemukan');
});

test('upload surat gagal jika file tidak dikirim', function () {
    $user = createDetailUser();
    $ruangan = createDetailRuangan();

    $peminjamanId = createDetailPeminjaman($user, $ruangan);
    createDetailStatus($peminjamanId, 'Verifikasi Data');

    $response = $this->actingAs($user)
        ->postJson(route('peminjaman.upload-surat', $peminjamanId), []);

    $response->assertStatus(422)
        ->assertJson([
            'success' => false,
            'message' => 'File surat tidak ditemukan',
        ]);
});

test('upload surat gagal jika status bukan verifikasi data', function () {
    $user = createDetailUser();
    $ruangan = createDetailRuangan();

    $peminjamanId = createDetailPeminjaman($user, $ruangan);
    createDetailStatus($peminjamanId, 'Menunggu');

    $file = UploadedFile::fake()->create('surat.pdf', 100, 'application/pdf');

    $response = $this->actingAs($user)
        ->postJson(route('peminjaman.upload-surat', $peminjamanId), [
            'surat' => $file,
        ]);

    $response->assertStatus(422)
        ->assertJson([
            'success' => false,
            'message' => 'Status peminjaman tidak valid untuk upload surat',
        ]);
});

test('upload surat gagal jika format file tidak valid', function () {
    $user = createDetailUser();
    $ruangan = createDetailRuangan();

    $peminjamanId = createDetailPeminjaman($user, $ruangan);
    createDetailStatus($peminjamanId, 'Verifikasi Data');

    $file = UploadedFile::fake()->create('virus.exe', 100, 'application/octet-stream');

    $response = $this->actingAs($user)
        ->postJson(route('peminjaman.upload-surat', $peminjamanId), [
            'surat' => $file,
        ]);

    $response->assertStatus(422)
        ->assertJson([
            'success' => false,
            'message' => 'Format file tidak valid. Gunakan PDF, DOC, DOCX, JPG, atau PNG',
        ]);
});

test('upload surat berhasil dan status berubah menjadi menunggu', function () {
    putenv('SUPABASE_URL=https://example.supabase.co');
    putenv('SUPABASE_SERVICE_ROLE=test-service-role-key');
    putenv('SUPABASE_BUCKET=dokumen-peminjaman');

    $_ENV['SUPABASE_URL'] = 'https://example.supabase.co';
    $_ENV['SUPABASE_SERVICE_ROLE'] = 'test-service-role-key';
    $_ENV['SUPABASE_BUCKET'] = 'dokumen-peminjaman';

    $_SERVER['SUPABASE_URL'] = 'https://example.supabase.co';
    $_SERVER['SUPABASE_SERVICE_ROLE'] = 'test-service-role-key';
    $_SERVER['SUPABASE_BUCKET'] = 'dokumen-peminjaman';

    Http::fake([
        'https://example.supabase.co/*' => Http::response([], 200),
    ]);

    $user = createDetailUser();
    $ruangan = createDetailRuangan();

    $peminjamanId = createDetailPeminjaman($user, $ruangan);
    createDetailStatus($peminjamanId, 'Verifikasi Data');

    $file = UploadedFile::fake()->create('surat.pdf', 100, 'application/pdf');

    $response = $this->actingAs($user)
        ->postJson(route('peminjaman.upload-surat', $peminjamanId), [
            'surat' => $file,
        ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Surat berhasil diupload. Status berubah menjadi Menunggu.',
        ]);

    $this->assertDatabaseHas('riwayat_status', [
        'peminjamanid' => $peminjamanId,
        'nama_status' => 'Menunggu',
        'keterangan' => 'Surat permohonan telah diupload. Menunggu persetujuan Sarpras.',
    ]);

    $dokumen = DB::table('peminjaman')
        ->where('peminjamanid', $peminjamanId)
        ->value('dokumen');

    expect($dokumen)->not->toBeNull();
    expect($dokumen)->toContain('https://example.supabase.co/storage/v1/object/public/dokumen-peminjaman/dokumen_peminjaman/');

    Http::assertSentCount(1);
});

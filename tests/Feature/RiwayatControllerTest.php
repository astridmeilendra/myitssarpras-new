<?php

use App\Models\AppUser;
use App\Models\Ruangan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Riwayat\RiwayatController;

uses(RefreshDatabase::class);

function createRiwayatUser(array $overrides = []): AppUser
{
    return AppUser::create(array_merge([
        'nama' => 'User Riwayat Test',
        'email_its' => 'riwayat@test.its.ac.id',
        'password_hash' => Hash::make('password123'),
        'no_telepon' => '08123456789',
        'is_admin' => false,
    ], $overrides));
}

function createRiwayatRoom(array $overrides = []): Ruangan
{
    return Ruangan::create(array_merge([
        'nama_ruangan' => 'Ruang Riwayat Test',
        'lokasi_ruangan' => 'Gedung Riwayat',
        'deskripsi' => 'Ruangan untuk test riwayat',
        'kapasitas' => 30,
        'foto' => null,
        'fasilitas' => 'AC,Proyektor',
    ], $overrides));
}

test('user diarahkan ke login jika membuka riwayat tanpa login', function () {
    $response = $this->get(route('riwayat'));

    $response->assertRedirect(route('login'));
});

test('user dapat melihat halaman riwayat peminjaman', function () {
    $user = createRiwayatUser();
    $ruangan = createRiwayatRoom();

    $peminjamanId = DB::table('peminjaman')->insertGetId([
        'userid' => $user->userid,
        'ruanganid' => $ruangan->ruanganid,
        'tanggal' => now()->addDays(2)->format('Y-m-d'),
        'nama_shift' => 'sesi1',
        'keterangan' => 'Peminjaman untuk riwayat',
        'dokumen' => null,
    ], 'peminjamanid');

    DB::table('riwayat_status')->insert([
        'peminjamanid' => $peminjamanId,
        'nama_status' => 'Menunggu',
        'waktu_update' => now(),
        'keterangan' => 'Menunggu persetujuan',
    ]);

    $response = $this->actingAs($user)
        ->get(route('riwayat'));

    $response->assertStatus(200);
    $response->assertViewIs('page.riwayat.riwayat');
    $response->assertViewHas('peminjamans');

    $peminjamans = $response->viewData('peminjamans');

    expect($peminjamans)->toHaveCount(1);
    expect($peminjamans->first()->userid)->toBe($user->userid);
});

test('controller riwayat menampilkan halaman statis riwayat dengan benar', function () {
    $controller = new RiwayatController();

    expect($controller->batal()->name())->toBe('page.riwayat.batal');
    expect($controller->dalam()->name())->toBe('page.riwayat.dalam');
    expect($controller->selesai()->name())->toBe('page.riwayat.selesai');
    expect($controller->konfirmasi()->name())->toBe('page.riwayat.konfirmasi');
    expect($controller->gagal()->name())->toBe('page.riwayat.fail');
});

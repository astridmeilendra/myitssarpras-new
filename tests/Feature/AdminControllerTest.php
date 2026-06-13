<?php

use App\Models\AppUser;
use App\Models\Ruangan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

function createDashboardAdmin(array $overrides = []): AppUser
{
    return AppUser::create(array_merge([
        'nama' => 'Admin Dashboard Test',
        'email_its' => 'admindashboard@test.its.ac.id',
        'password_hash' => Hash::make('password123'),
        'no_telepon' => '08123456789',
        'is_admin' => true,
    ], $overrides));
}

function createDashboardUser(array $overrides = []): AppUser
{
    return AppUser::create(array_merge([
        'nama' => 'User Peminjaman Dashboard',
        'email_its' => 'userdashboard@test.its.ac.id',
        'password_hash' => Hash::make('password123'),
        'no_telepon' => '08111111111',
        'is_admin' => false,
    ], $overrides));
}

function createDashboardRoom(array $overrides = []): Ruangan
{
    return Ruangan::create(array_merge([
        'nama_ruangan' => 'Ruang Dashboard Test',
        'lokasi_ruangan' => 'Gedung Dashboard',
        'deskripsi' => 'Ruangan untuk dashboard admin',
        'kapasitas' => 40,
        'foto' => null,
        'fasilitas' => 'AC,Proyektor',
    ], $overrides));
}

function createDashboardPeminjaman(AppUser $user, Ruangan $ruangan, array $overrides = []): int
{
    return DB::table('peminjaman')->insertGetId(array_merge([
        'userid' => $user->userid,
        'ruanganid' => $ruangan->ruanganid,
        'tanggal' => now()->addDays(2)->format('Y-m-d'),
        'nama_shift' => 'sesi1',
        'keterangan' => 'Peminjaman untuk dashboard admin',
        'dokumen' => null,
    ], $overrides), 'peminjamanid');
}

function createDashboardStatus(int $peminjamanId, string $status = 'Menunggu', ?string $keterangan = null): void
{
    DB::table('riwayat_status')->insert([
        'peminjamanid' => $peminjamanId,
        'nama_status' => $status,
        'waktu_update' => now(),
        'keterangan' => $keterangan,
    ]);
}

test('admin dapat melihat dashboard peminjaman', function () {
    $admin = createDashboardAdmin();
    $user = createDashboardUser();
    $ruangan = createDashboardRoom();

    $peminjamanId = createDashboardPeminjaman($user, $ruangan);
    createDashboardStatus($peminjamanId, 'Menunggu', 'Menunggu diproses');

    $response = $this->actingAs($admin)
        ->get(route('admin.dashboard'));

    $response->assertStatus(200);
    $response->assertViewIs('admin.dashboard');
    $response->assertViewHas('peminjaman');
    $response->assertViewHas('statuses');
    $response->assertViewHas('ruangan');
    $response->assertViewHas('sesi');

    $data = $response->viewData('peminjaman');

    expect($data)->toHaveCount(1);
    expect($data->first()->nama_ruangan)->toBe('Ruang Dashboard Test');
    expect($data->first()->nama_status)->toBe('Menunggu');
});

test('admin dapat memfilter dashboard berdasarkan status ruangan dan sesi', function () {
    $admin = createDashboardAdmin();
    $user = createDashboardUser();

    $ruanganA = createDashboardRoom([
        'nama_ruangan' => 'Ruang Filter A',
    ]);

    $ruanganB = createDashboardRoom([
        'nama_ruangan' => 'Ruang Filter B',
    ]);

    $peminjamanA = createDashboardPeminjaman($user, $ruanganA, [
        'nama_shift' => 'sesi1',
    ]);

    $peminjamanB = createDashboardPeminjaman($user, $ruanganB, [
        'nama_shift' => 'sesi2',
    ]);

    createDashboardStatus($peminjamanA, 'Disetujui');
    createDashboardStatus($peminjamanB, 'Ditolak');

    $response = $this->actingAs($admin)
        ->get(route('admin.dashboard', [
            'status' => 'Disetujui',
            'ruangan' => 'Filter A',
            'sesi' => 'sesi1',
            'sort' => 'status',
            'dir' => 'asc',
        ]));

    $response->assertStatus(200);

    $data = $response->viewData('peminjaman');

    expect($data)->toHaveCount(1);
    expect($data->first()->nama_ruangan)->toBe('Ruang Filter A');
    expect($data->first()->nama_status)->toBe('Disetujui');
    expect($data->first()->nama_shift)->toBe('sesi1');
});

test('admin dapat mengubah status peminjaman', function () {
    $admin = createDashboardAdmin();
    $user = createDashboardUser();
    $ruangan = createDashboardRoom();

    $peminjamanId = createDashboardPeminjaman($user, $ruangan);
    createDashboardStatus($peminjamanId, 'Menunggu');

    $response = $this->actingAs($admin)
        ->from(route('admin.dashboard'))
        ->post(route('admin.peminjaman.updateStatus', $peminjamanId), [
            'status' => 'Disetujui',
            'keterangan' => 'Peminjaman disetujui oleh admin',
        ]);

    $response->assertRedirect(route('admin.dashboard'));
    $response->assertSessionHas('success', 'Status peminjaman berhasil diperbarui.');

    $this->assertDatabaseHas('riwayat_status', [
        'peminjamanid' => $peminjamanId,
        'nama_status' => 'Disetujui',
        'keterangan' => 'Peminjaman disetujui oleh admin',
    ]);
});

test('admin gagal mengubah status jika peminjaman tidak ditemukan', function () {
    $admin = createDashboardAdmin();

    $response = $this->actingAs($admin)
        ->from(route('admin.dashboard'))
        ->post(route('admin.peminjaman.updateStatus', 9999), [
            'status' => 'Ditolak',
            'keterangan' => 'Data tidak ditemukan',
        ]);

    $response->assertRedirect(route('admin.dashboard'));
    $response->assertSessionHas('error', 'Peminjaman tidak ditemukan.');
});

test('admin gagal mengubah status jika status tidak valid', function () {
    $admin = createDashboardAdmin();
    $user = createDashboardUser();
    $ruangan = createDashboardRoom();

    $peminjamanId = createDashboardPeminjaman($user, $ruangan);
    createDashboardStatus($peminjamanId, 'Menunggu');

    $response = $this->actingAs($admin)
        ->from(route('admin.dashboard'))
        ->post(route('admin.peminjaman.updateStatus', $peminjamanId), [
            'status' => 'Status Salah',
            'keterangan' => 'Status tidak valid',
        ]);

    $response->assertRedirect(route('admin.dashboard'));
    $response->assertSessionHasErrors(['status']);
});

test('admin dapat mengurutkan dashboard berdasarkan ruangan dan sesi', function () {
    $admin = createDashboardAdmin();
    $user = createDashboardUser();

    $ruanganA = createDashboardRoom([
        'nama_ruangan' => 'Ruang A Sort',
    ]);

    $ruanganB = createDashboardRoom([
        'nama_ruangan' => 'Ruang B Sort',
    ]);

    $peminjamanA = createDashboardPeminjaman($user, $ruanganA, [
        'nama_shift' => 'sesi1',
    ]);

    $peminjamanB = createDashboardPeminjaman($user, $ruanganB, [
        'nama_shift' => 'sesi2',
    ]);

    createDashboardStatus($peminjamanA, 'Menunggu');
    createDashboardStatus($peminjamanB, 'Disetujui');

    $responseSortRuangan = $this->actingAs($admin)
        ->get(route('admin.dashboard', [
            'sort' => 'ruangan',
            'dir' => 'asc',
        ]));

    $responseSortRuangan->assertStatus(200);
    $responseSortRuangan->assertViewIs('admin.dashboard');

    $responseSortSesi = $this->actingAs($admin)
        ->get(route('admin.dashboard', [
            'sort' => 'sesi',
            'dir' => 'desc',
        ]));

    $responseSortSesi->assertStatus(200);
    $responseSortSesi->assertViewIs('admin.dashboard');
});

test('user biasa tidak dapat mengakses dashboard admin', function () {
    $user = createDashboardUser([
        'email_its' => 'userbiasaadmin@test.its.ac.id',
        'is_admin' => false,
    ]);

    $response = $this->actingAs($user)
        ->get(route('admin.dashboard'));

    $response->assertRedirect();
});

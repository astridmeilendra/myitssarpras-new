<?php

use App\Models\AppUser;
use App\Models\Ruangan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

function createCariRuanganRoom(array $overrides = []): Ruangan
{
    return Ruangan::create(array_merge([
        'nama_ruangan' => 'Ruang Seminar A',
        'lokasi_ruangan' => 'Gedung Rektorat Lantai 2',
        'deskripsi' => 'Ruangan seminar dengan fasilitas lengkap',
        'kapasitas' => 100,
        'foto' => null,
        'fasilitas' => 'AC,Proyektor,WiFi,Whiteboard',
    ], $overrides));
}

function createCariRuanganUser(array $overrides = []): AppUser
{
    return AppUser::create(array_merge([
        'nama' => 'User Cari Ruangan',
        'email_its' => 'cariruangan@test.its.ac.id',
        'password_hash' => Hash::make('password123'),
        'no_telepon' => '08123456789',
        'is_admin' => false,
    ], $overrides));
}

test('halaman cari ruangan dapat diakses dan menampilkan daftar ruangan', function () {
    createCariRuanganRoom();

    $response = $this->get(route('cari-ruangan.index'));

    $response->assertStatus(200);
    $response->assertViewIs('page.cariruangan.cariruangan');
    $response->assertViewHas('rooms');
    $response->assertViewHas('search');
});

test('halaman cari ruangan dapat melakukan pencarian berdasarkan nama ruangan', function () {
    createCariRuanganRoom([
        'nama_ruangan' => 'Ruang Khusus Testing',
    ]);

    createCariRuanganRoom([
        'nama_ruangan' => 'Auditorium Umum',
        'lokasi_ruangan' => 'Gedung B',
        'deskripsi' => 'Ruangan lain',
    ]);

    $response = $this->get(route('cari-ruangan.index', [
        'search' => 'Khusus',
    ]));

    $response->assertStatus(200);
    $response->assertViewHas('search', 'Khusus');

    $rooms = $response->viewData('rooms');

    expect($rooms)->toHaveCount(1);
    expect($rooms->first()['name'])->toBe('Ruang Khusus Testing');
});

test('api search ruangan berhasil mengembalikan data ruangan', function () {
    createCariRuanganRoom([
        'nama_ruangan' => 'Ruang Multimedia',
        'kapasitas' => 80,
        'fasilitas' => 'AC,Proyektor,WiFi',
    ]);

    $response = $this->postJson(route('cari-ruangan.search'), [
        'query' => 'Multimedia',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'count' => 1,
        ]);

    $response->assertJsonPath('data.0.name', 'Ruang Multimedia');
});

test('api search ruangan dapat memfilter kapasitas dan fasilitas', function () {
    createCariRuanganRoom([
        'nama_ruangan' => 'Ruang Besar',
        'kapasitas' => 150,
        'fasilitas' => 'AC,Proyektor,WiFi,Whiteboard',
    ]);

    createCariRuanganRoom([
        'nama_ruangan' => 'Ruang Kecil',
        'kapasitas' => 20,
        'fasilitas' => 'AC',
    ]);

    $response = $this->postJson(route('search.filter'), [
        'capacity' => '100 Orang',
        'facilities' => ['ac', 'wifi'],
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'count' => 1,
        ]);

    $response->assertJsonPath('data.0.name', 'Ruang Besar');
});

test('api search ruangan tidak menampilkan ruangan yang sudah dibooking pada tanggal dan shift yang sama', function () {
    $user = createCariRuanganUser();

    $ruanganTersedia = createCariRuanganRoom([
        'nama_ruangan' => 'Ruang Tersedia',
    ]);

    $ruanganTerbooking = createCariRuanganRoom([
        'nama_ruangan' => 'Ruang Terbooking',
    ]);

    DB::table('peminjaman')->insert([
        'userid' => $user->userid,
        'ruanganid' => $ruanganTerbooking->ruanganid,
        'tanggal' => now()->addDays(3)->format('Y-m-d'),
        'nama_shift' => 'sesi1',
        'keterangan' => 'Booking untuk testing',
        'dokumen' => null,
    ]);

    $response = $this->postJson(route('search.filter'), [
        'date' => now()->addDays(3)->format('Y-m-d'),
        'time' => 'sesi1',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'count' => 1,
        ]);

    $response->assertJsonPath('data.0.id', $ruanganTersedia->ruanganid);
});

test('api detail ruangan berhasil menampilkan data ruangan dan booking', function () {
    $user = createCariRuanganUser();
    $ruangan = createCariRuanganRoom([
        'foto' => 'https://example.com/foto-ruangan.jpg',
    ]);

    DB::table('peminjaman')->insert([
        'userid' => $user->userid,
        'ruanganid' => $ruangan->ruanganid,
        'tanggal' => now()->addDays(2)->format('Y-m-d'),
        'nama_shift' => 'sesi1',
        'keterangan' => 'Booking ruangan',
        'dokumen' => null,
    ]);

    $response = $this->getJson(route('search.show', $ruangan->ruanganid));

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
        ]);

    $response->assertJsonPath('data.room.name', 'Ruang Seminar A');
    $response->assertJsonPath('data.room.photo', 'https://example.com/foto-ruangan.jpg');
});

test('api detail ruangan gagal jika ruangan tidak ditemukan', function () {
    $response = $this->getJson(route('search.show', 9999));

    $response->assertStatus(404)
        ->assertJson([
            'success' => false,
            'message' => 'Ruangan tidak ditemukan',
        ]);
});

test('api fasilitas berhasil mengambil daftar fasilitas unik', function () {
    createCariRuanganRoom([
        'fasilitas' => 'AC,Proyektor,WiFi',
    ]);

    createCariRuanganRoom([
        'fasilitas' => 'AC,Whiteboard',
    ]);

    $response = $this->getJson(route('search.facilities'));

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
        ]);

    expect($response->json('data'))->toContain('AC');
    expect($response->json('data'))->toContain('Proyektor');
    expect($response->json('data'))->toContain('WiFi');
    expect($response->json('data'))->toContain('Whiteboard');
});

test('cek availability mengembalikan tersedia jika ruangan belum dipesan', function () {
    $ruangan = createCariRuanganRoom();

    $response = $this->postJson(route('search.check-availability'), [
        'ruanganid' => $ruangan->ruanganid,
        'tanggal' => now()->addDays(2)->format('Y-m-d'),
        'shift' => 'sesi1',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'available' => true,
            'message' => 'Ruangan tersedia',
        ]);
});

test('cek availability mengembalikan tidak tersedia jika ruangan sudah dipesan', function () {
    $user = createCariRuanganUser();
    $ruangan = createCariRuanganRoom();

    DB::table('peminjaman')->insert([
        'userid' => $user->userid,
        'ruanganid' => $ruangan->ruanganid,
        'tanggal' => now()->addDays(2)->format('Y-m-d'),
        'nama_shift' => 'sesi1',
        'keterangan' => 'Booking testing',
        'dokumen' => null,
    ]);

    $response = $this->postJson(route('search.check-availability'), [
        'ruanganid' => $ruangan->ruanganid,
        'tanggal' => now()->addDays(2)->format('Y-m-d'),
        'shift' => 'sesi1',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'available' => false,
            'message' => 'Ruangan sudah dipesan',
        ]);
});

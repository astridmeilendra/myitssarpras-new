<?php

use App\Models\AppUser;
use App\Models\Pertanyaan;
use App\Models\Jawaban;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

function createAdminPertanyaanUser(array $overrides = []): AppUser
{
    return AppUser::create(array_merge([
        'nama' => 'Admin Pertanyaan Test',
        'email_its' => 'adminpertanyaan@test.its.ac.id',
        'password_hash' => Hash::make('password123'),
        'no_telepon' => '08123456789',
        'is_admin' => true,
    ], $overrides));
}

function createPertanyaanOwner(array $overrides = []): AppUser
{
    return AppUser::create(array_merge([
        'nama' => 'User Pertanyaan Test',
        'email_its' => 'userpertanyaan@test.its.ac.id',
        'password_hash' => Hash::make('password123'),
        'no_telepon' => '08111111111',
        'is_admin' => false,
    ], $overrides));
}

function createAdminPertanyaanData(AppUser $user, array $overrides = []): Pertanyaan
{
    return Pertanyaan::create(array_merge([
        'userid' => $user->userid,
        'isi_pertanyaan' => 'Bagaimana cara meminjam ruangan?',
        'lampiran' => null,
        'sifat' => 'rendah',
    ], $overrides));
}

test('admin dapat melihat daftar pertanyaan', function () {
    $admin = createAdminPertanyaanUser();
    $user = createPertanyaanOwner();

    createAdminPertanyaanData($user);

    $response = $this->actingAs($admin)
        ->get(route('admin.pertanyaan.index'));

    $response->assertStatus(200);
    $response->assertViewIs('admin.pertanyaan.index');
    $response->assertViewHas('pertanyaan');
});

test('admin dapat memfilter pertanyaan berdasarkan sifat status dan lampiran', function () {
    $admin = createAdminPertanyaanUser();
    $user = createPertanyaanOwner();

    $pertanyaan = createAdminPertanyaanData($user, [
        'sifat' => 'sedang',
        'lampiran' => 'lampiran-test.pdf',
    ]);

    Jawaban::create([
        'pertanyaanid' => $pertanyaan->pertanyaanid,
        'isi_jawaban' => 'Jawaban sudah tersedia',
    ]);

    $response = $this->actingAs($admin)
        ->get(route('admin.pertanyaan.index', [
            'sifat' => 'sedang',
            'status' => 'terjawab',
            'lampiran' => 'yes',
        ]));

    $response->assertStatus(200);
    $response->assertViewHas('pertanyaan');

    $data = $response->viewData('pertanyaan');

    expect($data->count())->toBe(1);
});

test('admin dapat melihat detail pertanyaan', function () {
    $admin = createAdminPertanyaanUser();
    $user = createPertanyaanOwner();

    $pertanyaan = createAdminPertanyaanData($user);

    $response = $this->actingAs($admin)
        ->get(route('admin.pertanyaan.show', $pertanyaan->pertanyaanid));

    $response->assertStatus(200);
    $response->assertViewIs('admin.pertanyaan.show');
    $response->assertViewHas('pertanyaan');
});

test('admin dapat menyimpan jawaban baru untuk pertanyaan', function () {
    $admin = createAdminPertanyaanUser();
    $user = createPertanyaanOwner();

    $pertanyaan = createAdminPertanyaanData($user);

    $response = $this->actingAs($admin)
        ->post(route('admin.pertanyaan.store', $pertanyaan->pertanyaanid), [
            'isi_jawaban' => 'Silakan cek jadwal ruangan terlebih dahulu.',
        ]);

    $response->assertRedirect(route('admin.pertanyaan.show', $pertanyaan->pertanyaanid));
    $response->assertSessionHas('success', 'Jawaban berhasil disimpan!');

    $this->assertDatabaseHas('jawaban', [
        'pertanyaanid' => $pertanyaan->pertanyaanid,
        'isi_jawaban' => 'Silakan cek jadwal ruangan terlebih dahulu.',
    ]);
});

test('admin dapat memperbarui jawaban melalui store jika jawaban sudah ada', function () {
    $admin = createAdminPertanyaanUser();
    $user = createPertanyaanOwner();

    $pertanyaan = createAdminPertanyaanData($user);

    Jawaban::create([
        'pertanyaanid' => $pertanyaan->pertanyaanid,
        'isi_jawaban' => 'Jawaban lama',
    ]);

    $response = $this->actingAs($admin)
        ->post(route('admin.pertanyaan.store', $pertanyaan->pertanyaanid), [
            'isi_jawaban' => 'Jawaban baru dari admin',
        ]);

    $response->assertRedirect(route('admin.pertanyaan.show', $pertanyaan->pertanyaanid));
    $response->assertSessionHas('success', 'Jawaban berhasil disimpan!');

    $this->assertDatabaseHas('jawaban', [
        'pertanyaanid' => $pertanyaan->pertanyaanid,
        'isi_jawaban' => 'Jawaban baru dari admin',
    ]);
});

test('admin dapat update jawaban yang sudah ada', function () {
    $admin = createAdminPertanyaanUser();
    $user = createPertanyaanOwner();

    $pertanyaan = createAdminPertanyaanData($user);

    Jawaban::create([
        'pertanyaanid' => $pertanyaan->pertanyaanid,
        'isi_jawaban' => 'Jawaban sebelum update',
    ]);

    $response = $this->actingAs($admin)
        ->put(route('admin.pertanyaan.update', $pertanyaan->pertanyaanid), [
            'isi_jawaban' => 'Jawaban setelah update',
        ]);

    $response->assertRedirect(route('admin.pertanyaan.show', $pertanyaan->pertanyaanid));
    $response->assertSessionHas('success', 'Jawaban berhasil diperbarui!');

    $this->assertDatabaseHas('jawaban', [
        'pertanyaanid' => $pertanyaan->pertanyaanid,
        'isi_jawaban' => 'Jawaban setelah update',
    ]);
});

test('admin mendapat error saat update jika jawaban belum ada', function () {
    $admin = createAdminPertanyaanUser();
    $user = createPertanyaanOwner();

    $pertanyaan = createAdminPertanyaanData($user);

    $response = $this->actingAs($admin)
        ->from(route('admin.pertanyaan.show', $pertanyaan->pertanyaanid))
        ->put(route('admin.pertanyaan.update', $pertanyaan->pertanyaanid), [
            'isi_jawaban' => 'Jawaban tidak bisa diperbarui',
        ]);

    $response->assertRedirect(route('admin.pertanyaan.show', $pertanyaan->pertanyaanid));
    $response->assertSessionHas('error', 'Jawaban tidak ditemukan.');
});

test('admin dapat menghapus jawaban', function () {
    $admin = createAdminPertanyaanUser();
    $user = createPertanyaanOwner();

    $pertanyaan = createAdminPertanyaanData($user);

    Jawaban::create([
        'pertanyaanid' => $pertanyaan->pertanyaanid,
        'isi_jawaban' => 'Jawaban yang akan dihapus',
    ]);

    $response = $this->actingAs($admin)
        ->delete(route('admin.pertanyaan.destroy', $pertanyaan->pertanyaanid));

    $response->assertRedirect(route('admin.pertanyaan.show', $pertanyaan->pertanyaanid));
    $response->assertSessionHas('success', 'Jawaban berhasil dihapus!');

    $this->assertDatabaseMissing('jawaban', [
        'pertanyaanid' => $pertanyaan->pertanyaanid,
        'isi_jawaban' => 'Jawaban yang akan dihapus',
    ]);
});

test('admin mendapat error saat hapus jika jawaban belum ada', function () {
    $admin = createAdminPertanyaanUser();
    $user = createPertanyaanOwner();

    $pertanyaan = createAdminPertanyaanData($user);

    $response = $this->actingAs($admin)
        ->from(route('admin.pertanyaan.show', $pertanyaan->pertanyaanid))
        ->delete(route('admin.pertanyaan.destroy', $pertanyaan->pertanyaanid));

    $response->assertRedirect(route('admin.pertanyaan.show', $pertanyaan->pertanyaanid));
    $response->assertSessionHas('error', 'Jawaban tidak ditemukan.');
});

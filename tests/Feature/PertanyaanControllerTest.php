<?php

use App\Models\AppUser;
use App\Models\Pertanyaan;
use App\Models\Jawaban;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

uses(RefreshDatabase::class);

function createPertanyaanControllerUser(array $overrides = []): AppUser
{
    return AppUser::create(array_merge([
        'nama' => 'User Pertanyaan Controller Test',
        'email_its' => 'pertanyaancontroller@test.its.ac.id',
        'password_hash' => Hash::make('password123'),
        'no_telepon' => '08123456789',
        'is_admin' => false,
    ], $overrides));
}

test('user dapat membuka halaman kirim pertanyaan dan melihat riwayat pertanyaan', function () {
    $user = createPertanyaanControllerUser();

    $pertanyaan = Pertanyaan::create([
        'userid' => $user->userid,
        'isi_pertanyaan' => 'Bagaimana cara meminjam ruangan?',
        'lampiran' => null,
        'sifat' => 'rendah',
    ]);

    Jawaban::create([
        'pertanyaanid' => $pertanyaan->pertanyaanid,
        'isi_jawaban' => 'Silakan cek menu peminjaman ruangan.',
    ]);

    $response = $this->actingAs($user)
        ->get(route('kirim-pertanyaan'));

    $response->assertStatus(200);
    $response->assertViewIs('page.info.kirim-pertanyaan');
    $response->assertViewHas('histories');

    $histories = $response->viewData('histories');

    expect($histories)->toHaveCount(1);
    expect($histories->first()->isi_pertanyaan)->toBe('Bagaimana cara meminjam ruangan?');
});

test('user dapat menyimpan pertanyaan tanpa lampiran', function () {
    $user = createPertanyaanControllerUser();

    $response = $this->actingAs($user)
        ->post(route('pertanyaan.savePertanyaan'), [
            'isi_pertanyaan' => 'Apakah ruangan bisa dipinjam hari Sabtu?',
            'sifat' => 'sedang',
        ]);

    $response->assertStatus(200);
    $response->assertViewIs('page.info.pertanyaan-berhasil');

    $this->assertDatabaseHas('pertanyaan', [
        'userid' => $user->userid,
        'isi_pertanyaan' => 'Apakah ruangan bisa dipinjam hari Sabtu?',
        'lampiran' => null,
        'sifat' => 'sedang',
    ]);
});

test('user gagal menyimpan pertanyaan jika isi pertanyaan kosong', function () {
    $user = createPertanyaanControllerUser();

    $response = $this->actingAs($user)
        ->from(route('kirim-pertanyaan'))
        ->post(route('pertanyaan.savePertanyaan'), [
            'isi_pertanyaan' => '',
            'sifat' => 'rendah',
        ]);

    $response->assertRedirect(route('kirim-pertanyaan'));
    $response->assertSessionHasErrors(['isi_pertanyaan']);
});

test('user gagal menyimpan pertanyaan jika sifat tidak valid', function () {
    $user = createPertanyaanControllerUser();

    $response = $this->actingAs($user)
        ->from(route('kirim-pertanyaan'))
        ->post(route('pertanyaan.savePertanyaan'), [
            'isi_pertanyaan' => 'Pertanyaan dengan sifat tidak valid',
            'sifat' => 'tinggi',
        ]);

    $response->assertRedirect(route('kirim-pertanyaan'));
    $response->assertSessionHasErrors(['sifat']);
});

test('user dapat menyimpan pertanyaan dengan lampiran jika upload supabase berhasil', function () {
    putenv('SUPABASE_URL=https://example.supabase.co');
    putenv('SUPABASE_SERVICE_ROLE=test-service-role-key');

    $_ENV['SUPABASE_URL'] = 'https://example.supabase.co';
    $_ENV['SUPABASE_SERVICE_ROLE'] = 'test-service-role-key';

    $_SERVER['SUPABASE_URL'] = 'https://example.supabase.co';
    $_SERVER['SUPABASE_SERVICE_ROLE'] = 'test-service-role-key';

    Http::fake([
        'https://example.supabase.co/*' => Http::response([], 200),
    ]);

    $user = createPertanyaanControllerUser();

    $file = UploadedFile::fake()->create('lampiran.pdf', 100, 'application/pdf');

    $response = $this->actingAs($user)
        ->post(route('pertanyaan.savePertanyaan'), [
            'isi_pertanyaan' => 'Saya ingin bertanya dengan lampiran.',
            'sifat' => 'menengah',
            'lampiran' => $file,
        ]);

    $response->assertStatus(200);
    $response->assertViewIs('page.info.pertanyaan-berhasil');

    $this->assertDatabaseHas('pertanyaan', [
        'userid' => $user->userid,
        'isi_pertanyaan' => 'Saya ingin bertanya dengan lampiran.',
        'sifat' => 'menengah',
    ]);

    $pertanyaan = Pertanyaan::where('userid', $user->userid)
        ->where('isi_pertanyaan', 'Saya ingin bertanya dengan lampiran.')
        ->first();

    expect($pertanyaan)->not->toBeNull();
    expect($pertanyaan->lampiran)->not->toBeNull();
    expect($pertanyaan->lampiran)->toContain('lampiran.pdf');

    Http::assertSentCount(1);
});

test('user diarahkan kembali jika upload lampiran ke supabase gagal', function () {
    putenv('SUPABASE_URL=https://example.supabase.co');
    putenv('SUPABASE_SERVICE_ROLE=test-service-role-key');

    $_ENV['SUPABASE_URL'] = 'https://example.supabase.co';
    $_ENV['SUPABASE_SERVICE_ROLE'] = 'test-service-role-key';

    $_SERVER['SUPABASE_URL'] = 'https://example.supabase.co';
    $_SERVER['SUPABASE_SERVICE_ROLE'] = 'test-service-role-key';

    Http::fake([
        'https://example.supabase.co/*' => Http::response('Upload gagal', 500),
    ]);

    $user = createPertanyaanControllerUser();

    $file = UploadedFile::fake()->create('lampiran-gagal.pdf', 100, 'application/pdf');

    $response = $this->actingAs($user)
        ->from(route('kirim-pertanyaan'))
        ->post(route('pertanyaan.savePertanyaan'), [
            'isi_pertanyaan' => 'Pertanyaan dengan lampiran gagal.',
            'sifat' => 'rendah',
            'lampiran' => $file,
        ]);

    $response->assertRedirect(route('kirim-pertanyaan'));
    $response->assertSessionHas('error');

    $this->assertDatabaseMissing('pertanyaan', [
        'userid' => $user->userid,
        'isi_pertanyaan' => 'Pertanyaan dengan lampiran gagal.',
    ]);
});

<?php

use App\Models\AppUser;
use App\Models\Jawaban;
use App\Models\Peminjaman;
use App\Models\Pertanyaan;
use App\Models\RiwayatStatus;
use App\Models\Ruangan;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('model peminjaman memiliki relasi utama', function () {
    $peminjaman = new Peminjaman();

    expect($peminjaman->user())->toBeInstanceOf(BelongsTo::class);
    expect($peminjaman->ruangan())->toBeInstanceOf(BelongsTo::class);
    expect($peminjaman->riwayatStatus())->toBeInstanceOf(HasMany::class);
    expect($peminjaman->statusTerakhir())->toBeInstanceOf(HasOne::class);
});

test('model jawaban memiliki relasi ke pertanyaan', function () {
    $jawaban = new Jawaban();

    expect($jawaban->pertanyaan())->toBeInstanceOf(BelongsTo::class);
});

test('model pertanyaan memiliki relasi user dan jawaban', function () {
    $pertanyaan = new Pertanyaan();

    expect($pertanyaan->user())->toBeInstanceOf(BelongsTo::class);
    expect($pertanyaan->jawaban())->toBeInstanceOf(HasOne::class);
});

test('model riwayat status memiliki relasi ke peminjaman', function () {
    $riwayatStatus = new RiwayatStatus();

    expect($riwayatStatus->peminjaman())->toBeInstanceOf(BelongsTo::class);
});

test('model ruangan memiliki konfigurasi dasar yang benar', function () {
    $ruangan = new Ruangan();

    expect($ruangan->getTable())->toBe('ruangan');
    expect($ruangan->getKeyName())->toBe('ruanganid');
    expect($ruangan->usesTimestamps())->toBeFalse();
    expect($ruangan->getFillable())->toContain('nama_ruangan');
    expect($ruangan->getFillable())->toContain('lokasi_ruangan');
    expect($ruangan->getFillable())->toContain('deskripsi');
    expect($ruangan->getFillable())->toContain('kapasitas');
    expect($ruangan->getFillable())->toContain('foto');
    expect($ruangan->getFillable())->toContain('fasilitas');
});

test('model app user memiliki konfigurasi dasar yang benar', function () {
    $user = new AppUser();

    expect($user->getTable())->toBe('app_user');
    expect($user->getKeyName())->toBe('userid');
    expect($user->usesTimestamps())->toBeFalse();
    expect($user->getFillable())->toContain('nama');
    expect($user->getFillable())->toContain('email_its');
    expect($user->getFillable())->toContain('password_hash');
    expect($user->getFillable())->toContain('no_telepon');
    expect($user->getFillable())->toContain('foto_profile');
    expect($user->getFillable())->toContain('is_admin');
});

test('model pertanyaan memiliki konfigurasi dasar yang benar', function () {
    $pertanyaan = new Pertanyaan();

    expect($pertanyaan->getTable())->toBe('pertanyaan');
    expect($pertanyaan->getKeyName())->toBe('pertanyaanid');
    expect($pertanyaan->usesTimestamps())->toBeFalse();
    expect($pertanyaan->getFillable())->toContain('userid');
    expect($pertanyaan->getFillable())->toContain('isi_pertanyaan');
    expect($pertanyaan->getFillable())->toContain('lampiran');
    expect($pertanyaan->getFillable())->toContain('sifat');
});

test('model jawaban memiliki konfigurasi dasar yang benar', function () {
    $jawaban = new Jawaban();

    expect($jawaban->getTable())->toBe('jawaban');
    expect($jawaban->getKeyName())->toBe('jawabanid');
    expect($jawaban->getFillable())->toContain('pertanyaanid');
    expect($jawaban->getFillable())->toContain('isi_jawaban');
    expect($jawaban->getFillable())->toContain('admin_id');
});

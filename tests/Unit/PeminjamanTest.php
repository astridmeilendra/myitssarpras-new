<?php

use App\Models\Peminjaman;

test('peminjaman memiliki fillable yang benar', function () {
    $peminjaman = new Peminjaman();

    expect($peminjaman->getFillable())->toBe([
        'userid',
        'keterangan',
        'dokumen'
    ]);
});

test('peminjaman menggunakan primary key yang benar', function () {
    $peminjaman = new Peminjaman();

    expect($peminjaman->getKeyName())->toBe('peminjamanid');
});

test('peminjaman menggunakan nama tabel yang benar', function () {
    $peminjaman = new Peminjaman();

    expect($peminjaman->getTable())->toBe('peminjaman');
});

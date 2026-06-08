<?php

use App\Models\Ruangan;

test('ruangan memiliki fillable yang benar', function () {
    $ruangan = new Ruangan();

    expect($ruangan->getFillable())->toBe([
        'nama_ruangan',
        'lokasi_ruangan',
        'deskripsi',
        'kapasitas',
        'foto',
        'fasilitas'
    ]);
});

test('fasilitas array attribute mengembalikan array ketika fasilitas tidak null', function () {
    $ruangan = new Ruangan();
    $ruangan->fasilitas = 'AC,Proyektor,Whiteboard';

    expect($ruangan->fasilitas_array)->toBe(['AC', 'Proyektor', 'Whiteboard']);
});

test('fasilitas array attribute mengembalikan array kosong ketika fasilitas null', function () {
    $ruangan = new Ruangan();
    $ruangan->fasilitas = null;

    expect($ruangan->fasilitas_array)->toBe([]);
});

test('ruangan menggunakan primary key yang benar', function () {
    $ruangan = new Ruangan();

    expect($ruangan->getKeyName())->toBe('ruanganid');
});

test('ruangan menggunakan nama tabel yang benar', function () {
    $ruangan = new Ruangan();

    expect($ruangan->getTable())->toBe('ruangan');
});

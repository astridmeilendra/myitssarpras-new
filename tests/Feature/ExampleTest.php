<?php

test('halaman utama mengembalikan status 200 sukses', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});

// Contoh test lain: memastikan halaman login bisa diakses
test('halaman login bisa diakses', function () {
    $response = $this->get('/login');
    $response->assertStatus(200);
});
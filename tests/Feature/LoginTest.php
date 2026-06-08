<?php

use App\Models\AppUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('halaman login dapat diakses', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('login gagal dengan email yang tidak terdaftar', function () {
    $response = $this->post('/login', [
        'email'    => 'tidakada@its.ac.id',
        'password' => 'password123',
    ]);

    $response->assertSessionHasErrors('email');
});

test('login gagal dengan password salah', function () {
    AppUser::create([
        'nama'          => 'Test User',
        'email_its'     => 'test@student.its.ac.id',
        'password_hash' => Hash::make('passwordbenar'),
        'is_admin'      => false,
    ]);

    $response = $this->post('/login', [
        'email'    => 'test@student.its.ac.id',
        'password' => 'passwordsalah',
    ]);

    $response->assertSessionHasErrors('email');
});

test('login berhasil sebagai user biasa dan redirect ke home', function () {
    AppUser::create([
        'nama'          => 'User Biasa',
        'email_its'     => 'user@student.its.ac.id',
        'password_hash' => Hash::make('password123'),
        'is_admin'      => false,
    ]);

    $response = $this->post('/login', [
        'email'    => 'user@student.its.ac.id',
        'password' => 'password123',
    ]);

    $response->assertRedirect(route('home'));
});

test('login berhasil sebagai admin dan redirect ke dashboard', function () {
    AppUser::create([
        'nama'          => 'Admin',
        'email_its'     => 'admin@its.ac.id',
        'password_hash' => Hash::make('adminpass'),
        'is_admin'      => true,
    ]);

    $response = $this->post('/login', [
        'email'    => 'admin@its.ac.id',
        'password' => 'adminpass',
    ]);

    $response->assertRedirect(route('admin.dashboard'));
});

test('login gagal jika email kosong', function () {
    $response = $this->post('/login', [
        'email'    => '',
        'password' => 'password123',
    ]);

    $response->assertSessionHasErrors('email');
});

test('login gagal jika password kosong', function () {
    $response = $this->post('/login', [
        'email'    => 'test@its.ac.id',
        'password' => '',
    ]);

    $response->assertSessionHasErrors('password');
});

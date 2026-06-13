<?php

use App\Models\AppUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

function createProfileUser(array $overrides = []): AppUser
{
    return AppUser::create(array_merge([
        'nama' => 'User Profile Test',
        'email_its' => '5026231151@student.its.ac.id',
        'password_hash' => Hash::make('password123'),
        'no_telepon' => '08123456789',
        'is_admin' => false,
    ], $overrides));
}

test('user diarahkan ke login jika membuka profile tanpa session', function () {
    $response = $this->get(route('profile'));

    $response->assertRedirect(route('login'));
});

test('user dapat melihat halaman profile jika session valid', function () {
    $user = createProfileUser();

    $response = $this->actingAs($user)
        ->withSession([
            'user_id' => $user->userid,
        ])
        ->get(route('profile'));

    $response->assertStatus(200);
    $response->assertViewIs('page.profile.profile');
    $response->assertViewHas('user');
    $response->assertViewHas('nrp', '5026231151');
});

test('user diarahkan ke login jika data user di session tidak ditemukan', function () {
    $response = $this->withSession([
        'user_id' => 9999,
    ])->get(route('profile'));

    $response->assertRedirect(route('login'));
});

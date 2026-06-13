<?php

use App\Helpers\SupabaseHelper;

test('supabase helper dapat memecah string foto menjadi array', function () {
    $result = SupabaseHelper::parseFotoUrls('https://example.com/a.jpg, https://example.com/b.jpg');

    expect($result)->toBe([
        'https://example.com/a.jpg',
        'https://example.com/b.jpg',
    ]);
});

test('supabase helper mengembalikan array kosong jika foto kosong', function () {
    expect(SupabaseHelper::parseFotoUrls(null))->toBe([]);
    expect(SupabaseHelper::parseFotoUrls(''))->toBe([]);
});

test('supabase helper mengembalikan array jika input sudah array', function () {
    $result = SupabaseHelper::parseFotoUrls([
        'https://example.com/a.jpg',
        '',
        'https://example.com/b.jpg',
    ]);

    expect($result)->toBe([
        'https://example.com/a.jpg',
        'https://example.com/b.jpg',
    ]);
});

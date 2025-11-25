<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

// Debug endpoint untuk cek Supabase config
Route::get('/debug/supabase', function () {
    $envPath = base_path('.env');
    $envContent = file_get_contents($envPath);

    preg_match('/SUPABASE_URL=(.*)/', $envContent, $urlMatch);
    preg_match('/SUPABASE_SERVICE_ROLE=(.*)/', $envContent, $keyMatch);
    preg_match('/SUPABASE_BUCKET=(.*)/', $envContent, $bucketMatch);

    $url = trim($urlMatch[1] ?? '');
    $key = trim($keyMatch[1] ?? '');
    $bucket = trim($bucketMatch[1] ?? '');

    return response()->json([
        'supabase_url' => $url ? substr($url, 0, 30) . '...' : 'NOT SET',
        'supabase_key_length' => strlen($key),
        'supabase_key_preview' => $key ? substr($key, 0, 20) . '...' . substr($key, -10) : 'NOT SET',
        'supabase_bucket' => $bucket,
    ]);
});

// Test upload file to foto-profile bucket
Route::post('/debug/upload-test', function (\Illuminate\Http\Request $request) {
    $envPath = base_path('.env');
    $envContent = file_get_contents($envPath);

    preg_match('/SUPABASE_URL=(.*)/', $envContent, $urlMatch);
    preg_match('/SUPABASE_SERVICE_ROLE=(.*)/', $envContent, $keyMatch);

    $supabaseUrl = rtrim(trim($urlMatch[1] ?? ''), '/');
    $supabaseKey = trim($keyMatch[1] ?? '');

    if (!$request->hasFile('file')) {
        return response()->json(['error' => 'No file provided'], 400);
    }

    $file = $request->file('file');
    $timestamp = time();
    $filename = 'test_' . $timestamp . '_' . $file->getClientOriginalName();
    $filePath = "foto-profile/{$filename}";

    $fileContent = file_get_contents($file->getRealPath());
    $mimeType = $file->getMimeType();

    $uploadUrl = "{$supabaseUrl}/storage/v1/object/{$filePath}";

    \Log::info('Test upload attempt', [
        'url' => $uploadUrl,
        'file' => $filename,
        'mime' => $mimeType,
    ]);

    $response = Http::timeout(60)
        ->withHeaders([
            'Authorization' => 'Bearer ' . $supabaseKey,
            'Content-Type' => $mimeType,
        ])->withBody($fileContent, $mimeType)
        ->post($uploadUrl);

    \Log::info('Test upload response', [
        'status' => $response->status(),
        'body' => $response->body(),
    ]);

    return response()->json([
        'status' => $response->status(),
        'success' => $response->successful(),
        'body' => $response->body(),
        'public_url' => $response->successful() ? "{$supabaseUrl}/storage/v1/object/public/{$filePath}" : null,
    ]);
});

<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SupabaseHelper
{
    public static function uploadFile($file, $bucket = 'dokumen-peminjaman', $path = null)
    {
        try {
            // AMBIL KONFIGURASI DARI SERVICES.PHP
            $supabaseUrl = config('services.supabase.url');
            $supabaseKey = config('services.supabase.service_role');

            if (!$supabaseUrl || !$supabaseKey) {
                Log::error('Supabase: Configuration missing!');
                return null;
            }

            if (!$file || !$file->isValid()) {
                Log::error('Supabase: File invalid!');
                return null;
            }

            $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . time() . '-' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $filePath = $path ? $path . '/' . $filename : $filename;
            $uploadUrl = "{$supabaseUrl}/storage/v1/object/{$bucket}/{$filePath}";

            // Upload dengan bypass SSL (withoutVerifying) untuk menghindari error SSL Certificate di Azure
            $response = Http::timeout(60)
                ->withoutVerifying() 
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $supabaseKey,
                    'Content-Type' => $file->getMimeType(),
                    'x-upsert' => 'true',
                ])
                ->withBody(file_get_contents($file), $file->getMimeType())
                ->post($uploadUrl);

            if ($response->failed()) {
                Log::error('Supabase Upload Failed: ' . $response->body());
                return null;
            }

            return "{$supabaseUrl}/storage/v1/object/public/{$bucket}/{$filePath}";
            
        } catch (\Exception $e) {
            Log::error('Supabase Exception: ' . $e->getMessage());
            return null;
        }
    }
}
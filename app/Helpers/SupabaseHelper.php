<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SupabaseHelper
{
    /**
     * Helper untuk mengambil config yang aman dari cache
     */
    private static function getConfig($key)
    {
        return config("services.supabase.{$key}");
    }

    public static function uploadFile($file, $bucket = 'ruangan', $path = null)
    {
        try {
            if (!$file || !$file->isValid()) {
                return null;
            }

            // MENGGUNAKAN CONFIG() BUKAN LAGI BACA FILE .ENV
            $supabaseUrl = self::getConfig('url');
            $supabaseKey = self::getConfig('service_role'); // Pastikan key ini ada di services.php

            if (!$supabaseUrl || !$supabaseKey) {
                Log::error('Supabase configuration missing');
                return null;
            }

            $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . time() . '-' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $filePath = $path ? $path . '/' . $filename : $filename;
            $fullPath = $bucket . '/' . $filePath;
            $uploadUrl = "{$supabaseUrl}/storage/v1/object/{$bucket}/{$filePath}";

            $fileContent = file_get_contents($file);

            $response = Http::timeout(60)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $supabaseKey,
                    'Content-Type' => $file->getMimeType(),
                    'x-upsert' => 'true',
                ])->withBody($fileContent, $file->getMimeType())
                ->post($uploadUrl);

            if ($response->failed()) {
                Log::error('Supabase upload failed: ' . $response->body());
                return null;
            }

            return "{$supabaseUrl}/storage/v1/object/public/{$fullPath}";
        } catch (\Exception $e) {
            Log::error('Supabase upload error: ' . $e->getMessage());
            return null;
        }
    }

    public static function deleteFile($url, $bucket = 'ruangan')
    {
        try {
            $supabaseUrl = self::getConfig('url');
            $supabaseKey = self::getConfig('key'); // Sesuaikan dengan key yang dipakai delete

            if (!$supabaseUrl || !$supabaseKey) {
                return false;
            }

            $path = str_replace("{$supabaseUrl}/storage/v1/object/public/", '', $url);
            $deleteUrl = "{$supabaseUrl}/storage/v1/object/{$path}";

            $response = Http::timeout(60)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $supabaseKey,
                ])->delete($deleteUrl);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Supabase delete error: ' . $e->getMessage());
            return false;
        }
    }
}
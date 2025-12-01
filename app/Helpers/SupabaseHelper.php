<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SupabaseHelper
{
    /**
     * Upload file ke Supabase bucket menggunakan REST API
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $bucket
     * @param string|null $path
     * @return string|null URL file yang sudah diupload
     */
    public static function uploadFile($file, $bucket = 'ruangan', $path = null)
    {
        try {
            if (!$file || !$file->isValid()) {
                return null;
            }

            // Baca langsung dari .env file (bypass cache)
            $envPath = base_path('.env');
            $envContent = file_get_contents($envPath);

            // Parse .env
            preg_match('/SUPABASE_URL=(.*)/', $envContent, $urlMatch);
            preg_match('/SUPABASE_SERVICE_ROLE=(.*)/', $envContent, $keyMatch);

            $supabaseUrl = trim($urlMatch[1] ?? '');
            $supabaseKey = trim($keyMatch[1] ?? '');

            if (!$supabaseUrl || !$supabaseKey) {
                Log::error('Supabase configuration missing');
                return null;
            }

            // Generate nama file dengan timestamp dan random string
            $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . time() . '-' . Str::random(8) . '.' . $file->getClientOriginalExtension();

            // Tentukan path
            $filePath = $path ? $path . '/' . $filename : $filename;
            $fullPath = $bucket . '/' . $filePath;

            // Construct URL dengan benar
            $uploadUrl = "{$supabaseUrl}/storage/v1/object/{$bucket}/{$filePath}";

            Log::info('Supabase upload attempt', [
                'url' => $uploadUrl,
                'file' => $filename,
                'bucket' => $bucket,
            ]);

            // Siapkan file content
            $fileContent = file_get_contents($file);

            // Upload ke Supabase Storage via REST API
            // Gunakan service role key untuk bypass RLS
            $response = Http::timeout(60)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $supabaseKey,
                    'Content-Type' => $file->getMimeType(),
                    'x-upsert' => 'true',
                ])->withBody($fileContent, $file->getMimeType())
                ->post($uploadUrl);

            Log::info('Supabase upload response', [
                'status' => $response->status(),
                'success' => $response->successful(),
                'body' => $response->body(),
            ]);

            if ($response->failed()) {
                Log::error('Supabase upload failed: ' . $response->body());
                return null;
            }

            // Generate URL public
            $url = "{$supabaseUrl}/storage/v1/object/public/{$fullPath}";

            return $url;
        } catch (\Exception $e) {
            Log::error('Supabase upload error: ' . $e->getMessage());
            return null;
        }
    }    /**
     * Upload multiple files
     *
     * @param array $files Array of UploadedFile
     * @param string $bucket
     * @param string|null $path
     * @return array|null Array of URLs separated by comma
     */
    public static function uploadMultipleFiles($files, $bucket = 'ruangan', $path = null)
    {
        $urls = [];

        foreach ($files as $file) {
            if ($file && $file->isValid()) {
                $url = self::uploadFile($file, $bucket, $path);
                if ($url) {
                    $urls[] = $url;
                }
            }
        }

        return !empty($urls) ? implode(',', $urls) : null;
    }

    /**
     * Hapus file dari Supabase
     *
     * @param string $url
     * @param string $bucket
     * @return bool
     */
    public static function deleteFile($url, $bucket = 'ruangan')
    {
        try {
            // Baca langsung dari .env file (bypass cache)
            $envPath = base_path('.env');
            $envContent = file_get_contents($envPath);

            // Parse .env
            preg_match('/SUPABASE_URL=(.*)/', $envContent, $urlMatch);
            preg_match('/SUPABASE_KEY=(.*)/', $envContent, $keyMatch);

            $supabaseUrl = trim($urlMatch[1] ?? '');
            $supabaseKey = trim($keyMatch[1] ?? '');

            if (!$supabaseUrl || !$supabaseKey) {
                Log::error('Supabase configuration missing for delete');
                return false;
            }

            // Extract path dari URL
            // URL format: https://...supabase.co/storage/v1/object/public/bucket/path/to/file
            $path = str_replace("{$supabaseUrl}/storage/v1/object/public/", '', $url);

            // Construct delete URL
            $deleteUrl = "{$supabaseUrl}/storage/v1/object/{$path}";

            Log::info('Supabase delete attempt', [
                'url' => $deleteUrl,
            ]);

            // Delete dari Supabase Storage via REST API
            $response = Http::timeout(60)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $supabaseKey,
                ])->delete($deleteUrl);

            Log::info('Supabase delete response', [
                'status' => $response->status(),
                'success' => $response->successful(),
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Supabase delete error: ' . $e->getMessage());
            return false;
        }
    }    /**
     * Parse foto URLs dari string (dipisahkan dengan koma)
     *
     * @param string|null $fotoString
     * @return array
     */
    public static function parseFotoUrls($fotoString)
    {
        if (!$fotoString) {
            return [];
        }

        return array_map('trim', explode(',', $fotoString));
    }
}

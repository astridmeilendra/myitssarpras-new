# Photo Profile Upload - Implementation Done

## Perubahan yang Telah Dilakukan

### 1. AkunController (`app/Http/Controllers/EditakundanHapusakun/AkunController.php`)

Implementasi **sama persis** dengan peminjaman:

✅ **uploadPhotoToSupabase()**
- Baca `.env` file langsung (bypass cache)
- Parse `SUPABASE_URL` dan `SUPABASE_SERVICE_ROLE` dari .env
- Generate filename: `userid_timestamp.extension`
- Upload ke bucket `foto-profile`
- Return public URL
- Comprehensive logging untuk debugging

✅ **deletePhotoFromSupabase()**
- Extract filename dari public URL
- Delete dari Supabase
- Graceful error handling (tidak throw exception)

✅ **update() method**
- Validasi file: max 5MB, format (jpeg/png/jpg/gif)
- Handle photo upload sebelum save
- Delete foto lama jika ada
- Save foto_profile URL ke database

### 2. EditProfile View (`resources/views/page/profile/editprofile.blade.php`)
✅ Avatar dengan conditional photo display
✅ "Ganti Foto" button yang trigger file input
✅ Image preview pada file selection
✅ Form dengan `enctype="multipart/form-data"`

### 3. Profile View (`resources/views/page/profile/profile.blade.php`)
✅ Avatar menampilkan foto dari database
✅ Fallback ke icon default jika belum ada

## Testing & Debugging

### Lihat Log Upload
```bash
# Terminal PowerShell
tail -f storage/logs/laravel.log

# Atau buka file
cat storage/logs/laravel.log | Select-String "Supabase photo upload" -A 10
```

### Key Things to Check

1. **SUPABASE_SERVICE_ROLE** di `.env`
   - Harus KEY yang proper, bukan SUPABASE_KEY (anon)
   - Format: `eyJ...` (JWT token panjang)

2. **Bucket Configuration** di Supabase Dashboard
   - Bucket: `foto-profile`
   - Status: PUBLIC
   - Policy: Allow upload & delete

3. **Test Upload File**
   ```bash
   # Buka di browser: http://localhost:8000/editakun
   # Upload file kecil (< 5MB)
   # Check logs untuk response dari Supabase
   ```

### Expected Log Output (Success)
```
[timestamp] local.INFO: Supabase photo upload attempt {"url":"...","file":"123_1700000000.jpg","bucket":"foto-profile",...}
[timestamp] local.INFO: Supabase photo upload response {"status":200,"success":true,"body":"{}"}
[timestamp] local.INFO: Photo uploaded successfully: https://xyz.supabase.co/storage/v1/object/public/foto-profile/123_1700000000.jpg
[timestamp] local.INFO: Photo URL saved to database: https://...
```

### Expected Log Output (Error)
```
[timestamp] local.ERROR: Supabase photo upload error {"error":"Gagal upload file ke Supabase: ...","user_id":123,...}
```

## Pendekatan vs Peminjaman

Sama seperti peminjaman:
- ✅ Baca .env file langsung
- ✅ Parse SERVICE_ROLE key
- ✅ Timeout 60 detik
- ✅ Comprehensive logging
- ✅ Error handling yang graceful
- ✅ Public URL generation

Perbedaan minor:
- Peminjaman: `dokumen_peminjaman/{userid}/{file}`
- Foto Profile: `foto-profile/{userid_timestamp.ext}`

## Jika Masih Error

1. Cek `.env` file punya `SUPABASE_SERVICE_ROLE`
2. Cek bucket `foto-profile` exist dan PUBLIC
3. Cek logs di `storage/logs/laravel.log`
4. Test endpoint `/debug/supabase` (jika ada di routes)
5. Verify permission Supabase bucket allow upload

## Files Modified

1. `app/Http/Controllers/EditakundanHapusakun/AkunController.php` - Update upload/delete logic
2. `resources/views/page/profile/editprofile.blade.php` - UI & form
3. `resources/views/page/profile/profile.blade.php` - Display foto

## Testing Commands

```bash
# Check latest logs
Get-Content storage/logs/laravel.log -Tail 50

# Search for Supabase errors
Select-String "Supabase" storage/logs/laravel.log

# Find photo upload logs
Select-String "photo upload" storage/logs/laravel.log -A 5
```

Everything is ready! Upload seharusnya berjalan. Check logs untuk confirm.

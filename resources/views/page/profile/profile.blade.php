@extends('template-full')

@section('content')
<div class="flex flex-col h-full">
    <!-- Profile Section -->
    <div class="bg-white px-6 pt-16 pb-6 text-center">
        <!-- Avatar -->
        <div class="w-20 h-20 mx-auto mb-3 rounded-full bg-blue-500 flex items-center justify-center overflow-hidden">
            @if($user->foto_profile)
                @php
                    // Handle both old path format and new full URL format
                    if (str_starts_with($user->foto_profile, 'http')) {
                        $photoUrl = $user->foto_profile;
                    } else {
                        // Old format: construct from Supabase base URL
                        $supabaseUrl = rtrim(env('SUPABASE_URL'), '/');
                        $encodedPath = str_replace(' ', '%20', $user->foto_profile);
                        $photoUrl = "{$supabaseUrl}/storage/v1/object/public/{$encodedPath}";
                    }
                @endphp
                <img src="{{ $photoUrl }}" class="w-full h-full object-cover">
            @else
                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                </svg>
            @endif
        </div>

        {{-- Email ITS --}}
        <p class="text-xs text-gray-500 mb-1">
            {{ $user->email_its ?? '-' }}
        </p>

        {{-- Nama --}}
        <h1 class="text-xl font-bold" style="color: #013880;">
            {{ $user->nama ?? '-' }}
        </h1>
    </div>

    <!-- Menu Section -->
    <div class="flex-1 bg-white px-4 py-4">
        <div class="space-y-3">
            <!-- Menu Item: Akun -->
            <a href="{{ route('account.edit') }}"
               class="bg-white rounded-xl p-4 flex items-center justify-between shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center flex-1">
                    <div class="w-11 h-11 rounded-lg bg-gray-100 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5" style="color: #013880;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-bold text-gray-900">Akun</h3>
                        <p class="text-xs text-gray-500">Ganti Password, Edit Data Akun</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5l7 7-7 7"></path>
                </svg>
            </a>

            <!-- Menu Item: Riwayat Peminjaman -->
            <a href="{{ route('riwayat') }}"
               class="bg-white rounded-xl p-4 flex items-center justify-between shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center flex-1">
                    <div class="w-11 h-11 rounded-lg bg-gray-100 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5" style="color: #013880;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-bold text-gray-900">Riwayat Peminjaman</h3>
                        <p class="text-xs text-gray-500">Lihat peminjaman yang sudah selesai</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5l7 7-7 7"></path>
                </svg>
            </a>

            <!-- Menu Item: Keluar -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="button"
                        onclick="confirmLogout()"
                        class="w-full bg-white rounded-xl p-4 flex items-center justify-between shadow-sm hover:shadow-md transition-shadow text-left">
                    <div class="flex items-center flex-1">
                        <div class="w-11 h-11 rounded-lg bg-red-50 flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-bold text-gray-900">Keluar</h3>
                            <p class="text-xs text-gray-500">Keluar dari akun</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Bottom Navigation -->
    @if(Auth::check() && Auth::user()->is_admin)
        <x-navbar-admin active="profile" />
    @else
        <x-navbar active="profile" />
    @endif
</div>

<script>
    function confirmLogout() {
        if (confirm('Apakah Anda yakin ingin keluar?')) {
            document.getElementById('logout-form').submit();
        }
    }
</script>
@endsection

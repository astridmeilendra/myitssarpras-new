{{-- Navbar Component - view/components/navbar.blade.php --}}
@props(['active' => 'home'])

<!-- Bottom Navigation -->
<div class="bg-white border-t border-gray-100 px-6 py-3">
    <div class="flex items-center justify-around">
        <!-- Home -->
        <a href="{{ route('home') }}" class="bottom-item flex flex-col items-center gap-1 {{ $active === 'home' ? 'text-[#013880]' : 'text-gray-400 hover:text-[#013880]' }} transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="text-xs font-medium">Home</span>
        </a>

        <!-- Riwayat -->
        <a href="{{ route('riwayat') }}" class="bottom-item flex flex-col items-center gap-1 {{ $active === 'riwayat' ? 'text-[#013880]' : 'text-gray-400 hover:text-[#013880]' }} transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-xs font-medium">Riwayat</span>
        </a>

        <!-- Search -->
        <a href="{{ route('search') }}" class="bottom-item flex flex-col items-center gap-1 {{ $active === 'search' ? 'text-[#013880]' : 'text-gray-400 hover:text-[#013880]' }} transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                </path>
            </svg>
            <span class="text-xs font-medium">Search</span>
        </a>

        <!-- Info -->
        <a href="{{ route('info') }}" class="bottom-item flex flex-col items-center gap-1 {{ $active === 'info' ? 'text-[#013880]' : 'text-gray-400 hover:text-[#013880]' }} transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"></path>
            </svg>
            <span class="text-xs font-medium">Info</span>
        </a>

        <!-- Profile -->
        <a href="{{ route('profile') }}" class="bottom-item flex flex-col items-center gap-1 {{ $active === 'profile' ? 'text-[#013880]' : 'text-gray-400 hover:text-[#013880]' }} transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="text-xs font-medium">Profile</span>
        </a>
    </div>
</div>

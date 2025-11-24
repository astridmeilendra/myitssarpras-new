{{-- Navbar Admin Component --}}
@props(['active' => 'dashboard'])

<!-- Bottom Navigation -->
<div class="bg-white border-t border-gray-100 px-6 py-3">
    <div class="flex items-center justify-around">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="bottom-item flex flex-col items-center gap-1 {{ $active === 'dashboard' ? 'text-[#013880]' : 'text-gray-400 hover:text-[#013880]' }} transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="text-xs font-medium">Dashboard</span>
        </a>

        <!-- Ruangan -->
        <a href="{{ route('admin.ruangan.index') }}" class="bottom-item flex flex-col items-center gap-1 {{ $active === 'ruangan' ? 'text-[#013880]' : 'text-gray-400 hover:text-[#013880]' }} transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m-1 4h1m4-4h1m-1 4h1m-1-9h1"></path>
            </svg>
            <span class="text-xs font-medium">Ruangan</span>
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

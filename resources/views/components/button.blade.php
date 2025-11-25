@props([
    'as' => 'button',          // 'button' | 'a'
    'href' => null,            // jika as='a'
    'type' => 'button',        // submit|button|reset (untuk <button>)
    'variant' => 'primary',    // primary | solid | outline | ghost
    'size' => 'md',            // sm | md | lg
    'full' => false,           // true => w-full
    'disabled' => false,
    'loading' => false,
])

@php
    $base = 'inline-flex items-center justify-center rounded-lg font-semibold tracking-[0.01em]
             transition disabled:opacity-50 disabled:pointer-events-none';

    $sizes = [
        'xs' => 'h-7 px-3 text-xs', // New extra small size
        'sm' => 'h-9 px-4 text-sm',
        'md' => 'h-11 px-5 text-base',
        'lg' => 'h-12 px-6 text-lg',
    ];

    $variants = [
        // Sesuai contoh screenshot: white card di atas bg biru
        'primary' => 'bg-white text-[#013880] hover:bg-blue-50 active:bg-blue-100 focus:ring-blue-300',
        'solid'   => 'bg-[#013880] text-white hover:bg-[#013880]/90 active:bg-[#013880]/80 focus:ring-[#013880]',
        'outline' => 'border border-white text-white hover:text-[#013880] hover:bg-white focus:ring-white',
        'ghost'   => 'text-blue-700 hover:bg-blue-50 focus:ring-blue-300',
    ];

    $cls = trim($base.' '.($sizes[$size] ?? $sizes['md']).' '.($variants[$variant] ?? $variants['primary']).' '.($full ? 'w-full' : ''));
@endphp

@if(($as === 'a') || $href)
    <a href="{{ $href ?? '#' }}" {{ $attributes->merge(['class' => $cls, 'aria-busy' => $loading ? 'true' : 'false']) }}>
        @isset($icon)
            <span class="-ml-1 mr-2 inline-flex">{!! $icon !!}</span>
        @endisset

        <span class="{{ $loading ? 'opacity-0' : '' }}">{{ $slot }}</span>

        @if($loading)
            <svg class="absolute animate-spin h-5 w-5" viewBox="0 0 24 24" fill="none">
                <circle class="opacity-25" cx="6" cy="6" r="10" stroke="currentColor" stroke-width="1"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge([
            'class' => $cls.' relative',
            'disabled' => $disabled || $loading,
            'aria-busy' => $loading ? 'true' : 'false'
        ]) }}>
        @isset($icon)
            <span class="-ml-1 mr-2 inline-flex">{!! $icon !!}</span>
        @endisset

        <span class="{{ $loading ? 'opacity-0' : '' }}">{{ $slot }}</span>

        @if($loading)
            <svg class="absolute animate-spin h-5 w-5" viewBox="0 0 24 24" fill="none">
                <circle class="opacity-25" cx="6" cy="6" r="10" stroke="currentColor" stroke-width="1"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
        @endif
    </button>
@endif

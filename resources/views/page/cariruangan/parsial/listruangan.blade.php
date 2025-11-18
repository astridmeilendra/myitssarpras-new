<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
    <div class="flex gap-4 p-4">
        <div class="flex-shrink-0">
            <img 
                src="{{ $room->image ?? asset('img/tw-201.png') }}" 
                alt="{{ $room->name }}" 
                class="w-[120px] h-[120px] rounded-xl object-cover"
            >
        </div>
        
        <div class="flex-1 flex flex-col justify-between py-1">
            <div>
                <p class="text-xs font-medium text-gray-500 mb-1">Room</p>
                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $room->name }}</h3>
                <p class="text-xs text-gray-600 leading-relaxed line-clamp-3">
                    {{ $room->description ?? '' }}
                </p>
            </div>

            <div class="flex flex-wrap gap-2 mt-3 text-xs text-gray-700">
                <div class="flex items-center gap-1">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                    </svg>
                    <span>{{ $room->facilities ?? '-' }}</span>
                </div>
                <div class="flex items-center gap-1">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>{{ $room->capacity ?? '0' }} Orang</span>
                </div>
                @if($room->price)
                    <div class="flex items-center gap-1">
                        <span>{{ $room->price }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

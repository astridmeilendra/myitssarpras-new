@extends('template-full')

@section('content')
<div class="flex flex-col h-full relative bg-white">
    {{-- Header + Search --}}
    @include('page.cariruangan.parsial.searchbar')

    {{-- Chip filter yang sudah diterapkan --}}
    @include('page.cariruangan.parsial.filteraktifcariruangan')

    {{-- Content / list ruangan --}}
    <div class="flex flex-col p-6 overflow-y-auto">
        <h2 class="text-sm font-semibold text-gray-500 mb-4">Pencarian Cepat</h2>

        <div class="space-y-4" id="roomList">
            @foreach ($rooms as $room)
                @include('page.cariruangan.parsial.listruangan', ['room' => $room])
            @endforeach
        </div>
    </div>

    {{-- Panel filter (slide dari atas) --}}
    @include('page.cariruangan.parsial.filterpanel')

    {{-- Bottom navigation --}}
    @include('components.navbar')
</div>
@endsection

@section('scripts')
    @include('page.cariruangan.parsial.scripts')
@endsection

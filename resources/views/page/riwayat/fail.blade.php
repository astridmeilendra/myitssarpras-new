@extends('template-full')

@section('content')
<div class="flex flex-col h-full w-full items-center justify-center bg-[#8C1515] relative">
    {{-- Background key image --}}
    <img src="/img/success/key-background.png" alt="key"
         class="absolute inset-0 mx-auto my-auto pointer-events-none" />

    {{-- Content --}}
    <div class="flex flex-col items-center justify-center z-10">
        {{-- Icon X / gagal --}}
        <img src="/img/fail.png" alt="failed" />
    </div>
</div>
@endsection

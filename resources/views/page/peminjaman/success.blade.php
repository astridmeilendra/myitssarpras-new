@extends('template-full')

@section('content')
<div class="flex flex-col h-full w-full items-center justify-center bg-[#013880]">
    <img src="/img/success/key-background.png" alt="key"
        class="absolute pointer-events-none" />
    <div class="flex flex-col items-center justify-center">
        <img src="/img/success/success.png" alt="key" />
        <div class="flex flex-col items-center justify-center mt-6">
            <p class="text-md text-white">Permintaan</p>
            <p class="text-md font-bold text-white">Berhasil Dikirim!</p>
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        window.location.href = "/home";
    }, 3000);
</script>
@endsection

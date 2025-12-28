@extends('template-full')

@section('content')

{{-- Imanuel Dwi Prasetyo 5026231114 --}}

{{-- Tampilan Sukses Full Screen --}}
<div class="flex flex-col h-full w-full items-center justify-center bg-[#013880]">
    {{-- Background Image --}}
    <img src="/img/success/key-background.png" alt="bg"
        class="absolute pointer-events-none opacity-50" />
    
    <div class="flex flex-col items-center justify-center z-10">
        {{-- Icon Success (Pastikan file ini ada di public/img/success/) --}}
        <img src="/img/success/success.png" alt="success icon" class="w-24 h-24 mb-4" />
        
        <div class="flex flex-col items-center justify-center text-center">
            <p class="text-lg text-white font-medium">Pertanyaan Anda</p>
            <p class="text-2xl font-bold text-white tracking-wide">Berhasil Dikirim!</p>
        </div>
    </div>
</div>

<script>
    // Redirect otomatis setelah 3 detik (3000 ms)
    setTimeout(function() {
        // Kembali ke halaman kirim pertanyaan
        window.location.href = "{{ route('kirim-pertanyaan') }}";
    }, 3000);
</script>
@endsection
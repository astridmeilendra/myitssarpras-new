@extends('template-full')

@section('content')
<div class="w-full h-full flex items-center justify-center">
  <div class="relative w-full h-[854px] rounded-xl overflow-hidden">
      <img src="{{ asset('img/its-background.png') }}"
           class="absolute inset-0 h-full w-full object-cover" alt="ITS background">
      <div class="absolute inset-0 bg-[#0B4EA2]/85"></div>

      <div class="relative z-10 flex h-full w-full items-center justify-center p-6">
          <div class="w-full h-full flex flex-col justify-center items-center">
              <div class="flex flex-col items-center w-full h-full justify-center mb-8 gap-6">
                  <img src="{{ asset('img/myits-sarpras-white.png') }}" class="w-40 md:w-44 drop-shadow" alt="Logo">
                  <div class="flex flex-col w-full">
                      <x-button variant="primary" size="md" :full="true" class="mt-3">Login</x-button>
                      <x-button variant="outline" size="md" :full="true" class="mt-3">Sign Up</x-button>
                  </div>
              </div>

              <p class="text-white text-sm">MyITS Sarpras Versi 1.0</p>
          </div>
      </div>
  </div>
</div>
@endsection

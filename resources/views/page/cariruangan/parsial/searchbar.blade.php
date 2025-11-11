<div class="bg-white px-6 pt-5">
    <h1 class="text-2xl font-extrabold text-[#013880] mb-4 text-center tracking-wide">
        Cari Ruangan
    </h1>

    <div class="relative flex items-center w-full max-w-2xl mx-auto border border-[#013880] rounded-lg">
        <input 
            type="text" 
            placeholder="Masukkan nama ruangan..." 
            class="w-full pl-10 pr-12 py-3 bg-white rounded-lg text-sm text-gray-700 placeholder-gray-400 focus:outline-none"
            id="searchInput"
        >
        <!-- Icon Search -->
        <svg class="w-5 h-5 absolute left-3 text-[#013880]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>

        <!-- Tombol Filter -->
        <button id="filterButton" class="absolute right-3 p-2 rounded-lg hover:bg-gray-100 transition-colors" title="Filter">
            <svg class="w-5 h-5 text-[#013880]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
        </button>
    </div>
</div>

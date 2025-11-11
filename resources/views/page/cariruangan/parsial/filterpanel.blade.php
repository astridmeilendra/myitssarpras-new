<div id="filterPanel" class="absolute top-0 left-0 right-0 bg-white shadow-lg z-50 transform -translate-y-full transition-transform duration-300 ease-out overflow-hidden">
    <div class="flex flex-col max-h-screen">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-white">
            <button id="closeFilter" class="p-1 hover:bg-gray-100 rounded-full transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <h2 class="text-base font-bold text-gray-900">Filter</h2>
            <div class="w-6"></div>
        </div>

        <!-- Content -->
        <div class="flex-1 overflow-y-auto px-6 py-5 space-y-5">
            <!-- Tanggal -->
            <div>
                <label class="flex items-center gap-2 text-sm font-semibold text-gray-800 mb-2">
                    <span>Tanggal</span>
                </label>
                <input type="date" id="filterDate" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
            </div>

            <!-- Waktu -->
            <div>
                <label class="flex items-center gap-2 text-sm font-semibold text-gray-800 mb-2">
                    <span>Waktu</span>
                </label>
                <select id="filterTime" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    <option value="">Pilih waktu</option>
                    <option value="07.00 - 10.00">Sesi 1 (07.00 - 10.00)</option>
                    <option value="10.15 - 12.45">Sesi 2 (10.15 - 12.45)</option>
                    <option value="13.30 - 16.00">Sesi 3 (13.30 - 16.00)</option>
                    <option value="16.00 - 18.30">Sesi 4 (16.00 - 18.30)</option>
                </select>
            </div>

            <!-- Kapasitas -->
            <div>
                <label class="flex items-center gap-2 text-sm font-semibold text-gray-800 mb-2">
                    <span>Kapasitas</span>
                </label>
                <input type="text" id="filterCapacity" placeholder="150 Orang" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
            </div>

            <!-- Harga -->
            <div>
                <label class="flex items-center gap-2 text-sm font-semibold text-gray-800 mb-2">
                    <span>Harga</span>
                </label>
                <input type="text" id="filterPrice" placeholder="Rp150.000" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
            </div>

            <!-- Fasilitas -->
            <div>
                <label class="flex items-center gap-2 text-sm font-semibold text-gray-800 mb-3">
                    <span>Fasilitas</span>
                </label>

                <div class="space-y-2.5">
                    <div class="grid grid-cols-3 gap-3">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="facility[]" value="ac" class="w-4 h-4 text-blue-600">
                            <span class="text-xs text-gray-700">AC</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="facility[]" value="speaker" class="w-4 h-4 text-blue-600">
                            <span class="text-xs text-gray-700">Speaker</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="facility[]" value="remote" class="w-4 h-4 text-blue-600">
                            <span class="text-xs text-gray-700">Remote</span>
                        </label>
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="facility[]" value="layar" class="w-4 h-4 text-blue-600">
                            <span class="text-xs text-gray-700">Layar</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="facility[]" value="mic" class="w-4 h-4 text-blue-600">
                            <span class="text-xs text-gray-700">Mic</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="facility[]" value="smart-tv" class="w-4 h-4 text-blue-600">
                            <span class="text-xs text-gray-700">Smart TV</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 border-t border-gray-200 bg-white">
            <button id="applyFilter" class="w-full bg-[#013880] text-white py-2.5 rounded-lg font-medium">
                Terapkan Filter
            </button>
        </div>
    </div>
</div>

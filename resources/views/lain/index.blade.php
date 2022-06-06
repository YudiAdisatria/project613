<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lain - Lain') }}
        </h2>
    </x-slot>

    <section class="pt-8 pb-8 bg-gray-200">
        <div class="flex flex-wrap justify-center">
            <div class="w-full px-4 lg:w-1/2 xl:w-1/3">
                <div class="bg-blue-600 rounded-xl shadow-lg overflow-hidden mb-10">
                    <div class="py-8 px-6">
                        <h3 class="mb-3 font-bold text-xl text-white text-center">Histori Aset</h3>
                        <p class="tracking-tight font-medium text-base text-white mb-6 text-justify">Melihat histori pergerakan aset</p>
                        <p class="text-center"><a href="{{ route('histories.index') }}" class="items-center font-bold text-sm text-dark bg-teal-300 py-2 px-4 rounded-lg hover:opacity-80 mr-50">Lihat Disini</a></p>
                    </div>
                </div>
            </div>

            <!-- <div class="w-full px-4 lg:w-1/2 xl:w-1/3">
                <div class="bg-blue-600 rounded-xl shadow-lg overflow-hidden mb-10">
                    <div class="py-8 px-6">
                        <h3 class="mb-3 font-semibold text-xl text-white text-center">Laporan Ruangan</h3>
                        <p class="tracking-tight font-medium text-base text-white mb-6 text-justify">Terdapat di dalam menu ruangan di bawah search</p>
                        <p class="text-center"><a href="pindah_web.html" class="items-center font-bold text-sm text-dark bg-teal-300 py-2 px-4 rounded-lg hover:opacity-80 mr-50">Laporan Ruangan</a></p>
                    </div>
                </div>
            </div> -->

        </div>

        <!-- Filter Report -->
        <div class="flex flex-wrap justify-center">
            <!-- Filter History -->
            <label for="tanggal">Pilih Bulan laporan untuk History Perpindahan:</label>
            <form action="{{ route('histories.export') }}" class="flex flex-wrap mb-5">
                <input type="month" id="tanggal" name="tanggal" min="2018-03">
                <button type="submit" class="bg-black text-white py-1 px-3 border border-black hover:border-white rounded">
                    Laporan Perpindahan
                </button>
            </form>
            
            <!-- Filter List Aset -->
            <div class="overflow-auto shadow hidden md:block">
                <div class="flex flex-wrap">
                    <div class="w-full self-center px-4 lg:w-1/2">
                    </div>
                </div>
                <form action="{{ route('ruangans.export') }}" class="flex flex-wrap mb-5">
                    {{-- <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                        Filter Laporan
                    </label> --}}
                    <select name="id_kategori" class=" mr-24 mb-3 md:mb-0 text-black bg-white hover:bg-gray-100 font-medium text-sm px-12 py-2.5 text-center inline-flex items-center" id="grid-last-name">
                        <option value="" selected>Kategori</option>
                        @forelse ($kategori as $kat)
                            <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                        @empty
                            <p>tidak ada kategori</p>
                        @endforelse
                    </select>

                    <select name="gedung" id="gedung" class="mr-20 mb-3 md:mb-0 text-black bg-white hover:bg-gray-100 font-medium text-sm px-12 py-2.5 text-center inline-flex items-center" id="grid-last-name">
                        <option value="" selected>Gedung</option>
                        @foreach($ruangan as $key => $value)
                            <option value="{{ $key }}">{{ $key }}</option>
                        @endforeach
                    </select>

                    <select name="ruangan" id="ruangan" class="mr-12 mb-3 md:mb-0 text-black bg-white hover:bg-gray-100 font-medium text-sm px-12 py-2.5 text-center inline-flex items-center" id="grid-last-name">
                        <option value="" selected>Ruangan</option>
                    </select>

                    <select name="kondisi" class="mr-12 mb-3 md:mb-0 text-black bg-white hover:bg-gray-100 font-medium text-sm px-12 py-2.5 text-center inline-flex items-center" id="grid-last-name">
                        <option value="" selected>Kondisi</option>
                        <option value="baik">Baik</option>
                        <option value="rusak">Rusak</option>
                        <option value="hilang">Hilang</option>
                    </select>

                    <button type="submit" class="bg-black text-white py-1 px-3 border border-black hover:border-white rounded">
                        Laporan Ruangan
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>

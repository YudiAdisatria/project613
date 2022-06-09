<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                @if($errors->any())
                <div class="mb-5" role="alert">
                    <div class="bg-red-500 text-white font-bold rounded">
                        There's Something Wrong
                    </div>
                    <div class="border border-t-0 border-red-400 rounded bg-red-100 px-4 py-3 text-red-700">
                        <p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </p>
                    </div>
                </div>
                @endif

                <section class="pt-8 pb-8">
                    <div class="container">
                        <div class="w-full px-4">
                            <div class="max-w-xl mx-auto text-center mb-16">
                                <h2 class="font-bold text-3xl text-blue-700 mb-4 sm:text-4xl lg:text-5xl">Aset Gereja Atmodirono</h2>
                            </div>
                        </div>

                        <div class="flex flex-wrap">
                        
                            <div class="w-full self-end px-5 lg:w-1/2">
                                <div class="relative mt-5  mb-10 lg:mt-0">
                                    <img src="{{ $item->foto_aset }}" alt="Foto tidak tersedia" class="w-96 h-80"/>
                                </div>
                            </div>

                            <div class="w-full self-center px-4 lg:w-1/2">
                                <div class="flex flex-wrap">
                                    <div class="w-full self-end px-5 lg:w-1/2">
                                        <div class="w-full px-0 mb-8">
                                            <label for="kodebarang" class="text-base font-bold text-blue-700">ID Aset</label>
                                            <p type="text" id="kodebarang" class="w-full bg-white text-dark p-3 rounded-md focus:outline-none focus:ring-blue-700 focus:border-blue-700" >{{ $item->id_aset }}</p>
                                        </div>
                                    </div>

                                    <div class="w-full self-end px-5 lg:w-1/2">
                                        <div class="w-full px-0 mb-8">
                                            <label for="kategori" class="text-base font-bold text-blue-700">Kategori</label>
                                            <p type="text" id="kodebarang" class="w-full bg-white text-dark p-3 rounded-md focus:outline-none focus:ring-blue-700 focus:border-blue-700" >{{ $item->kategori->nama_kategori }}</p>
                                        </div>
                                    </div>
                                </div>
                            

                                <div class="w-full px-4 mb-8">
                                    <label for="namabarang" class="text-base font-bold text-blue-700">Nama Barang</label>
                                    <p type="text" id="kodebarang" class="w-full bg-white text-dark p-3 rounded-md focus:outline-none focus:ring-blue-700 focus:border-blue-700" >{{ $item->nama_aset }}</p>
                                </div>

                                <div class="w-full px-4 mb-8">
                                    <label for="Lokasi" class="block text-base font-bold text-blue-700">Lokasi</label>
                                    <div class="mt-1">
                                        <p type="text" id="kodebarang" class="w-full bg-white text-dark p-3 rounded-md focus:outline-none focus:ring-blue-700 focus:border-blue-700" >{{ $item->gedung }}, {{ $item->ruangan }}</p>
                                    </div>
                                </div>

                                <div class="w-full px-4">
                                    <button class="text-base font-semibold text-white bg-blue-800 py-3 px-8 rounded-full w-full">
                                        <a href="{{ route('asets.edit', $item->id_aset) }}">Pindah</a>    
                                    </button>
                                </div>
                            </div>
            
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>

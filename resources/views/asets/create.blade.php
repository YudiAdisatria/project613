<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {!!__('Aset &raquo; Create') !!}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <!--Error-->
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
                <!--Error-->
                
                <form action="{{ route('asets.store') }}" class="w-full" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input value="000" name="id_aset" class="appearance-none block w-full bg-white text-gray-700 border border-gray-100 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="hidden" placeholder="id_aset" required>

                    <div class="flex flex-wrap"> 
                        <div class="w-full  self-center mt-2 px-3 lg:w-1/2">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                Kategori
                            </label>
                            <select name="id_kategori" class="appearance-none block w-full bg-white text-gray-700 border border-gray-100 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name">
                                @forelse ($kategori as $item)
                                    <option value="{{ $item->id_kategori }}">{{ $item->id_kategori }} - {{ $item->nama_kategori }}</option>
                                @empty
                                    <p>tidak ada kategori</p>
                                @endforelse
                                
                            </select>
                        </div>
                        

                        <div class="w-full px-3 mt-2 self-end lg:w-1/2">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                nama aset
                            </label>
                            <input value="{{ old('nama_aset') }}" name="nama_aset" class="appearance-none block w-full bg-white text-gray-700 border border-gray-100 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Nama Aset" required>
                        </div>
                        
                    </div>

                    <div class="flex flex-wrap">
                        <div class="w-full  self-center mt-2 px-3 lg:w-1/2">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                Gedung
                            </label>
                            <select name="gedung" id="gedung" class="appearance-none block w-full bg-white text-gray-700 border border-gray-100 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option label>Pilih Gedung</option>
                                @foreach($ruangan as $key => $value)
                                    <option value="{{ $key }}">{{ $key }}</option>
                                @endforeach
                            </select>
                        </div>
                        

                        
                        <div class="w-full  self-center mt-2 px-3 lg:w-1/2">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                Ruangan
                            </label>
                            <select name="ruangan" id="ruangan" placeholder="Pilih Ruangan" class="appearance-none block w-full bg-white text-gray-700 border border-gray-100 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">

                            </select>
                        </div>   
                    </div>

                    <div  class="flex flex-wrap">

                        <div class="w-full  self-center mt-2 px-3 lg:w-1/2">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                Harga beli
                            </label>
                            <input value="{{ old('harga_beli') }}" name="harga_beli" class="appearance-none block w-full bg-white text-gray-700 border border-gray-100 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="number" min="0" placeholder="harga beli" required>
                        </div>

                        <div class="w-full  self-center mt-2 px-3 lg:w-1/2">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                Kondisi
                            </label>
                            <select name="kondisi" class="appearance-none block w-full bg-white text-gray-700 border border-gray-100 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name">
                                <option value="baik">Baik</option>
                                <option value="rusak">Rusak</option>
                            </select>
                        </div>

                    </div>
                    

                    <div class="flex flex-wrap mt-2">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                Keterangan
                            </label>
                            <p class="text-dark text-xs">isi dengan - apabila tidak ada keterangan</p>
                            <input value="{{ old('keterangan') }}" name="keterangan" class="appearance-none block w-full bg-white text-gray-700 border border-gray-100 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Keterangan" required>
                        </div>
                    </div>

                    <div class="flex flex-wrap mt-2">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                Foto
                            </label>
                            <p class="text-dark text-xs">Ukuran maksimal 2 MB</p>
                            <input name="foto_aset" id="foto_aset" class="appearance-none block w-full bg-white text-gray-700 border border-gray-100 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="file" placeholder="Foto" accept="image/*" required>
                        </div>
                    </div>

                    <div class="flex flex-wrap mt-10 ">
                        <div class="w-full px-3 text-right">
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Save aset
                            </button>
                        </div>
                    </div>
                
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

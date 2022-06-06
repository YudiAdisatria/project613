<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Aset') }}
        </h2>
    </x-slot>

    <section class="pt-8 pb-8 bg-gray-200">
        <div class="container relative">
            @can('manage-user')
            <button class="bg-green-500 hover:bg-white text-white font-bold hover:text-green-500 py-1 px-3 border border-transparent hover:border-green-500 rounded mb-5" >
                <a href="{{ route('asets.create') }}">Tambah Aset</a>
            </button>
            @endcan
            <div class="flex flex-wrap">
                <div class="w-full self-center px-4 lg:w-1/2">
                    <h1 class="text-2xl font-bold mb-2 mr-3">List Aset</h1>
                </div>
                <div class="self-end px-2 lg:w-1/2">
                    <form action="{{ route('asets.index') }}" class="mb-3 flex">
                        <input type="text" placeholder="Search ..." name=search class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md py-2 pl-9 pr-3 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm mr-4">
                        <button type="submit" class="bg-black text-white py-1 px-3 border border-black hover:border-white rounded">
                            search
                        </button>
                    </form>
                </div>
            </div>

            <!-- Filter custom -->
            <div class="overflow-auto hidden md:block">
                <form action="{{ route('asets.index') }}" class="flex flex-wrap mb-5">
                    {{-- <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                        Filter
                    </label> --}}
                    <input type="hidden" name="filter" value="1">
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
                        Apply Filter
                    </button>
                </form>
            </div>

            <p>Total Aset dalam pencarian : {{ $aset->total() }}</p>
            <div class="overflow-auto rounded-lg shadow hidden md:block">
                <table class="w-full" id="myTable" data-filter-control="true" data-show-search-clear-button="true">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">ID Aset</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">Nama Aset</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">Kategori</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">Lokasi</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">Kondisi</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($aset as $item)
                        <tr class="odd:bg-white even:bg-slate-100">
                            <td class="p-3 text-sm text-blue-500 font-bold "><a href="{{ route('asets.qr', $item->id_aset ) }}">{{ $item->id_aset }}</a></td>
                            <td><a href="{{ route('asets.show', $item->id_aset ) }}">{{ $item->nama_aset }}</a></td>
                            <td>{{ $item->kategori->nama_kategori }}</td>
                            <td>{{ $item->gedung }}, {{ $item->ruangan }}</td>
                            <td>{{ $item->kondisi }}</td>
                            <td class="text-sm">
                                <button type="submit" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-3 border border-blue-500 hover:border-transparent rounded mb-1">
                                    <a href="{{ route('asets.edit', $item->id_aset) }}">Pindah</a>
                                </button>

                                @can('manage-user')
                                <form action="/dashboard/asets/{{$item->id_aset}}/jual" method="POST" class="inline-block">
                                    {!! method_field('get') . csrf_field() !!} 
                                    <button type="submit" class="bg-transparent hover:bg-red-600 text-red-500 font-semibold hover:text-white py-1 px-5  border border-red-600 hover:border-transparent rounded">
                                        Jual
                                    </button>
                                </form>  
                                @endcan
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>

                <!-- small -->
                <!-- filter small -->
                <div class="bg-gray-200">
                    <form action="{{ route('asets.index') }}" class="flex flex-wrap mb-5">
                        <div class="flex flex-wrap md:hidden">

                            <div class="w-1/2  mt-2 px-3 ">
                                    {{-- <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                    Filter
                                </label> --}}
                                <input type="hidden" name="filter" value="1">
                                <select name="id_kategori" class=" mr-24 mb-3 md:mb-0 text-black bg-white hover:bg-gray-100 font-medium text-sm px-12 py-2.5 text-center inline-flex items-center" id="grid-last-name">
                                    <option value="" selected>Kategori</option>
                                    @forelse ($kategori as $kat)
                                        <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                                    @empty
                                        <p>tidak ada kategori</p>
                                    @endforelse
                                </select>
                            </div>

                            <div class="w-1/2 mt-2 px-3 ">
                                <select name="gedung" id="gedung" class="mr-20 mb-3 md:mb-0 text-black bg-white hover:bg-gray-100 font-medium text-sm px-12 py-2.5 text-center inline-flex items-center" id="grid-last-name">
                                    <option value="" selected>Gedung</option>
                                    @foreach($ruangan as $key => $value)
                                        <option value="{{ $key }}">{{ $key }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-wrap md:hidden">
                            <div class="w-1/2  mt-2 px-3 ">
                                <select name="ruangan" id="ruangan" class="mr-12 mb-3 md:mb-0 text-black bg-white hover:bg-gray-100 font-medium text-sm px-12 py-2.5 text-center inline-flex items-center" id="grid-last-name">
                                    <option value="" selected>Ruangan</option>
                                </select>
                            </div>

                            <div class="w-1/2 mt-2 px-3 ">
                                <select name="kondisi" class="mr-12 mb-3 md:mb-0 text-black bg-white hover:bg-gray-100 font-medium text-sm px-12 py-2.5 text-center inline-flex items-center" id="grid-last-name">
                                    <option value="" selected>Kondisi</option>
                                    <option value="baik">Baik</option>
                                    <option value="rusak">Rusak</option>
                                    <option value="hilang">Hilang</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-2 px-3 justify-center items-center text-center md:hidden">
                            <button type="submit" class="bg-black text-white py-1 px-3 border border-black hover:border-white rounded justify-center items-start text-center">
                                Apply Filter
                            </button>
                        </div>
                        </div>
                    </form>  
                </div>                      
            <!-- Item small -->
            @forelse ($aset as $item)
            <div class="bg-gray-200">
                <div class="grid grid-cols-1 gap-4 md:hidden">
                    <div class="bg-white p-4 rounded-lg shadow mb-5">
                        <div class= "flex justify-center space-x-2 text-sm">
                            <div class="p-3 text-sm text-blue-700 font-bold text-center ">{{ $item->id_aset }}</div>
                            <div class=" font-semibold p-3 text-sm text-black text-center">{{ $item->nama_aset }}</div>
                        </div>

                        <div class="flex justify-center items-center text-sm text-center">
                            <div class=" font-semibold p-3 text-sm text-black text-center">{{ $item->kategori->nama_kategori }}</div>
                        </div>

                        <div class="flex justify-center items-center text-sm text-center">
                            <div class=" font-semibold p-3 text-sm text-black text-center">{{ $item->gedung }}, {{ $item->ruangan }}</div>
                        </div>

                        <div class="flex justify-center items-center space-x-2 text-sm">
                            <div class=" font-semibold p-3 text-sm text-black">{{ $item->kondisi }}</div>
                        </div>

                        <div class="flex items-center space-x-2 text-sm justify-center">
                            <div class="text-sm text-black">
                                <button type="submit" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-3 border border-blue-500 hover:border-transparent rounded mb-1"> 
                                    <a href="{{ route('asets.edit', $item->id_aset) }}">
                                    Pindah</button></a>

                                    @can('manage-user')
                                    <form action="/dashboard/asets/{{$item->id_aset}}/jual" method="POST" class="inline-block">
                                        {!! method_field('get') . csrf_field() !!} 
                                        <button type="submit" class="bg-transparent hover:bg-red-600 text-red-500 font-semibold hover:text-white py-1 px-5  border border-red-600 hover:border-transparent rounded">
                                            Jual
                                        </button>
                                    </form>   
                                    @endcan               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            @endforelse
            <!-- small stop -->
            <p class="pt-4"></p>
            {{ $aset->links() }}
        </div>
    </section>
</x-app-layout>

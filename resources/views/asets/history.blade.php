<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Aset') }}
        </h2>
    </x-slot>

    <section class=" bg-gray-200 pt-36 pb-36">
        <div class="container relative">
            <div class="self-end px-2 text-right mb-2">
                <p class="text-xs">untuk nama pemindah gunakan nomor HP pemindah </p>
            </div>
            
            <div class="flex flex-wrap">
                <div class="w-full self-center px-4 lg:w-1/2">
                    <h1 class="text-2xl font-bold mb-2 mr-3">List History</h1>
                </div>
                <div class="self-end px-2 lg:w-1/2">
                    <form action="{{ route('histories.index') }}" class="mb-3 flex">
                        <input type="text" placeholder="Search ..." name=search class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md py-2 pl-9 pr-3 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm mr-4">
                        <button type="submit" class="bg-black text-white py-1 px-3 border border-black hover:border-white rounded">
                            search
                        </button>
                    </form>
                </div>
            </div>



            <div class="overflow-auto rounded-lg shadow hidden md:block">
                <table class="w-full" id="myTable" data-filter-control="true" data-show-search-clear-button="true">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">ID History</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">ID Aset</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">Pemindah</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">Lokasi Lama</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">Lokasi Baru</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($items as $item)
                        <tr class="odd:bg-white even:bg-slate-100">
                            <td class="p-3 text-sm text-blue-500 font-bold ">{{ $item->id_history }}</td>
                            <td>{{ $item->id_aset }}</td>
                            <td>{{ $item->user->nama }}</td>
                            <td>{{ $item->lokasi_lama }}</td>
                            <td>{{ $item->lokasi_baru }}</td>
                            {{-- <td>                            
                                <button type="submit" disable class="bg-transparent  text-blue-700 font-semibold  py-1 px-3 border border-blue-500  rounded mb-1">
                                    <a href="#">{{ $item->jenis_pindah }}</a>
                                </button>
                            </td> --}}
                            <td>
                                @if ($item->jenis_pindah === "PINDAH")
                                <span class=" text-white font-semibold  py-1 px-3 border bg-blue-500 border-blue-500 rounded mb-1">{{ $item->jenis_pindah }}
                                </span>
                                @else
                                <span class="bg-red-500 text-white font-semibold  py-1 px-6 border border-red-500 rounded mb-1">{{ $item->jenis_pindah }}
                                </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>

                <!-- small -->
            @forelse ($items as $item)
        
            <div class="grid grid-cols-1 gap-4 md:hidden">
                <div class="bg-white p-4 rounded-lg shadow mb-5">
                    <div class= "flex justify-center space-x-2 text-sm">
                        <div class="p-3 text-sm text-blue-700 font-bold text-center ">{{ $item->id_history }}</div>
                        <div class=" font-semibold p-3 text-sm text-black text-center">{{ $item->id_aset }}</div>
                    </div>

                    <div class="flex justify-center items-center text-sm text-center">
                        <div class=" font-semibold p-3 text-sm text-black text-center">{{ $item->user->nama }}</div>
                    </div>

                    <div class="flex justify-center items-center text-sm text-center">
                        <div class=" font-semibold p-3 text-sm text-black text-center">{{ $item->lokasi_lama }}</div>
                    </div>

                    <div class="flex justify-center items-center space-x-2 text-sm">
                        <div class=" font-semibold p-3 text-sm text-black">{{ $item->lokasi_baru }}</div>
                    </div>

                    <div class="flex items-center space-x-2 text-sm justify-center">
                        <div class="text-sm text-black">
                            @if ($item->jenis_pindah === "PINDAH")
                            <div class="bg-blue-500  text-white font-semibold  py-1 px-3 border border-blue-500 rounded">
                                {{ $item->jenis_pindah }}
                            </div>
                            @else
                                <div class="bg-red-500  text-white font-semibold  py-1 px-6 border border-red-500 rounded">{{ $item->jenis_pindah }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>     
            
            @empty
            @endforelse
            <!-- small stop -->
            <p class="pt-4"></p>
            {{ $items->links() }}
        </div>
    </section>
</x-app-layout>

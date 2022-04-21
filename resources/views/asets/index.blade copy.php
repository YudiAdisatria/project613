<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Aset') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                <a href="{{ route('asets.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    + Create Aset
                </a>
            </div>
            <div class="bg-white">
                <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="border px-6 py-4">Id Aset</th>
                                <th class="border px-6 py-4">Nama Aset</th>
                                <th class="border px-6 py-4">Kategori</th>
                                <th class="border px-6 py-4">Lokasi</th>
                                <th class="border px-6 py-4">Kondisi</th>
                                <th class="border px-6 py-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($aset as $item)
                            <tr>
                                <td class="border px-6 py-4">{{ $item->id_aset }}</td>
                                <td class="border px-6 py-4">{{ $item->nama_aset }}</td>
                                <td class="border px-6 py-4">{{ $item->kategori->nama_kategori }}</td>
                                <td class="border px-6 py-4">{{ $item->gedung }}</td>
                                <td class="border px-6 py-4">{{ $item->kondisi }}</td>
                                <td class="border px-6 py-4 text-center">
                                    <a href="{{ route('asets.edit', $item->id_aset) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-2 rounded">
                                        Pindah
                                    </a>
                                    <form action="/dashboard/asets/{{$item->id_aset}}/jual" method="POST" class="inline-block">
                                        {!! method_field('get') . csrf_field() !!} 
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mx-2 rounded">
                                            Jual
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="border text-center p-5">
                                    Data Tidak Ditemukan
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                </table>
            </div>
            <div class="text-center mt-5">
                {{ $aset->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

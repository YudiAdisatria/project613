<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Berita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                <a href="{{ route('kategoris.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    + Create KAtegori
                </a>
            </div>
            <div class="bg-white">
                <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="border px-6 py-4">Id Kategori</th>
                                <th class="border px-6 py-4">Nama Kategori</th>
                                <th class="border px-6 py-4">Foto</th>
                                <th class="border px-6 py-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kategori as $item)
                            <tr>
                                <td class="border px-6 py-4">{{ $item->id_kategori }}</td>
                                <td class="border px-6 py-4">{{ $item->nama_kategori }}</td>
                                <td><img src="{{ $item->foto_kategori }}" alt="" class="scale-10 h-30 w-30 rounded"></td>
                                <td class="border px-6 py-4 text-center">
                                    <a href="{{ route('kategoris.edit', ['kategori' => $item->id_kategori]) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-2 rounded">
                                        Edit
                                    </a>
                                    <form action="{{ route('kategoris.destroy', $item->id_kategori) }}" method="POST" class="inline-block">
                                        {!! method_field('delete') . csrf_field() !!} 
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mx-2 rounded">
                                            Delete
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
                {{ $kategori->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

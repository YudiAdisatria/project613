<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ruangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                <a href="{{ route('ruangans.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    + Create User
                </a>
            </div>
            <div class="bg-white">
                <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="border px-6 py-4">ID Ruangan</th>
                                <th class="border px-6 py-4">Gedung</th>
                                <th class="border px-6 py-4">Ruangan</th>
                                <th class="border px-6 py-4">Keterangan</th>
                                <th class="border px-6 py-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ruangan as $item)
                            <tr>
                                <td class="border px-6 py-4">{{ $item->id_ruangan }}</td>
                                <td class="border px-6 py-4">{{ $item->gedung }}</td>
                                <td class="border px-6 py-4">{{ $item->ruangan }}</td>
                                <td class="border px-6 py-4">{{ $item->keterangan }}</td>
                                <td class="border px-6 py-4 text-center">
                                    <a href="{{ route('ruangans.edit', $item->id_ruangan) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-2 rounded">
                                        Edit
                                    </a>
                                    <form action="{{ route('ruangans.destroy', $item->id_ruangan) }}" method="POST" class="inline-block">
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
                {{ $ruangan->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('User') }}
        </h2>
    </x-slot>

    <section class="pt-8 pb-8 bg-gray-200">
        <div class="container relative">
            @can('manage-user')
            <button class="bg-green-500 hover:bg-white text-white font-bold hover:text-green-500 py-1 px-3 border border-transparent hover:border-green-500 rounded mb-5" >
                <a href="{{ route('users.create') }}">Tambah User</a>
            </button>
            @endcan
            <div class="flex flex-wrap">
                <div class="w-full self-center px-4 lg:w-1/2">
                    <h1 class="text-2xl font-bold mb-2 mr-3">List User</h1>
                </div>
                <div class="self-end px-2 lg:w-1/2">
                    <form action="{{ route('users.index') }}" class="mb-3 flex">
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
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">ID</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">Nama</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">Nomor Handphone</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">Divisi</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">Roles</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($user as $item)
                        <tr class="odd:bg-white even:bg-slate-100">
                            <td class="p-3 text-sm text-blue-500 font-bold ">{{ $item->id }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->noHp }}</td>
                            <td>{{ $item->divisi }}</td>
                            <td>{{ $item->roles }}</td>
                            <td class="text-sm">
                                <button type="submit" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-3 border border-blue-500 hover:border-transparent rounded mb-1">
                                    <a href="{{ route('users.edit', $item->id) }}">Edit</a>
                                </button>

                                @can('manage-user')
                                <form action="{{ route('users.destroy', $item->id) }}" method="POST" class="inline-block">
                                    {!! method_field('delete') . csrf_field() !!} 
                                    <button type="submit" class="bg-transparent hover:bg-red-600 text-red-500 font-semibold hover:text-white py-1 px-5  border border-red-600 hover:border-transparent rounded">
                                        Delete
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
            @forelse ($user as $item)
            <div class="bg-gray-200">
                <div class="grid grid-cols-1 gap-4 md:hidden">
                    <div class="bg-white p-4 rounded-lg shadow mb-5">
                        <div class= "flex justify-center space-x-2 text-sm">
                            <div class="p-3 text-sm text-blue-700 font-bold text-center ">{{ $item->id }}</div>
                            <div class=" font-semibold p-3 text-sm text-black text-center">{{ $item->nama }}</div>
                        </div>

                        <div class="flex justify-center items-center text-sm text-center">
                            <div class=" font-semibold p-3 text-sm text-black text-center">{{ $item->noHp }}</div>
                        </div>

                        <div class="flex justify-center items-center text-sm text-center">
                            <div class=" font-semibold p-3 text-sm text-black text-center">{{ $item->divisi }}</div>
                            <div class=" font-semibold p-3 text-sm text-black text-center">{{ $item->roles }}</div>
                        </div>

                        <div class="flex items-center space-x-2 text-sm justify-center">
                            <div class="text-sm text-black">
                                <button type="submit" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-3 border border-blue-500 hover:border-transparent rounded mb-1"> 
                                    <a href="{{ route('users.edit', $item->id) }}">
                                    Edit</button></a>

                                    @can('manage-user')
                                    <form action="{{ route('users.destroy', $item->id) }}" method="POST" class="inline-block">
                                        {!! method_field('delete') . csrf_field() !!} 
                                        <button type="submit" class="bg-transparent hover:bg-red-600 text-red-500 font-semibold hover:text-white py-1 px-5  border border-red-600 hover:border-transparent rounded">
                                            Delete
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
            {{ $user->links() }}
        </div>
    </section>
</x-app-layout>
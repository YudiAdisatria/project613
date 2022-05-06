<x-app-layout>
    <div class="container">
        <div class="mt-10 self-center">
        {{ $qr }}
            <p class="mt-1 text-lg font-bold">Id Aset : {{ $item->id_aset }}</p>
            <p class="mt-1 text-lg font-bold">Nama Aset : {{ $item->nama_aset }}</p>
        </div>
    </div>
</x-app-layout>
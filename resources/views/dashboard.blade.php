<x-app-layout>
    <!--Hero Section start-->
    <section id="home" class="pt-36 bg-white">
        <div class="container">
            <div class="flex flex-wrap">
                <div class="w-full self-center px-4 lg:w-1/2">
                    <h1 class="block font-bold text-blue-800 text-2xl mt-1 lg:text-4xl"> Aset Paroki Atmodirono</h1>
                    <h1 class="block font-bold text-blue-800 text-2xl mt-1 lg:text-4xl mb-10">Semarang</h1>
                    <p class="font-medium text-slate-400 mb-10 mr-5 leading-relaxed">Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque, nesciunt soluta culpa repellendus nulla modi sequi ab nisi, quia incidunt aliquid?</p>
                    @auth
                    @else
                        <a href="{{ route('login') }}" class="text-base font-semibold text-white bg-blue-600 py-3 px-8 rounded-full hover:shadow-lg hover:bg-teal-300 ease-in-out">
                            Sign In
                        </a> 
                    @endif
                </div>
                <div class="w-full self-end px-2 lg:w-1/2">
                    <div class="relative mt-8 mb-10 lg:mt-2 ">
                        <img src="logo-atmodirono.png" alt="gereja atmodirono" class="max-w-full mx-auto"/>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End-->

    <!--Blog Section Start-->
    <section id="blog" class="pt-36 pb-32 bg-slate-100">
        <div class="container">
            <div class="w-full px-4">
                <div class="max-w-xl mx-auto text-center mb-16">
                    <!-- <h4 class="font-semibold text-lg text-blue-400 mb-2">Blog</h4> -->
                    <h2 class="font-bold text-blue-600 text-3xl mb-4 sm:text-4xl lg:text-5xl">Aset Gereja</h2>
                    <p class="font-medium text-center text-md text-dark md:text-lg">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque aspernatur reiciendis quod iste consequatur doloribus delectus ex quo magni illum!
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap justify-center">
                <div class="w-full px-4 lg:w-1/2 xl:w-1/3">
                    <div class="bg-blue-600 rounded-xl shadow-lg overflow-hidden mb-10">
                        <img src="Capture3.png" alt="Car" class="w-full h-56" />
                        <div class="py-8 px-6">
                            <h3 class="mb-3 font-bold text-xl text-white text-center">List Aset</h3>
                            <p class="tracking-tight font-medium text-base text-white mb-6 text-justify">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Necessitatibus, aliquid!</p>
                            <p class="text-center"><a href="peminjaman.html" class="items-center font-bold text-sm text-dark bg-teal-300 py-2 px-4 rounded-lg hover:opacity-80 mr-50">Lihat Disini</a></p>
                        </div>
                    </div>
                </div>

                <div class="w-full px-4 lg:w-1/2 xl:w-1/3">
                    <div class="bg-blue-600 rounded-xl shadow-lg overflow-hidden mb-10">
                        <img src="Capture3.png" alt="Class" class="w-full h-56" />
                        <div class="py-8 px-6">
                            <h3 class="mb-3 font-semibold text-xl text-white text-center">Ruangan</h3>
                            <p class="tracking-tight font-medium text-base text-white mb-6 text-justify">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Necessitatibus, aliquid!</p>
                            <p class="text-center"><a href="ruangan.html" class="items-center text-sm text-black bg-teal-300 font-bold py-2 px-4 rounded-lg hover:opacity-80 mr-50">Lihat Disini</a></p>
                        </div>
                    </div>
                </div>

                <div class="w-full px-4 lg:w-1/2 xl:w-1/3">
                    <div class="bg-blue-600 rounded-xl shadow-lg overflow-hidden mb-10">
                        <img src="Capture3.png" alt="Music" class="w-full h-56" />
                        <div class="py-8 px-6">
                            <h3 class="mb-3 font-semibold text-xl text-white text-center">Pindah Aset</h3>
                            <p class="tracking-tight font-medium text-base text-white mb-6 text-justify">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Necessitatibus, aliquid!</p>
                            <p class="text-center"><a href="pindah_web.html" class="items-center font-bold text-sm text-dark bg-teal-300 py-2 px-4 rounded-lg hover:opacity-80 mr-50">Pindah Disini</a></p>
                        </div>
                    </div>
                </div>

                <div class="w-full px-4 lg:w-1/2 xl:w-1/3">
                    <div class="bg-blue-600 rounded-xl shadow-lg overflow-hidden mb-10">
                        <img src="Capture3.png" alt="Music" class="w-full h-56" />
                        <div class="py-8 px-6">
                            <h3 class="mb-3 font-semibold text-xl text-white text-center">Tambah Aset</h3>
                            <p class="tracking-tight font-medium text-base text-white mb-6 text-justify">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Necessitatibus, aliquid!</p>
                            <p class="text-center"><a href="tambah.html" class="items-center font-bold text-sm text-dark bg-teal-300 py-2 px-4 rounded-lg hover:opacity-80 mr-50">Tambah Aset</a></p>
                        </div>
                    </div>
                </div>

                <div class="w-full px-4 lg:w-1/2 xl:w-1/3">
                    <div class="bg-blue-600 rounded-xl shadow-lg overflow-hidden mb-10">
                        <img src="Capture3.png" alt="Music" class="w-full h-56" />
                        <div class="py-8 px-6">
                            <h3 class="mb-3 font-semibold text-xl text-white text-center">Jual Aset</h3>
                            <p class="tracking-tight font-medium text-base text-white mb-6 text-justify">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Necessitatibus, aliquid!</p>
                            <p class="text-center"><a href="jual.html" class="items-center font-bold text-sm text-dark bg-teal-300 py-2 px-4 rounded-lg hover:opacity-80 mr-50">Pindah Disini</a></p>
                        </div>
                    </div>
                </div>
                

            </div>
        </div>
    </section>
    <!--Blog Section End-->
</x-app-layout>

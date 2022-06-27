<x-app-layout>
    <!--Hero Section start-->
    <section id="home" class="pt-8 bg-white">
        <div class="container">
            <div class="flex flex-wrap">
                <div class="w-full self-center px-4 lg:w-1/2">
                    <h1 class="block font-bold text-blue-800 text-2xl mt-1 lg:text-4xl"> Aset Paroki Atmodirono</h1>
                    <h1 class="block font-bold text-blue-800 text-2xl mt-1 lg:text-4xl mb-10">Semarang</h1>
                    <p class="font-medium text-slate-400 mb-10 mr-5 leading-relaxed">
                        Website manajemen aset Gereja Atmodiromo Semarang
                    </p>
                    @auth
                    @else
                        <a href="{{ route('login') }}" class="text-base font-semibold text-white bg-blue-600 py-3 px-8 rounded-full hover:shadow-lg hover:bg-teal-300 ease-in-out">
                            Sign In
                        </a> 
                    @endif
                </div>
                <div class="w-full self-end px-2 lg:w-1/2">
                    <div class="relative mt-8 mb-10 lg:mt-2 ">
                        <img src="{{ asset('storage/assets/logo-atmodirono.png') }}" alt="gereja atmodirono" class="max-w-full mx-auto"/>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End-->
</x-app-layout>

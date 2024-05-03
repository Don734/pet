<!-- ========== HEADER ========== -->
<header class="flex flex-wrap sm:justify-start sm:flex-col w-full bg-white text-sm pb-2 sm:pb-0">
    <div class="flex max-w-[85rem] mx-auto justify-between w-full px-4 sm:px-6 lg:px-8 my-2">
        <div class="flex items-center gap-x-5 py-2 sm:pt-2 sm:pb-0">
            <div x-data="{ 'showModal': false }" @keydown.escape="showModal = false">
                <div @click="showModal = true; document.body.classList.add('overflow-hidden')" class="relative">
                    <div class="flex items-center w-full cursor-pointer text-gray-800 hover:text-gray-500 hover:transition-all hover:duration-500 font-medium">
                        @if($city)
                            {{ $city->name }}
                        @else
                            Москва
                        @endif
                        <svg class="ml-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M20 10C20 14.4183 12 22 12 22C12 22 4 14.4183 4 10C4 5.58172 7.58172 2 12 2C16.4183 2 20 5.58172 20 10Z" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M12 11C12.5523 11 13 10.5523 13 10C13 9.44772 12.5523 9 12 9C11.4477 9 11 9.44772 11 10C11 10.5523 11.4477 11 12 11Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fixed px-4 inset-0 z-[60] flex items-center justify-center overflow-y-scroll bg-black bg-opacity-50" x-show="showModal" x-cloak>
                    <!-- Modal inner -->
                    <div class="relative max-w-[85rem] max-h-[85dvh] w-full h-full mt-14" @click.away="showModal = false; document.body.classList.remove('overflow-hidden')">
                        <div class="absolute -top-14 right-0 flex bg-white rounded-md p-2.5 cursor-pointer" @click="showModal = false; document.body.classList.remove('overflow-hidden')">
                            <span class="text-xs font-bold mr-1.5">Закрыть</span>
                            <div class="p-1 bg-gray-200 rounded-full">
                                <img src="{{ asset('images/assets/icons/close.svg') }}" alt="edit">
                            </div>
                        </div>
                        <form id="location" class="bg-white flex flex-wrap w-full rounded-3xl p-5 sm:p-10 text-gray-800">
                            @csrf
                            <span class="text-2xl sm:text-5xl md:text-6xl lg:text-7xl font-bold w-full">Выберите регион</span>
                            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                                @foreach($cities->sortBy('district')->pluck('district')->sortBy('district')->unique() as $district)
                                <div class="flex flex-wrap content-start">
                                    <span class="text-2xl md:text-3xl lg:text-4xl h-fit font-semibold w-full mt-11">{{ $district }}</span>
                                    <div class="flex flex-wrap mt-7">
                                        @foreach($cities->where('district', $district)->sortBy('region')->unique('region') as $region)
                                            <a class="text-base font-normal w-full mb-2.5 hover:text-lime-600 hover:transition-all hover:duration-500  cursor-pointer" hx-post="{{ route('set-region', ['region' => $region['region']]) }}" hx-swap="outerHTML" hx-trigger="click" hx-target="#location">{{ $region['region'] }}</a>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <button class="hidden sm:block gap-2 font-medium disabled:text-slate-600 text-slate-600 hover:text-lime-600 hover:transition-all hover:duration-500 text-sm" href="#" title="Находится в разработке" disabled>
                Для бизнеса
            </button>
            <button class="hidden sm:block gap-2 font-medium disabled:text-slate-600 text-slate-600 hover:text-lime-600 hover:transition-all hover:duration-500 text-sm" href="#" title="Находится в разработке" disabled>
                Помощь
            </button>
            <button class="hidden sm:block gap-2 font-medium disabled:text-slate-600 text-slate-600 hover:text-lime-600 hover:transition-all hover:duration-500 text-sm" href="#" title="Находится в разработке" disabled>
                Польза
            </button>
            <button class="hidden sm:block gap-2 font-medium disabled:text-slate-600 text-slate-600 hover:text-lime-600 hover:transition-all hover:duration-500 text-sm" href="#" title="Находится в разработке" disabled>
                Блог
            </button>
        </div>
        <div class="hidden sm:flex items-center justify-end py-2 sm:pt-2 sm:pb-0">
            <a class="gap-2 font-medium text-slate-600 hover:text-lime-600 hover:transition-all hover:duration-500 text-sm" href="tel:+74993467749">
                8 499 346 7749
            </a>
        </div>
        <div x-data="{ isOpenMobileMenu:false }" class="sm:hidden">
            <button @click="isOpenMobileMenu = !isOpenMobileMenu" id="mobileMenuButton" class="p-2 text-gray-800 hover:text-gray-500 hover:transition-all hover:duration-500">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
            <div x-show="isOpenMobileMenu" @click.away="isOpenMobileMenu = false" class="absolute z-10 right-0 mt-2 bg-white w-full sm:shadow-md rounded-lg p-5" x-cloak>
                <a class="block py-1 text-sm text-gray-800 hover:bg-gray-100 hover:transition-all hover:duration-500" href="#">
                    Блог
                </a>
                <a class="block py-1 text-sm text-gray-800 hover:bg-gray-100 hover:transition-all hover:duration-500" href="#">
                    Стать партнером
                </a>
                <a class="block py-1 text-sm text-gray-800 hover:bg-gray-100 hover:transition-all hover:duration-500" href="tel:+74993467749">
                    8 499 346 7749
                </a>
            </div>
        </div>
    </div>
    <!-- End Topbar -->
    <div class="top-4 inset-x-0 flex flex-wrap px-4 md:justify-start md:flex-nowrap w-full text-sm mt-3">
        <nav class="relative max-w-[85rem] w-full rounded-full py-3 px-4 flex items-center justify-between lg:py-0 md:px-6 lg:px-8 xl:mx-auto bg-gray-800 border-gray-700" aria-label="Global">
            <div class="inline-flex">
                <a href="{{ route('home') }}" class="flex-none inline-flex max-w-[50%] sm:max-w-none items-center mr-3 cursor-pointer">
                    <img class="mr-2" src="{{ asset('images/assets/icons/Logo.svg') }}" alt="edit">
                    <!-- <a class="flex-none text-xl font-semibold text-lime-300" href="{{ route('home') }}">ZooBiZoo</a> -->
                </a>

                <div class="flex-none inline-flex relative bg-white rounded-md py-2.5 px-3 cursor-pointer" x-data="{ open: false }" @click.away="open = false">
                    <a @click="open = ! open" class="flex items-center hover:text-lime-600 hover:transition-all hover:duration-500">
                        <img class="mr-2" src="{{ url('images/assets/icons/list.svg') }}" alt="admin">
                        <span class="font-semibold text-sm font-inter text-gray-800 hover:text-lime-600 hover:transition-all hover:duration-500 leading-normal">Каталоги</span>
                    </a>
                    <div class="flex flex-wrap absolute w-28 top-12 left-0 z-[60] border border-black rounded-md bg-white text-sm font-inter leading-normal" x-show="open" x-cloak>
                        @foreach ($categories as $key => $category)
                            <a class="hover:text-lime-600 hover:transition-all hover:duration-500 w-full p-2 {{ $key !== (count($categories) - 1) ? 'border-b' : '' }}" href="{{ route('categories.show', $category->slug) }}">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div x-data="{ isOpenMobileMainMenu:false }" class="lg:hidden">
                <button @click="isOpenMobileMainMenu = !isOpenMobileMainMenu" id="mobileMainMenuButton" class="p-2 text-white hover:text-gray-500 hover:transition-all hover:duration-500">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M12 14c-2.667 0-8 1.333-8 4v1h16v-1c0-2.667-5.333-4-8-4zm0-6a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"></path>
                    </svg>
                </button>
                <div x-show="isOpenMobileMainMenu" @click.away="isOpenMobileMainMenu = false" class="absolute z-10 right-0 mt-2 bg-white w-full sm:shadow-md rounded-lg px-5 border" x-cloak>
                    <!-- @auth('users')
                        <a class="flex items-center cursor-pointer border-t py-3">
                            <img class="mr-2.5" src="{{ asset('images/assets/icons/heart-gray.svg') }}" alt="edit">
                            <span class="text-sm text-gray-500 font-inter font-normal leading-normal mr-2.5">Избранное</span>
                            <span class="bg-blue-100 text-blue-800 font-black text-[10px] font-inter px-1.5 rounded-full leading-6">999+</span>
                        </a>
                    @endauth -->
                    <a href="{{ route('profile.handbooks.create') }}" class="flex items-center border-t py-3">
                        <img class="mr-2" src="{{ url('images/assets/icons/plus-gray.svg') }}" alt="admin">
                        <span class="font-semibold text-sm font-inter leading-normal text-gray-500 hover:text-lime-600 hover:transition-all hover:duration-500">Добавить объявление</span>
                    </a>
                    <div class="border-t w-full justify-between flex py-3">
                        @auth('users')
                            <a class="flex items-center gap-x-2 font-medium text-gray-500 hover:text-lime-600 hover:transition-all hover:duration-500 xl:border-l xl:border-gray-300 lg:my-6 lg:pl-6" href="{{ route('profile') }}">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                </svg>
                                {{ auth('users')->user()->name }}
                            </a>
                            <a class="flex items-center gap-x-2 font-medium hover:text-lime-600 hover:transition-all hover:duration-500 xl:border-l xl:border-gray-300 lg:my-6 lg:pl-6 border-gray-700" href="{{ route('logout') }}">
                                Выйти
                            </a>
                        @else
                            <a class="flex items-center gap-x-2 font-medium text-gray-500 hover:text-lime-600 hover:transition-all hover:duration-500 md:border-l md:border-gray-300 md:my-6 md:pl-6" href="{{ route('login') }}">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                </svg>
                                Войти
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            
            <div class="hidden lg:flex flex-col gap-y-4 gap-x-0 md:flex-row md:items-center md:justify-end md:gap-y-0 md:gap-x-7 md:mt-0 md:pl-7">
                <!-- @auth('users')
                    <a class="flex cursor-pointer">
                        <img class="mr-2.5" src="{{ asset('images/assets/icons/heart.svg') }}" alt="edit">
                        <span class="text-white text-sm font-inter font-normal leading-normal mr-2.5">Избранное</span>
                        <span class="bg-blue-100 text-blue-800 font-black text-[10px] font-inter px-1.5 rounded-full leading-6">999+</span>
                    </a>
                @endauth -->
                <a href="{{ route('profile.handbooks.create') }}" class="flex relative border rounded-md py-2.5 px-3 cursor-pointer items-center">
                    <img class="mr-2" src="{{ url('images/assets/icons/plus.svg') }}" alt="admin">
                    <span class="font-semibold text-sm font-inter leading-normal text-white hover:text-lime-600 hover:transition-all hover:duration-500">Добавить объявление</span>
                </a>

                @auth('users')
                    <a class="flex items-center gap-x-2 font-medium hover:text-lime-600 hover:transition-all hover:duration-500 md:border-l md:border-gray-300 md:my-6 md:pl-6 text-white" href="{{ route('profile') }}">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                        </svg>
                        {{ auth('users')->user()->name }}
                    </a>
                    <a class="flex bg-white py-2.5 px-3 rounded-md items-center gap-x-2 font-medium text-gray-800 hover:text-lime-600 hover:transition-all hover:duration-500 md:border-l md:border-gray-300 md:my-6" href="{{ route('logout') }}">
                        Выйти
                    </a>
                @else
                    <a class="flex bg-white py-2.5 px-3 rounded-md items-center gap-x-2 font-medium text-gray-800 hover:text-lime-600 hover:transition-all hover:duration-500 md:border-l md:border-gray-300 md:my-6" href="{{ route('login') }}">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                        </svg>
                        Войти
                    </a>
                @endauth
            </div>
        </nav>
    </div>
</header>
<!-- ========== END HEADER ========== -->

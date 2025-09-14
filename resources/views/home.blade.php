@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main">
        <!-- Hero -->
        <div class="relative" x-data="{ query: '', isFocused: false }">
            <div class="max-w-[85rem] mx-auto sm:px-2 lg:px-4 sm:py-2 relative">
                <h1 class="md:text-2xl px-4 mt-5 md:mt-10 font-bold text-neutral-800 leading-normal w-full">
                    Услуги и товары для животных
                </h1>
                <div class="fixed h-screen w-screen top-0 left-0 z-50 bg-black opacity-50" x-show="isFocused" x-cloak></div>
                <div class="sm:mt-2 w-full px-4 pt-4 bg-white rounded-2xl relative z-50">
                    <form hx-target="_top" action="{{ route('search') }}" method="GET">
                        @csrf
                        <div class="relative z-10 flex space-x-3 bg-white justify-center items-center">
                            <div class="flex border border-lime-600 w-full p-1 rounded-full">
                                <label for="hs-search-article-1" class="block text-sm text-gray-700 font-medium"><span class="sr-only">Искать</span></label>
                                <input type="text"
                                       name="query"
                                       id="query"
                                       class="ml-14 block w-full xl:min-w-[18rem] focus:outline-none text-sm leading-relaxed relative"
                                       hx-post="{{ route('search.autocomplete') }}"
                                       hx-trigger="keyup changed"
                                       hx-target="#search-results"
                                       x-model="query"
                                       placeholder="Искать"
                                       @focus="isFocused = true"
                                       @blur="isFocused = query.trim() !== '' ? true : false"
                                       @input="isFocused = query.trim() !== ''">
                                <img class="flex-shrink-0 text-gray-500 absolute top-1/2 transform -translate-y-1/2 opacity-50 left-7" src="{{ asset('images/assets/icons/search.svg') }}" alt="edit">
                                <span x-show="query !== ''" class="absolute top-1/2 transform -translate-y-1/2 right-24 cursor-pointer" @click="query = ''; isFocused = false" x-cloak>
                                    <img src="{{ asset('images/assets/icons/clear.svg') }}" alt="clear">
                                </span>
                                <button :disabled="!query.trim()" class="flex-[1_0%]" type="submit" hx-boost="true">
                                    <div :class="{ 'bg-gray-400': !query.trim(), 'hover:bg-gray-500': !query.trim(), 'bg-lime-600': query.trim(), 'hover:bg-lime-700': query.trim() }" class="px-4 py-2 inline-flex justify-center items-center gap-2 rounded-full border border-transparent font-semibold text-neutral-900 focus:outline-none focus:ring-2 focus:ring-lime-700 focus:ring-offset-2 transition-all text-base leading-normal">
                                        Найти
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div id="search-results" class="mt-2" x-show="query !== ''" x-cloak></div>
                </div>
            </div>
        </div>
        <!-- End Hero -->

        <div class="max-w-[85rem] px-4 pt-3 sm:px-6 lg:px-8 mx-auto">
            <p class="font-bold text-neutral-800 md:text-2xl md:leading-tight w-3/4 pb-5">
                Каталог
            </p>
            @if ($categories->where('card_type', 'rectangle')->where('on_main', 1)->count() === 9)
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2 lg:gap-4 h-96 lg:h-72 text-sm sm:text-base md:text-xl lg:text-base xl:text-xl 2xl:text-2xl font-bold">
                <!-- 1 столбец -->
                <div class="flex flex-wrap col-span-1 content-between">
                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->take(1) as $category)
                        <a class="h-[35%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-50 bg-wiggle" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach

                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(1)->take(1) as $category)
                        <a class="relative h-[60%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-100 bg-charlie-brown" href="{{ route('categories.show', $category->slug) }}">
                            <img class="absolute bottom-0 right-0 h-full sm:h-5/6 lg:h-4/5" src="{{ asset('images/assets/images/dog.webp') }}" alt="banner_image">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <!-- 2 столбец -->
                <div class="flex flex-wrap col-span-1 content-between">
                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(2)->take(1) as $category)
                        <a class="relative h-[100%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-50 bg-wiggle" href="{{ route('categories.show', $category->slug) }}">
                            <img class="absolute bottom-0 right-0 h-3/4 lg:h-2/3 xl:h-4/5" src="{{ asset('images/assets/images/zoo-hotel.webp') }}" alt="banner_image">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <!-- 3 столбец -->
                <div class="flex flex-wrap col-span-1 content-between">
                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(3)->take(1) as $category)
                        <a class="h-[60%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-100 bg-bubbles" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach

                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(4)->take(1) as $category)
                        <a class="h-[35%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-50 bg-diagonal-stripes" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <!-- 4 столбец -->
                <div class="flex flex-wrap col-span-1 content-between">
                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(5)->take(1) as $category)
                        <a class="h-[100%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-100 bg-bubbles" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <!-- 5 столбец -->
                <div class="flex flex-wrap col-span-1 content-between">
                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(6)->take(1) as $category)
                        <a class="relative h-[35%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-50 bg-squares-in-squares" href="{{ route('categories.show', $category->slug) }}">
                            <img class="absolute bottom-0 right-0 h-full lg:h-4/5" src="{{ asset('images/assets/images/feed.webp') }}" alt="banner_image">
                            {{ $category->name }}
                        </a>
                    @endforeach

                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(7)->take(1) as $category)
                        <a class="h-[60%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-100 bg-zig-zag" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <!-- 6 столбец -->
                <div class="flex flex-wrap col-span-1 content-between">
                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(8)->take(1) as $category)
                        <a class="relative h-[100%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-50 bg-squares-in-squares" href="{{ route('categories.show', $category->slug) }}">
                            <img class="absolute bottom-4 right-0 w-1/2 lg:w-11/12" src="{{ asset('images/assets/images/toy.webp') }}" alt="banner_image">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            @if ($categories->where('card_type', 'rectangle')->where('on_main', 1)->count() === 8)
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 h-60 md:h-72 text-sm md:text-lg xl:text-xl 2xl:text-2xl font-bold">
                <!-- 1 столбец -->
                <div class="flex flex-wrap col-span-1 content-between">
                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->take(1) as $category)
                        <a class="h-[35%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-50 bg-wiggle" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach

                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(1)->take(1) as $category)
                        <a class="relative h-[60%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-100 bg-charlie-brown" href="{{ route('categories.show', $category->slug) }}">
                            <img class="absolute bottom-0 right-0 h-full sm:h-4/5" src="{{ asset('images/assets/images/dog.webp') }}" alt="banner_image">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <!-- 2 столбец -->
                <div class="flex flex-wrap col-span-1 content-between">
                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(2)->take(1) as $category)
                        <a class="h-[60%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-100 bg-bubbles" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach

                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(3)->take(1) as $category)
                        <a class="h-[35%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-50 bg-diagonal-stripes" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <!-- 3 столбец -->
                <div class="flex flex-wrap col-span-1 content-between">
                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(4)->take(1) as $category)
                        <a class="relative h-[35%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-50 bg-squares-in-squares" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach

                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(5)->take(1) as $category)
                        <a class="h-[60%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-100 bg-zig-zag" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <!-- 4 столбец -->
                <div class="flex flex-wrap col-span-1 content-between">
                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(6)->take(1) as $category)
                        <a class="h-[60%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-100 bg-bubbles" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach

                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(7)->take(1) as $category)
                        <a class="h-[35%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-50 bg-diagonal-stripes" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

            </div>
            @endif

            @if ($categories->where('card_type', 'rectangle')->where('on_main', 1)->count() === 7)
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 h-60 md:h-72 text-sm md:text-lg xl:text-xl 2xl:text-2xl font-bold">
                <!-- 1 столбец -->
                <div class="flex flex-wrap col-span-1 content-between">
                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->take(1) as $category)
                        <a class="h-[35%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-50 bg-wiggle" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach

                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(1)->take(1) as $category)
                        <a class="relative h-[60%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-100 bg-charlie-brown" href="{{ route('categories.show', $category->slug) }}">
                            <img class="absolute bottom-0 right-0 h-full sm:h-4/5" src="{{ asset('images/assets/images/dog.webp') }}" alt="banner_image">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <!-- 2 столбец -->
                <div class="flex flex-wrap col-span-1 content-between">
                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(2)->take(1) as $category)
                        <a class="h-[60%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-100 bg-bubbles" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach

                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(3)->take(1) as $category)
                        <a class="h-[35%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-50 bg-diagonal-stripes" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <!-- 3 столбец -->
                <div class="flex flex-wrap col-span-1 content-between">
                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(4)->take(1) as $category)
                        <a class="h-[100%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-100 bg-bubbles" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <!-- 4 столбец -->
                <div class="flex flex-wrap col-span-1 content-between">
                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(5)->take(1) as $category)
                        <a class="relative h-[35%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-50 bg-squares-in-squares" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach

                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(6)->take(1) as $category)
                        <a class="h-[60%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-100 bg-zig-zag" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

            </div>
            @endif

            @if ($categories->where('card_type', 'rectangle')->where('on_main', 1)->count() === 6)
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 sm:gap-4 h-60 md:h-72 text-sm sm:text-lg lg:text-xl xl:text-2xl font-bold">
                <!-- 1 столбец -->
                <div class="flex flex-wrap col-span-1 content-between">
                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->take(1) as $category)
                        <a class="h-[35%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-50 bg-wiggle" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach

                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(1)->take(1) as $category)
                        <a class="relative h-[60%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-100 bg-charlie-brown" href="{{ route('categories.show', $category->slug) }}">
                            <img class="absolute bottom-0 right-0 h-full sm:h-4/5 lg:h-full" src="{{ asset('images/assets/images/dog.webp') }}" alt="banner_image">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <!-- 2 столбец -->
                <div class="flex flex-wrap col-span-1 content-between">
                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(2)->take(1) as $category)
                        <a class="h-[60%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-100 bg-bubbles" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach

                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(3)->take(1) as $category)
                        <a class="h-[35%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-50 bg-diagonal-stripes" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <!-- 3 столбец -->
                <div class="flex flex-wrap col-span-1 content-between">
                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(4)->take(1) as $category)
                        <a class="relative h-[60%] sm:h-[35%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-50 bg-squares-in-squares" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach

                    @foreach($categories->where('card_type', 'rectangle')->where('on_main', 1)->skip(5)->take(1) as $category)
                        <a class="hidden sm:block sm:h-[60%] p-2 sm:p-4 rounded-md border border-gray-200 hover:border-lime-600 hover:transition-all hover:duration-500 w-full bg-lime-100 bg-zig-zag" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

            </div>
            @endif
        </div>

        <div class="max-w-[85rem] px-4 py-6 sm:px-6 lg:px-8 mx-auto">
            <div class="grid gap-5 grid-cols-3 grid-rows-2 md:grid-cols-6 md:grid-rows-1">
                @foreach($categories->where('card_type', 'round')->where('on_main', 1) as $category)
                    <a class="text-center" href="{{ route('categories.show', $category->slug) }}">
                        @if ($category->media->first())
                            <div x-data="{ isLoading: true, imageUrl: '{{ asset($category->media->first()->getUrl()) }}' }">
                                <!-- Прелоадер -->
                                <div x-show="isLoading" class="w-full h-full flex items-center justify-center animate-pulse">
                                    <svg class="mb-2.5" viewBox="0 0 415 415" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="415" height="415" rx="207.5" fill="#E2E8F0"/>
                                    </svg>
                                </div>
                                <!-- Загрузка изображения -->
                                <img x-show="!isLoading" class="w-full hover:transition-all hover:duration-500 rounded-full mb-2.5 grayscale opacity-20 hover:grayscale-0 hover:opacity-100" x-bind:src="imageUrl" x-on:load="isLoading = false" x-on:error="isLoading = false" />
                            </div>
                        @else
                            <svg class="mb-2.5" viewBox="0 0 415 415" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="415" height="415" rx="207.5" fill="#D9D9D9"/>
                            </svg>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>

        @if($categories->count())
        <!-- Card Section -->
            <div class="max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto">
                <p class="text-xl sm:text-2xl font-bold text-neutral-800 md:text-4xl md:leading-tight w-full sm:w-3/4 sm:py-3 pb-3">
                    Популярные услуги для животных
                </p>
                <!-- Grid -->
                <div x-data="{ activeCategory: '{{ $categories->where('on_swiper', 1)->first() ? $categories->where('on_swiper', 1)->first()->slug : '' }}' }" class="flex flex-wrap lg:flex-nowrap sm:flex-row">
                    <div class="flex flex-wrap w-full items-end lg:w-2/3 xl:w-3/4 py-4 border rounded-xl bg-hero-gradient bg-no-repeat bg-contain">
                        <div class="flex flex-wrap mx-2 sm:mx-0 sm:ml-20">
                        @foreach($categories->where('on_swiper', 1) as $category)
                            <!-- Card -->
                            <div class="mr-2.5 mb-2 flex flex-col bg-white border shadow-sm rounded-full hover:shadow-md hover:transition-all hover:duration-500">
                                <button @click="activeCategory = '{{ $category->slug }}'" :class="{ 'font-semibold': activeCategory === '{{ $category->slug }}', 'text-lime-600': activeCategory === '{{ $category->slug }}' }" class="p-2 font-semibold text-center text-gray-800 cursor-pointer hover:text-lime-600 hover:transition-all hover:duration-500">{{ $category->name }}</button>
                            </div>
                            <!-- End Card -->
                        @endforeach
                        </div>

                        <div x-show="activeCategory" class="flex flex-wrap w-full py-4" x-cloak>
                            <div class="flex w-full swiper-container relative">
                                <!-- Swiper -->
                                <div class="hidden sm:flex w-24">
                                    <div class="swiper-button-prev after:hidden left-4 w-11 p-3 bg-lime-600 rounded-full">
                                        <img src="{{ asset('images/assets/icons/prev.svg') }}" alt="banner_image">
                                    </div>
                                </div>
                                <div class="flex swiper mySwiper mx-2 sm:mx-0 w-full">
                                    <div class="flex swiper-wrapper w-full min-h-[550px] min-w-[800px]">
                                    @foreach($categories->where('on_swiper', 1) as $category)
                                        @foreach($category->handbooksCategories as $handbookCategory)
                                            @foreach($handbookCategory->handbooks()->popular()->where('address', 'like', '%' . $city->name . '%')->take(8)->get() as $handbook)
                                            <!-- Card -->
                                            <div x-show="activeCategory === '{{ $category->slug }}'" class="flex swiper-slide w-full xl:max-w-[395px] bg-white border border-gray-200 rounded-xl p-5">
                                                <a href="{{ route('handbooks.show', $handbook->id) }}">
                                                    <div x-data="{ isLoading: true, retinaImageUrl: '{{ $handbook->media->first() ? asset($handbook->media->first()->getUrl('retina')) : asset('images/assets/images/no-photo.webp') }}', thumbImageUrl: '{{ $handbook->media->first() ? asset($handbook->media->first()->getUrl('thumb')) : asset('images/assets/images/no-photo.webp') }}' }">
                                                        <!-- Прелоадер -->
                                                        <div x-show="isLoading" class="w-full h-full flex items-center justify-center animate-pulse">
                                                            <div class="bg-slate-200 w-full h-48 sm:h-60 md:h-72 lg:h-60 rounded-xl"></div>
                                                        </div>
                                                        <!-- Загрузка изображения -->
                                                        <img class="w-full h-48 sm:h-60 md:h-72 lg:h-60 flex items-center justify-center rounded-xl object-cover" x-show="!isLoading" x-on:load="isLoading = false" x-on:error="isLoading = false" x-bind:srcset="retinaImageUrl + ' 2x, ' + thumbImageUrl + ' 1x'"/>
                                                    </div>

                                                    <div class="mt-7">
                                                        <h3 class="text-xl font-semibold text-gray-800 group-hover:text-gray-600 group-hover:transition-all group-hover:duration-500">
                                                            {{ $handbook->title }}
                                                        </h3>
                                                        <p class="mt-3 text-gray-800">
                                                            {{ Str::limit(strip_tags(str_replace(['•', '&nbsp;'], '', $handbook->description)), 150) }}
                                                        </p>
                                                        @if ($handbook->reviews->count() > 0)
                                                            <p class="mt-6 text-xl font-bold">Рейтинг</p>
                                                            @if ($handbook->reviews->avg('rating') == 5)
                                                                <div class="flex w-full mt-2.5">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                                                                    <img src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                                                                </div>
                                                            @elseif ($handbook->reviews->avg('rating') < 5)
                                                                <div class="flex w-full mt-2.5">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                                                                    <img src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                                                                </div>
                                                            @elseif ($handbook->reviews->avg('rating') < 4)
                                                                <div class="flex w-full mt-2.5">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                                                                    <img src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                                                                </div>
                                                            @elseif ($handbook->reviews->avg('rating') < 3)
                                                                <div class="flex w-full mt-2.5">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                                                                    <img src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                                                                </div>
                                                            @elseif ($handbook->reviews->avg('rating') < 2)
                                                                <div class="flex w-full mt-2.5">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                                                                    <img src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                                                                </div>
                                                            @else
                                                                <div class="flex w-full mt-2.5">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                                                                    <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                                                                    <img src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                                                                </div>
                                                            @endif
                                                            <p class="mt-6 text-xl font-bold">Последний отзыв</p>
                                                            <div class="flex mt-5">
                                                                <img class="mr-1.5" src="{{ asset('images/assets/icons/avatar.svg') }}" alt="banner_image">
                                                                <p class="text-lg font-bold">{{ optional($handbook->reviews->last())->name }}</p>
                                                            </div>
                                                            <p class="mt-1.5 text-base font-medium text-gray-500">{{ optional($handbook->reviews->last())->comment }}</p>
                                                        @else
                                                            <p class="mt-6 text-xl font-bold">Отзывов нет</p>
                                                        @endif
                                                        <p class="mt-6 inline-flex items-center gap-x-1.5 text-sm text-blue-500 hover:text-lime-600 hover:transition-all hover:duration-500 decoration-2 group-hover:underline group-hover:transition-all group-hover:duration-500 font-medium">
                                                            Смотреть подробнее
                                                            <svg class="w-2.5 h-2.5" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                                <path d="M5.27921 2L10.9257 7.64645C11.1209 7.84171 11.1209 8.15829 10.9257 8.35355L5.27921 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                                            </svg>
                                                        </p>
                                                    </div>
                                                </a>
                                            </div>
                                            <!-- End Card -->
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                    </div>
                                </div>
                                <div class="hidden sm:flex w-24">
                                    <div class="swiper-button-next after:hidden right-4 w-11 p-3 bg-lime-600 rounded-full">
                                        <img src="{{ asset('images/assets/icons/next.svg') }}" alt="banner_image">
                                    </div>
                                </div>
                                <div>
                                    <div class="ml-4 sm:ml-[70px] swiper-scrollbar absolute !-bottom-5 !w-[90%] sm:!w-[75%] md:!w-[78%] lg:!w-[75%] xl:!w-[84%] cursor-pointer !z-10"></div>
                                </div>
                            </div>
                        </div>
                        @if ($categories->where('on_swiper', 1)->isNotEmpty())
                            <a href="{{ route('all-services') }}" class="flex h-fit mt-7 ml-5 sm:ml-20 px-4 py-3 border rounded-full border-gray-500 bg-slate-50 items-center">
                                <span class="mr-2.5 text-sm font-semibold leading-normal whitespace-nowrap">Смотреть все услуги</span>
                                <img src="{{ asset('images/assets/icons/button-mailing-list.svg') }}" alt="edit">
                            </a>
                        @endif
                    </div>

                    <div class="flex flex-wrap w-full justify-center h-fit lg:w-1/3 xl:w-1/4 ml-0 sm:ml-4">
                        <div class="flex w-full sm:w-7/12 lg:w-full mt-4 lg:mt-0 relative justify-center">
                            <div class="w-full" x-data="{ isLoading: true, imageUrl: '{{ asset('images/assets/images/banner.webp') }}' }">
                                <!-- Прелоадер -->
                                <div x-show="isLoading" class="w-full h-full flex items-center justify-center animate-pulse">
                                    <div class="bg-slate-200 w-full h-[510px] sm:h-[500px] md:h-[611px] lg:h-[452px] xl:h-[428px] 2xl:h-[458px] rounded-3xl"></div>
                                </div>
                                <!-- Загрузка изображения -->
                                <div class="relative">
                                    <div class="overlay absolute inset-0 bg-black opacity-20 rounded-3xl"></div>
                                    <img x-show="!isLoading" class="w-full h-[510px] sm:h-[500px] md:h-[611px] lg:h-[452px] xl:h-[428px] 2xl:h-[458px] rounded-3xl object-cover" x-bind:src="imageUrl" x-on:load="isLoading = false" x-on:error="isLoading = false" />
                                </div>
                            </div>
                            <span class="absolute bottom-32 text-center text-4xl text-white font-black leading-8">Груминг для животных</span>
                                <a class="flex absolute cursor-pointer bottom-12 px-4 py-3 border rounded-full backdrop-blur-[2px] bg-[#c1c1c1]/[.39]" href="{{ route('categories.show', 'gruming') }}">
                                    <span class="mr-2.5 text-white text-sm font-semibold leading-normal hover:text-lime-900 hover:transition-all hover:duration-500">Выбрать салон</span>
                                    <img src="{{ asset('images/assets/icons/button-services.svg') }}" alt="edit">
                                </a>
                        </div>
                        <div class="flex flex-wrap sm:w-7/12 lg:w-full rounded-3xl border-2 border-lime-200 mt-4 p-6 xl:p-5 2xl:p-6 py-8 bg-lime-50">
                            <p class="text-2xl font-bold mb-2.5">Зоомир в рассылке</p>
                            <p class="text-sm font-medium">Лучшее для твоего питомца!</p>
                            <p class="text-sm font-medium">Акции, события, советы!</p>
                            <div x-data="{ 'showModal': false }" @keydown.escape="showModal = false" x-cloak>
                                <div @click="showModal = true;" class="inline-flex mt-10 cursor-pointer px-4 py-3 border rounded-full border-gray-500 bg-slate-50 hover:text-lime-600 hover:transition-all hover:duration-500">
                                    <span class="mr-2.5 text-sm font-semibold leading-normal">Подписаться на рассылку</span>
                                    <img src="{{ asset('images/assets/icons/button-mailing-list.svg') }}" alt="edit">
                                </div>
                                <!-- Modal -->
                                <div class="fixed inset-0 z-[60] flex items-center justify-center bg-black bg-opacity-50" x-show="showModal">
                                    <!-- Modal inner -->
                                    <form class="max-w-3xl p-12 max-[480px]:mx-5 mx-auto text-left bg-white rounded shadow-lg relative" @click.away="showModal = false;" x-transition:enter="motion-safe:ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" title="Находится в разработке">
                                        <!-- Title / Close-->
                                        <div class="flex items-center justify-center">
                                            <p class="text-lg font-black max-w-none mb-4">Подпишитесь на рассылку</p>
                                            <div type="button" class="z-50 cursor-pointer absolute top-3 right-3" @click="showModal = false;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </div>
                                        </div>
                                        <!-- content -->
                                        <input class="border border-gray-600 rounded-md mt-2 mr-2 p-2" placeholder="Введите e-mail"></input>
                                        <button class="max-[480px]:mt-5 text-white rounded-md disabled:bg-gray-600 bg-lime-600 px-4 py-2" disabled>ОК</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Grid -->
            </div>
            <!-- End Card Section -->
        @endif

        <!-- Card Section -->
        <div class="max-w-[85rem] px-4 py-3 sm:px-6 lg:px-8 mx-auto">
            <!-- Grid -->
            <div class="grid sm:grid-cols-4">
                <!-- Card -->
                <div class="p-4 mx-1 my-2 bg-gray-100 md:p-5 border rounded-xl relative before:absolute before:top-0 before:left-0 before:w-full before:h-px sm:before:w-px sm:before:h-full">
                    <div class="relative">
                        <div class="mt-3">
                            <div class="mt-1 lg:flex lg:justify-between lg:items-center">
                                <h3 class="text-3xl font-bold">
                                    5 тыс.
                                </h3>
                            </div>
                            <div class="flex items-center gap-x-2">
                                <p class="text-xs mt-3 tracking-wide w-3/4">
                                    новых объявлений каждый месяц
                                </p>
                            </div>
                        </div>
                        <img class="flex-shrink-0 w-9 h-9 text-gray-500 absolute top-1/2 right-2 transform -translate-y-1/2 opacity-50" src="{{ asset('images/assets/icons/new-announcement.svg') }}" alt="edit">
                    </div>
                </div>
                <!-- End Card -->

                <div class="p-4 mx-1 my-2 bg-gray-100 md:p-5 border rounded-xl relative before:absolute before:top-0 before:left-0 before:w-full before:h-px sm:before:w-px sm:before:h-full">
                    <div class="relative">
                        <div class="mt-3">
                            <div class="mt-1 lg:flex lg:justify-between lg:items-center">
                                <h3 class="text-3xl font-bold">
                                    845 112
                                </h3>
                            </div>
                            <div class="flex items-center gap-x-2">
                                <p class="text-xs mt-3 tracking-wide w-3/4">
                                    собранных отзывов для выбора лучшего предложения во всем интернете
                                </p>
                            </div>
                        </div>
                        <img class="flex-shrink-0 w-9 h-9 text-gray-500 absolute top-1/2 right-2 transform -translate-y-1/2 opacity-50" src="{{ asset('images/assets/icons/reviews.svg') }}" alt="edit">
                    </div>
                </div>
                <!-- End Card -->

                <div class="p-4 mx-1 my-2 bg-gray-100 md:p-5 border rounded-xl relative before:absolute before:top-0 before:left-0 before:w-full before:h-px sm:before:w-px sm:before:h-full">
                    <div class="relative">
                        <div class="mt-3">
                            <div class="mt-1 lg:flex lg:justify-between lg:items-center">
                                <h3 class="text-3xl font-bold">
                                    731
                                </h3>
                            </div>
                            <div class="flex items-center gap-x-2">
                                <p class="text-xs mt-3 tracking-wide w-3/4">
                                    льготных размещений рекламы на площадки для новых компаний
                                </p>
                            </div>
                        </div>
                        <img class="flex-shrink-0 w-9 h-9 text-gray-500 absolute top-1/2 right-2 transform -translate-y-1/2 opacity-50" src="{{ asset('images/assets/icons/piggy-bank.svg') }}" alt="edit">
                    </div>
                </div>
                <!-- End Card -->

                <div class="p-4 mx-1 my-2 bg-gray-100 md:p-5 border rounded-xl relative before:absolute before:top-0 before:left-0 before:w-full before:h-px sm:before:w-px sm:before:h-full">
                    <div class="relative">
                        <div class="mt-3">
                            <div class="mt-1 lg:flex lg:justify-between lg:items-center">
                                <h3 class="text-3xl font-bold">
                                    5
                                </h3>
                            </div>
                            <div class="flex items-center gap-x-2">
                                <p class="text-xs mt-3 tracking-wide w-3/4">
                                    благотворительных фондов для помощи животным
                                </p>
                            </div>
                        </div>
                        <img class="flex-shrink-0 w-9 h-9 text-gray-500 absolute top-1/2 right-2 transform -translate-y-1/2 opacity-50" src="{{ asset('images/assets/icons/present.svg') }}" alt="edit">
                    </div>
                </div>
                <!-- End Card -->
            </div>
            <!-- End Grid -->
        </div>
        <!-- End Card Section -->

        <!-- <div class="max-w-[85rem] px-4 py-3 sm:px-6 lg:px-8 mx-auto">
            <div class="grid md:grid-cols-5 gap-10">
                <div class="md:col-span-2">
                    <img class="rounded-xl" src="{{ asset('images/assets/images/banner2.webp') }}" alt="banner_image">
                </div>

                <div class="md:col-span-3">
                    <h2 class="text-2xl font-bold text-neutral-800 md:text-4xl md:leading-tight">Позаботься о своем питомце заранее</h2>
                    <div class="hs-accordion-group mt-6">
                        @foreach($categories->take(6) as $category)
                        <a class="group flex my-2 flex-col bg-white border shadow-sm rounded-xl hover:shadow-md hover:transition-all hover:duration-500 transition" href="{{ route('categories.show', $category->slug) }}">
                            <div class="p-4 md:p-5">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h3 class="group-hover:text-lime-600 group-hover:transition-all group-hover:duration-500 dark:group-hover:transition-all dark:group-hover:duration-500 font-semibold text-gray-800 dark:group-hover:text-gray-400">
                                            {{ $category->name }}
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            @if($category->description)
                                                {{ $category->description }}
                                            @else
                                                Категория "{{ $category->name }}"
                                            @endif
                                        </p>
                                    </div>
                                    <div class="pl-3">
                                        <svg class="w-3.5 h-3.5 text-gray-500" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M5.27921 2L10.9257 7.64645C11.1209 7.84171 11.1209 8.15829 10.9257 8.35355L5.27921 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div> -->

        <!-- FAQ -->
        <!-- <div class="bg-amber-50">
            <div class="max-w-[85rem] px-4 py-3 sm:px-6 lg:px-8 mx-auto">
                <h2 class="text-2xl font-bold text-neutral-800 md:text-4xl md:leading-tight w-full">Последние отзывы о zooBzoo</h2>

                <div class="grid md:grid-cols-6 gap-10">
                    <div class="md:col-span-4">
                        <div class="hs-accordion-group mt-6">
                            @foreach($reviews as $review)
                                <div class="group flex my-2 flex-col bg-white border shadow-sm rounded-xl hover:shadow-md hover:transition-all hover:duration-500 transition">
                                    <div class="p-4 md:p-5">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <h3 class="group-hover:text-lime-600 group-hover:transition-all group-hover:duration-500 font-semibold text-gray-800">
                                                    {{ $review->star_rating }} - {{ $review->name }}
                                                </h3>
                                                <p class="text-sm mt-4 text-gray-500">
                                                    {!! $review->comment !!}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <div class="rounded-xl border mt-6 p-6 py-8 bg-lime-200">
                            <p class="text-xl font-bold">Средняя оценка портала</p>
                            <p class="text-9xl font-bold">4.7</p>
                            <p class="text-black py-4">Рейтинг на основе 7690 отзывов наших пользователей.</p>
                            <div class="group flex flex-col bg-white border shadow-sm rounded-full hover:shadow-md hover:transition-all hover:duration-500 w-full md:w-2/3 transition">
                                <div class="flex items-center">
                                    <div class="p-2 md:p-2">
                                        <a class="pl-3 group-hover:text-lime-600 group-hover:transition-all group-hover:duration-500 font-semibold text-center text-gray-800f">
                                            Написать отзыв
                                        </a>
                                    </div>
                                    <div class="pl-3">
                                        <svg class="w-3.5 h-3.5 text-gray-500" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M5.27921 2L10.9257 7.64645C11.1209 7.84171 11.1209 8.15829 10.9257 8.35355L5.27921 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- End FAQ -->

    </main>
    <!-- ========== END MAIN CONTENT ========== -->
    </main>

@endsection

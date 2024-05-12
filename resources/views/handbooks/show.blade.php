@extends('layouts.app')

@section('title', $handbook->title)

@section('content')
    <main id="content" class="max-w-[85rem] w-full mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-10" role="main">
        <div class="flex max-[768px]:flex-wrap">
            <div class="w-2/3 max-[768px]:w-full">
                <h2 class="text-5xl max-[768px]:text-4xl max-[480px]:text-3xl max-[380px]:text-2xl font-semibold text-gray-800 w-full mb-7">{{ $handbook->title }}</h2>
                <!-- <a href="#" class="flex w-fit border border-gray-200 rounded-md mb-7 py-2.5 px-3 hover:bg-lime-100 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-lime-400 cursor-pointer items-center">
                    <span class="font-semibold text-sm text-gray-500 font-inter leading-normal">Добавить в избранное</span>
                    <img class="ml-2" src="{{ url('images/assets/icons/heart-handbook.svg') }}" alt="admin">
                </a> -->
                <div x-data="{ selectedImage: '{{ $handbook->getFirstMediaUrl('images', 'thumb') }}' }" x-cloak>
                    @if($handbook->getMedia('images')->isNotEmpty())
                        <div class="flex overflow-x-auto gallery gap-2 pb-2">
                            @foreach($handbook->getMedia('images') as $index => $image)
                                <img
                                    class="w-24 h-14 object-cover object-center rounded-md"
                                    :src="'{{ $image->getUrl('thumb') }}'"
                                    alt="Заведение"
                                    x-on:click="selectedImage = '{{ $image->getUrl() }}'"
                                >
                            @endforeach
                        </div>
                        <div class="flex justify-center mt-4 mb-7 relative overflow-hidden">
                            <div
                                class="absolute inset-0 bg-cover bg-center rounded-md"
                                x-bind:class="{ 'filter blur': selectedImage !== null }"
                                :style="{ 'background-image': selectedImage ? 'url(' + selectedImage + ')' : 'none' }"
                            ></div>
                            <template x-if="selectedImage !== null">
                                <img
                                    class="w-full max-w-full max-h-96 h-auto object-contain rounded-md relative z-10"
                                    :src="selectedImage"
                                    alt="Заведение"
                                >
                            </template>
                        </div>
                    @endif
                </div>
                @if($handbook->description)
                    <h2 class="text-3xl max-[480px]:text-2xl font-semibold text-gray-800 mb-4">Описание</h2>
                    <div class="w-full">
                        {!! $handbook->description !!}
                    </div>
                @endif
                <!-- <h2 class="text-3xl font-semibold text-gray-800 mb-4 mt-7">Характеристики</h2>
                <div class="w-full">
                    {!! $handbook->characteristics !!}
                </div> -->
                @if($handbook->services()->count())
                    <h2 class="text-3xl font-semibold text-gray-800 my-7">Услуги</h2>
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($handbook->services()->get() as $service)
                            <div class="bg-white mb-7 lg:flex">
                                {{-- Левая часть блока с изображением --}}
                                <div class="lg:w-1/4">
                                    @if($service->getMedia('images')->first())
                                        <div class="mr-6">
                                            <div class="relative w-full pb-[100%]">
                                                <img class="absolute top-0 left-0 w-full h-full object-cover object-center" src="{{ $service->getMedia('images')->first()->getUrl('thumb') }}" alt="Product Image">
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                {{-- Вторая часть блока с описанием --}}
                                <div class="flex flex-wrap content-between lg:w-1/2 lg:ml-4">
                                    <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ $service->title }}</h2>
                                    <p class="text-gray-600 text-base font-medium mb-2">{{ Str::limit(strip_tags(str_replace(['•', '&nbsp;'], '', $service->description)), 150) }}</p>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-normal px-3 py-0.5 bg-gray-100 text-gray-600 rounded-xl mr-4">Для кошки</span>
                                        <span class="text-sm font-normal px-3 py-0.5 bg-gray-100 text-gray-600 rounded-xl">Для собаки</span>
                                    </div>
                                </div>

                                {{-- Третья часть блока с ценой и кнопкой --}}
                                <div class="flex flex-wrap justify-end content-between lg:w-1/4 lg:ml-4">
                                    <p class="text-2xl text-end w-full font-bold text-gray-800">{{ $service->price }} ₽</p>
                                    <button href="#" class="flex w-full border disabled:bg-gray-200 disabled:border-gray-500 bg-lime-600 py-2.5 px-3 ml-2.5 text-sm text-gray-800 font-semibold rounded-lg hover:bg-lime-700 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-lime-600 justify-center items-center" title="Находится в разработке" disabled>Забронировать</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @php
                    $otherHandbooks = App\Models\Handbook::where('client_id', $handbook->client_id)
                        ->where('id', '!=', $handbook->id)
                        ->whereNotNull('client_id')
                        ->inRandomOrder()
                        ->take(4)
                        ->get();
                @endphp

                @if($otherHandbooks->count() > 0 and !str_contains($handbook->client->name, 'user'))
                    <div class="max-[768px]:hidden" x-data="{ isOpen: true }">
                        <div class="flex mb-7 mt-16" @click="isOpen = !isOpen">
                            <h2 class="text-3xl font-semibold text-gray-800">Другие объявления продавца</h2>
                            <img x-bind:class="{ 'transform rotate-180': isOpen, 'transform rotate-0': !isOpen }" class="ml-7 transition-transform duration-300" src="{{ url('images/assets/icons/chevron-down.svg') }}" alt="admin">
                        </div>
                        <div class="grid grid-rows-1 grid-cols-4 gap-x-7 mb-[88px]"
                            x-transition:enter="transition-all ease-out duration-200"
                            x-transition:enter-start="opacity-0 max-h-0"
                            x-transition:enter-end="opacity-100 max-h-[500px]"
                            x-transition:leave="transition-all ease-in duration-200"
                            x-transition:leave-start="opacity-100 max-h-[500px]"
                            x-transition:leave-end="opacity-0 max-h-0"
                            x-show="isOpen">
                            @foreach($otherHandbooks as $otherHandbook)
                                <a href="{{ route('handbooks.show', $otherHandbook->id) }}" class="flex flex-col h-full">
                                    <div class="relative w-full pb-[100%] mb-5">
                                        <img class="absolute top-0 left-0 w-full h-full object-cover object-center rounded-[10px]" src="{{ $otherHandbook->getMedia('images')->first()->getUrl('thumb') }}" alt="Изображение">
                                    </div>
                                    <div class="flex flex-col justify-between h-full">
                                        <div>
                                            <p class="text-lg font-bold text-gray-800 w-full leading-tight mb-1">{{ $otherHandbook->title }}</p>
                                            @if($otherHandbook->price == 0 || empty($otherHandbook->price))
                                                <div class="text-lg font-bold text-gray-800 w-full mb-5">Бесплатно</div>
                                            @else
                                                <div class="text-lg font-bold text-gray-800 w-full mb-5">{!! $otherHandbook->price !!} ₽</div>
                                            @endif
                                        </div>
                                        <p class="text-sm font-normal text-gray-500">{{ $otherHandbook->address }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @php
                    $relatedHandbooks = $handbook->categories->flatMap(function ($category) use ($handbook) {
                        return $category->handbooksCategories()
                            ->where('handbook_id', '!=', $handbook->id)
                            ->inRandomOrder()
                            ->take(4)
                            ->get();
                    });
                @endphp

                @if($relatedHandbooks->count() > 0)
                    <div class="max-[768px]:hidden" x-data="{ isOpen: true }">
                        <div class="flex mb-7 mt-7" @click="isOpen = !isOpen">
                            <h2 class="text-3xl font-semibold text-gray-800">Похожие объявления</h2>
                            <img x-bind:class="{ 'transform rotate-180': isOpen, 'transform rotate-0': !isOpen }" class="ml-7 transition-transform duration-300" src="{{ url('images/assets/icons/chevron-down.svg') }}" alt="admin">
                        </div>
                        <div class="grid grid-rows-1 grid-cols-4 gap-x-7 mb-[88px]"
                            x-transition:enter="transition-all ease-out duration-200"
                            x-transition:enter-start="opacity-0 max-h-0"
                            x-transition:enter-end="opacity-100 max-h-[500px]"
                            x-transition:leave="transition-all ease-in duration-200"
                            x-transition:leave-start="opacity-100 max-h-[500px]"
                            x-transition:leave-end="opacity-0 max-h-0"
                            x-show="isOpen">
                            @foreach($relatedHandbooks as $relatedHandbook)
                                <a href="{{ route('handbooks.show', $relatedHandbook->id) }}" class="flex flex-col h-full">
                                    <div class="relative w-full pb-[100%] mb-5">
                                    @if ($relatedHandbook->getMedia('images')->isNotEmpty())
                                        <img class="absolute top-0 left-0 w-full h-full object-cover object-center rounded-[10px]" src="{{ $relatedHandbook->getMedia('images')->first()->getUrl('thumb') }}" alt="Изображение">
                                    @else
                                        <p>No image available</p>
                                    @endif
                                    </div>
                                    <div class="flex flex-col justify-between h-full">
                                        <div>
                                            <p class="text-lg font-bold text-gray-800 w-full leading-tight mb-1">{{ $relatedHandbook->title }}</p>
                                            @if($relatedHandbook->price == 0 || empty($relatedHandbook->price))
                                                <div class="text-lg font-bold text-gray-800 w-full mb-5">Бесплатно</div>
                                            @else
                                                <div class="text-lg font-bold text-gray-800 w-full mb-5">{!! $relatedHandbook->price !!} ₽</div>
                                            @endif
                                        </div>
                                        <p class="text-sm font-normal text-gray-500">{{ $relatedHandbook->address }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="w-1/3 max-[768px]:w-full ml-16 max-[768px]:ml-0">
                <!-- {{-- @if($category->button_type == 'product') --}}
                    @if($handbook->price == 0 || empty($handbook->price))
                        <div class="text-7xl font-semibold text-gray-800 w-full mb-7">Бесплатно</div>
                    @else
                        <div class="text-7xl font-semibold text-gray-800 w-full mb-7">{!! $handbook->price !!} ₽</div>
                    @endif
                    <div class="flex flex-wrap xl:flex-nowrap justify-between mt-4 mb-16">
                        @if($handbook->price != 0 && !empty($handbook->price))
                            <button href="#" class="flex w-full bg-lime-600 disabled:bg-gray-600 rounded-md py-2.5 px-3 hover:bg-lime-700 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-lime-600 cursor-pointer justify-center items-center" title="Находится в разработке" disabled>
                                <img class="mr-2" src="{{ url('images/assets/icons/credit-card.svg') }}" alt="admin">
                                <span class="font-semibold text-sm text-white font-inter leading-normal">Купить сейчас</span>
                            </button>
                        @endif
                        <button href="#" class="flex w-full border disabled:bg-gray-200 disabled:border-gray-500 border-lime-600 py-2.5 px-3 ml-2.5 text-sm text-gray-800 font-semibold rounded-lg hover:bg-lime-100 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-lime-600 justify-center items-center" title="Находится в разработке" disabled>Написать</button>
                    </div>
                {{-- @endif --}}
                {{-- @if($category->button_type == 'appointment') --}}
                    <div class="flex flex-wrap xl:flex-nowrap justify-between mt-4 mb-16">
                        <button href="#" class="flex w-full border disabled:bg-gray-200 disabled:border-gray-500 border-lime-600 py-2.5 px-3 ml-2.5 text-sm text-gray-800 font-semibold rounded-lg hover:bg-lime-100 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-lime-600 justify-center items-center" title="Находится в разработке" disabled>Записаться</button>
                    </div>
                {{-- @endif --}}
                {{-- @if($category->button_type == 'reservation') --}}
                    <div class="flex flex-wrap xl:flex-nowrap justify-between mt-4 mb-16">
                        <button href="#" class="flex w-full border disabled:bg-gray-200 disabled:border-gray-500 border-lime-600 py-2.5 px-3 ml-2.5 text-sm text-gray-800 font-semibold rounded-lg hover:bg-lime-100 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-lime-600 justify-center items-center" title="Находится в разработке" disabled>Забронировать</button>
                    </div>
                {{-- @endif --}} -->
                <div class="flex max-[768px]:mt-8 justify-between">
                    <div>
                    @if(empty($handbook->client_id) or str_contains($handbook->client->name, 'user'))
                        <div class="flex">
                            <span class="font-semibold text-base text-gray-500 font-inter leading-normal">Аккаунт скрыт</span>
                        </div>
                        <div class="text-base text-gray-500">
                            <span>ИНН скрыт</span>
                        </div>
                    @else
                        <div class="flex">
                            <span class="font-semibold text-base text-gray-500 font-inter leading-normal">Аккаунт подтвержден</span>
                            <img class="ml-2.5" src="{{ url('images/assets/icons/verified.svg') }}" alt="admin">
                        </div>
                        <span class="font-bold text-xl text-gray-800">{{ $handbook->client->name }}</span>
                        <div class="text-base text-gray-500">
                            <span>ИНН скрыт</span>
                            <!-- <span>ИНН:</span>
                            <span class="ml-5">773505404332</span> -->
                        </div>
                    @endif
                    </div>
                    <div class="ml-5">
                    @php
                        $media = $handbook->client ? $handbook->client->getMedia('image') : null;
                    @endphp

                    @if ($media && $media->isNotEmpty())
                        <img class="w-20 h-20 object-cover rounded-full" src="{{ asset('storage/' . $media->first()->id . '/' . $media->first()->file_name) }}">
                    @else
                        <svg class="w-20 h-20" viewBox="0 0 415 415" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="415" height="415" rx="207.5" fill="#D9D9D9"/>
                        </svg>
                    @endif
                </div>

                </div>
                <p class="mt-6 text-xl font-bold">Рейтинг</p>
                @if ($handbook->reviews->count() > 0)
                    @if ($handbook->reviews->avg('rating') == 5)
                        <div class="flex w-full mt-2.5">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                            <img src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                            <img class="ml-2.5" src="{{ asset('images/assets/icons/reviews-card.svg') }}" alt="">
                            <span class="text-sm text-gray-500 ml-2.5 mb-1">{{ $handbook->reviews->count() }} @if ($handbook->reviews->count()%10 == 1 and $handbook->reviews->count()%100 != 11)отзыв @elseif ($handbook->reviews->count()%10 >= 2 and $handbook->reviews->count()%10 <= 4 and $handbook->reviews->count()%100 != 12 and $handbook->reviews->count()%100 != 13 and $handbook->reviews->count()%100 != 14)отзыва @else отзывов @endif</span>
                        </div>
                    @elseif ($handbook->reviews->avg('rating') < 5)
                        <div class="flex w-full mt-2.5">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                            <img src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                            <img class="ml-2.5" src="{{ asset('images/assets/icons/reviews-card.svg') }}" alt="">
                            <span class="text-sm text-gray-500 ml-2.5 mb-1">{{ $handbook->reviews->count() }} @if ($handbook->reviews->count()%10 == 1 and $handbook->reviews->count()%100 != 11)отзыв @elseif ($handbook->reviews->count()%10 >= 2 and $handbook->reviews->count()%10 <= 4 and $handbook->reviews->count()%100 != 12 and $handbook->reviews->count()%100 != 13 and $handbook->reviews->count()%100 != 14)отзыва @else отзывов @endif</span>
                        </div>
                    @elseif ($handbook->reviews->avg('rating') < 4)
                        <div class="flex w-full mt-2.5">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                            <img src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                            <img class="ml-2.5" src="{{ asset('images/assets/icons/reviews-card.svg') }}" alt="">
                            <span class="text-sm text-gray-500 ml-2.5 mb-1">{{ $handbook->reviews->count() }} @if ($handbook->reviews->count()%10 == 1 and $handbook->reviews->count()%100 != 11)отзыв @elseif ($handbook->reviews->count()%10 >= 2 and $handbook->reviews->count()%10 <= 4 and $handbook->reviews->count()%100 != 12 and $handbook->reviews->count()%100 != 13 and $handbook->reviews->count()%100 != 14)отзыва @else отзывов @endif</span>
                        </div>
                    @elseif ($handbook->reviews->avg('rating') < 3)
                        <div class="flex w-full mt-2.5">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                            <img src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                            <img class="ml-2.5" src="{{ asset('images/assets/icons/reviews-card.svg') }}" alt="">
                            <span class="text-sm text-gray-500 ml-2.5 mb-1">{{ $handbook->reviews->count() }} @if ($handbook->reviews->count()%10 == 1 and $handbook->reviews->count()%100 != 11)отзыв @elseif ($handbook->reviews->count()%10 >= 2 and $handbook->reviews->count()%10 <= 4 and $handbook->reviews->count()%100 != 12 and $handbook->reviews->count()%100 != 13 and $handbook->reviews->count()%100 != 14)отзыва @else отзывов @endif</span>
                        </div>
                    @elseif ($handbook->reviews->avg('rating') < 2)
                        <div class="flex w-full mt-2.5">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                            <img src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                            <img class="ml-2.5" src="{{ asset('images/assets/icons/reviews-card.svg') }}" alt="">
                            <span class="text-sm text-gray-500 ml-2.5 mb-1">{{ $handbook->reviews->count() }} @if ($handbook->reviews->count()%10 == 1 and $handbook->reviews->count()%100 != 11)отзыв @elseif ($handbook->reviews->count()%10 >= 2 and $handbook->reviews->count()%10 <= 4 and $handbook->reviews->count()%100 != 12 and $handbook->reviews->count()%100 != 13 and $handbook->reviews->count()%100 != 14)отзыва @else отзывов @endif</span>
                        </div>
                    @else
                        <div class="flex w-full mt-2.5">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                            <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                            <img src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                            <img class="ml-2.5" src="{{ asset('images/assets/icons/reviews-card.svg') }}" alt="">
                            <span class="text-sm text-gray-500 ml-2.5 mb-1">{{ $handbook->reviews->count() }} @if ($handbook->reviews->count()%10 == 1 and $handbook->reviews->count()%100 != 11)отзыв @elseif ($handbook->reviews->count()%10 >= 2 and $handbook->reviews->count()%10 <= 4 and $handbook->reviews->count()%100 != 12 and $handbook->reviews->count()%100 != 13 and $handbook->reviews->count()%100 != 14)отзыва @else отзывов @endif</span>
                        </div>
                    @endif
                @else
                    <div class="flex w-full mt-2.5">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                        <img src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                        <img class="ml-2.5" src="{{ asset('images/assets/icons/reviews-card.svg') }}" alt="">
                        <span class="text-sm text-gray-500 ml-2.5 mb-1">0 отзывов</span>
                    </div>
                @endif
                <!-- <div class="flex flex-wrap mt-5" title="Находится в разработке">
                    <div class="flex justify-center bg-gray-200 text-gray-800 text-xs font-bold leading-normal mr-4 mb-2 p-1.5 rounded-md cursor-pointer" hx-post="{{ route('search.autocomplete') }}" hx-trigger="click" hx-target="#search-results" @click="query = 'Ветеринар', isFocused = true">Подтвержденный продавец</div>
                    <div class="flex justify-center bg-gray-200 text-gray-800 text-xs font-bold leading-normal mr-4 mb-2 p-1.5 rounded-md cursor-pointer" hx-post="{{ route('search.autocomplete') }}" hx-trigger="click" hx-target="#search-results" @click="query = 'Офтальмолог для мопса', isFocused = true">110 продаж онлайн</div>
                    <div class="flex justify-center bg-gray-200 text-gray-800 text-xs font-bold leading-normal mr-4 mb-2 p-1.5 rounded-md cursor-pointer" hx-post="{{ route('search.autocomplete') }}" hx-trigger="click" hx-target="#search-results" @click="query = 'Корм для кошки с чувствительным пищеварением', isFocused = true">На площадке с 2023 года</div>
                </div> -->
                <!-- @if($handbook->tags()->count())
                <div class="md:col-span-2">
                    <div class="bg-white p-4">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Теги</h2>
                        <ul class="flex flex-wrap space-x-2">
                            @foreach($handbook->tags()->get() as $tag)
                                <li class="inline-block bg-lime-600 text-white px-3 py-1 rounded-md"><a href="{{ route('handbooks.index', ['tag' => $tag->slug]) }}">{{ $tag->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif -->
                @if($handbook->coord_x and $handbook->coord_y)
                    <div class="flex mt-3 border-4 border-lime-200 rounded-3xl bg-map-image bg-no-repeat bg-cover h-[191px] justify-center items-center">
                @else
                    <div class="flex mt-3 border-4 border-gray-100 rounded-3xl bg-map-image bg-no-repeat bg-cover h-[191px] justify-center items-center">
                @endif
                <div x-data="{ 'showModal': false }" @keydown.escape="showModal = false" x-cloak>
                    @if($handbook->coord_x and $handbook->coord_y)
                        <div @click="showModal = true; myFunction3({{ $handbook->coord_x }}, {{ $handbook->coord_y }}, {{ $handbook->id }});" id="mapContainer" class="flex h-fit px-4 py-3 border border-gray-800 rounded-full backdrop-blur-[2px] bg-[#c1c1c1]/[.39] cursor-pointer">
                            <span class="mr-2.5 text-sm font-semibold text-gray-800 hover:text-lime-600 hover:transition-all hover:duration-500">Посмотреть объявление на карте</span>
                            <img src="{{ asset('images/assets/icons/button-mailing-list.svg') }}" alt="edit">
                        </div>
                    @else
                        <button @click="showModal = true; myFunction();" id="mapContainer" class="flex h-fit px-4 py-3 border border-gray-800 rounded-full backdrop-blur-[2px] bg-[#717171]/[.39] items-center" disabled>
                            <span class="mr-2.5 text-sm font-semibold text-gray-800">Нет метки на карте</span>
                            <img src="{{ asset('images/assets/icons/button-mailing-list.svg') }}" alt="edit">
                        </button>
                    @endif
                        <!-- Modal -->
                        <div class="fixed px-4 inset-0 z-[60] flex items-center justify-center bg-black bg-opacity-50" x-show="showModal">
                            <!-- Modal inner -->
                            <div class="relative max-w-[85rem] max-h-[85dvh] w-full h-full mt-14" @click.away="showModal = false;">
                                <div class="absolute -top-14 right-0 flex bg-white rounded-md p-2.5 cursor-pointer" @click="showModal = false;">
                                    <span class="text-xs font-bold mr-1.5">Закрыть</span>
                                    <div class="p-1 bg-gray-200 rounded-full">
                                        <img src="{{ asset('images/assets/icons/close.svg') }}" alt="edit">
                                    </div>
                                </div>
                                <script>
                                    function myFunction3(coord_x, coord_y, id) {
                                        var myPoints = [];
                                        var userMarkerAdded = false; // Флаг для отслеживания добавления метки пользователя

                                        // Получаем текущее местоположение пользователя
                                        navigator.geolocation.getCurrentPosition(function (position) {
                                            const userLatitude = position.coords.latitude;
                                            const userLongitude = position.coords.longitude;

                                            // Проверяем, что значения широты и долготы не являются NaN
                                            if (!isNaN(userLatitude) && !isNaN(userLongitude)) {
                                                // Добавляем метку для пользователя
                                                myPoints.push({
                                                    coords: [userLatitude, userLongitude],
                                                    text: 'Ваше местоположение',
                                                    customIcon: '{{ asset("images/assets/icons/me-on-the-map.webp") }}'
                                                });
                                                userMarkerAdded = true;
                                            }

                                            // Добавляем метку из функции myFunction2
                                            myPoints.push({
                                                coords: [coord_y, coord_x],
                                                text: 'Метка места',
                                            });

                                            var map3;
                                            var script = document.createElement('script');
                                            script.src = "https://maps.api.2gis.ru/2.0/loader.js";
                                            document.body.appendChild(script);

                                            setTimeout(function () {
                                                DG.then(function () {
                                                    map3 = DG.map(`map-${id}`, {});

                                                    // Создаем массив с координатами всех меток, кроме метки пользователя
                                                    var markerCoordinates = myPoints.filter(function (point) {
                                                        return !point.customIcon || userMarkerAdded;
                                                    }).map(function (point) {
                                                        return point.coords;
                                                    });

                                                    // Устанавливаем начальный центр карты и масштаб на основе координат меток
                                                    var bounds = DG.latLngBounds(markerCoordinates);
                                                    map3.fitBounds(bounds);

                                                    myPoints.forEach(function (point) {
                                                        if (!point.customIcon || userMarkerAdded) {
                                                            var marker;
                                                            if (point.customIcon) {
                                                                // Используем кастомную метку для пользователя
                                                                marker = DG.marker(point.coords, {
                                                                    icon: DG.icon({
                                                                        iconUrl: point.customIcon,
                                                                        iconSize: [41, 41],
                                                                        iconAnchor: [12, 41],
                                                                        popupAnchor: [1, -34],
                                                                        shadowSize: [41, 41]
                                                                    })
                                                                });
                                                            } else {
                                                                // Используем стандартную метку для других точек
                                                                marker = DG.marker(point.coords);
                                                            }
                                                            marker.addTo(map3).bindPopup(point.text);
                                                        }
                                                    });
                                                });
                                            }, 100);
                                        }, function (error) {
                                            console.error('Ошибка получения местоположения пользователя:', error);
                                            // Добавляем метку из функции myFunction2
                                            myPoints.push({
                                                coords: [coord_y, coord_x],
                                                text: 'Метка места',
                                            });
                                            // Если не удалось получить местоположение пользователя, просто загружаем карту с метками
                                            var script = document.createElement('script');
                                            script.src = "https://maps.api.2gis.ru/2.0/loader.js";
                                            document.body.appendChild(script);
                                            setTimeout(function () {
                                                DG.then(function () {
                                                    map3 = DG.map(`map-${id}`, {});
                                                    // Создаем массив с координатами всех меток
                                                    var markerCoordinates = myPoints.map(function (point) {
                                                        return point.coords;
                                                    });
                                                    // Устанавливаем начальный центр карты и масштаб на основе координат меток
                                                    var bounds = DG.latLngBounds(markerCoordinates);
                                                    map3.fitBounds(bounds);
                                                    myPoints.forEach(function (point) {
                                                        var marker;
                                                        if (point.customIcon) {
                                                            // Используем кастомную метку для пользователя
                                                            marker = DG.marker(point.coords, {
                                                                icon: DG.icon({
                                                                    iconUrl: point.customIcon,
                                                                    iconSize: [41, 41],
                                                                    iconAnchor: [12, 41],
                                                                    popupAnchor: [1, -34],
                                                                    shadowSize: [41, 41]
                                                                })
                                                            });
                                                        } else {
                                                            // Используем стандартную метку для других точек
                                                            marker = DG.marker(point.coords);
                                                        }
                                                        marker.addTo(map3).bindPopup(point.text);
                                                    });
                                                });
                                            }, 100);
                                        });
                                    }
                                </script>
                                <div class="rounded-3xl overflow-hidden w-full h-full" id="map-{{ $handbook->id }}"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full mt-5">
                    <p class="text-base font-medium text-gray-500">{{ $handbook->address }}</p>
                    <!-- <div class="flex mt-1.5 items-center">
                        <img src="{{ asset('images/assets/icons/green-dot.svg') }}" alt="">
                        <span class="text-base ml-5">Речной вокзал (300 м.)</span>
                    </div>
                    <div class="flex mt-1.5 items-center">
                        <img src="{{ asset('images/assets/icons/calendar.svg') }}" alt="">
                        <span class="text-base ml-4">Сегодня 09:00 – 21:00</span>
                    </div> -->
                    @if(empty($handbook->phone))
                        <div class="flex mt-1.5 items-center">
                            <img src="{{ asset('images/assets/icons/phone.svg') }}" alt="">
                            <span class="text-base ml-2">Телефон скрыт</span>
                        </div>
                    @else
                        <div class="flex mt-1.5 items-center">
                            <img src="{{ asset('images/assets/icons/phone.svg') }}" alt="">
                            <a class="text-base ml-2" href="tel:{{ $handbook->phone }}">{{ $handbook->phone }}</a>
                        </div>
                    @endif
                </div>

                @if(auth('users')->user())
                <div class="grid grid-cols-1 gap-4 mt-8">
                    <div class="w-full bg-white rounded-md">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Оставить отзыв</h2>
                        <form action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="reviewable_id" value="{{ $handbook->id }}">
                            <input type="hidden" name="reviewable_type" value="App\Models\Handbook">
                            <div class="mb-4">
                                <label for="rating" class="block text-sm font-medium text-gray-700">Оценка:</label>
                                <input type="number" name="rating" id="rating" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-lime-600 focus:border-lime-600" min="1" max="5" placeholder="от 1 до 5" required>
                            </div>
                            <div class="mb-4">
                                <label for="comment" class="block text-sm font-medium text-gray-700">Комментарий:</label>
                                <textarea name="comment" id="comment" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-lime-600 focus:border-lime-600" required></textarea>
                            </div>
                            @if(session('success'))
                                <p class="mb-2 text-sm text-green-600 mt-2">{{ session('success') }}</p>
                            @endif
                            @if($errors->any())
                                @foreach ($errors->all() as $error)
                                    <p class="mb-2 text-sm text-red-600 mt-2">{{ $error }}</p>
                                @endforeach
                            @endif
                            <button type="submit" class="px-4 py-2 bg-lime-600 text-white font-semibold rounded-lg hover:bg-lime-700 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-lime-600">Отправить отзыв</button>
                        </form>
                    </div>
                </div>
                @endif

                <!-- <div x-data="{ showPhoneNumber: false }">

                    <button @click="showPhoneNumber = !showPhoneNumber">
                        <div x-show="!showPhoneNumber" class="bg-green-500 p-3 w-fit text-white">
                            <p>Показать телефон</p>
                            <p>8 958 XXX-XX-XX</p>
                        </div>
                    </button>
                    <button @click="showPhoneNumber = !showPhoneNumber">
                        <div x-show="showPhoneNumber">
                            <img class="w-60" src="{{ asset('images/assets/images/phone-number.webp') }}" alt="banner_image">
                        </div>
                    </button>
                </div> -->

                @if($handbook->reviews()->published()->count())
                    <p class="mt-6 text-xl font-bold">Последний отзыв</p>
                        <div class="flex mt-5">
                            <img class="mr-1.5" src="{{ asset('images/assets/icons/avatar.svg') }}" alt="">
                            <p class="text-lg font-bold">{{ optional($handbook->reviews->last())->name }}</p>
                        </div>
                    <p class="mt-1.5 text-base font-medium text-gray-500">{{ optional($handbook->reviews->last())->comment }}</p>
                    <div x-data="{ isOpen: false }">
                        <div @click="isOpen = !isOpen" class="flex w-fit border cursor-pointer border-gray-200 py-2.5 px-3 mt-1.5 text-sm text-gray-800 font-semibold rounded-lg hover:bg-lime-100 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-lime-600 justify-center items-center">Читать все отзывы</div>
                        <div class="fixed px-4 inset-0 z-[60] flex items-center justify-center bg-black bg-opacity-50" x-show="isOpen">
                            <div class="relative bg-white px-8 py-12 rounded-2xl max-w-[85rem] max-h-[85dvh] w-full h-full mt-14" @click.away="isOpen = false;">
                                <div class="text-xl font-bold">Отзывы:</div>
                                <div class="grid space-y-6">
                                    @foreach($handbook->reviews as $review)
                                        <div class="w-full border-b py-5 mt-5">
                                            <div class="flex">
                                                <img class="mr-1.5" src="{{ asset('images/assets/icons/avatar.svg') }}" alt="">
                                                <p class="text-lg font-bold">{{ $review->name }}</p>
                                            </div>
                                            <p class="mt-1.5 text-base font-medium text-gray-500">{{ $review->comment }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    @if($handbook->reviews()->publishedAndUnpublished()->count() == 0)
                        <p class="mt-6 text-xl font-bold">Отзывов нет</p>
                    @endif
                    @if(!auth('users')->user())
                        <p class="mt-2 text-sm font-medium text-gray-500">Авторизуйтесь, чтобы оставить комментарий</p>
                    @endif
                @endif
            </div>
        </div>
        <div id="popupCommentForm" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <button type="button" id="closePopupCommentButton" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 hover:transition-all hover:duration-500 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Отмена</span>
                    </button>
                    <div class="px-6 py-6 lg:px-8">
                        <h3 class="mb-4 text-xl font-medium text-gray-900">Оставить отзыв</h3>
                        <form class="space-y-6" action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="reviewable_id" id="reviewable_id" value="">
                            <input type="hidden" name="reviewable_type" value="App\Models\Service">
                            <div>
                                <label for="rating" class="block mb-2 text-sm font-medium text-gray-900">Оценка</label>
                                <input type="number" name="rating" id="rating" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-600 focus:border-lime-600 block w-full p-2.5" required>
                            </div>
                            <div>
                                <label for="comment" class="block mb-2 text-sm font-medium text-gray-900">Текст отзыва</label>
                                <textarea type="text" name="comment" id="comment" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-lime-600 focus:border-lime-600 block w-full p-2.5" required></textarea>
                            </div>
                            <button type="submit" class="w-full text-white bg-lime-600 hover:bg-lime-700 hover:transition-all hover:duration-500 focus:ring-4 focus:outline-none focus:ring-lime-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Оставить отзыв</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if($relatedHandbooks->count() > 0)
            <div class="min-[769px]:hidden" x-data="{ isOpen: true }">
                <div class="flex mb-7 mt-7" @click="isOpen = !isOpen">
                    <h2 class="text-3xl max-[480px]:text-2xl font-semibold text-gray-800">Похожие объявления</h2>
                    <img x-bind:class="{ 'transform rotate-180': isOpen, 'transform rotate-0': !isOpen }" class="ml-7 transition-transform duration-300" src="{{ url('images/assets/icons/chevron-down.svg') }}" alt="admin">
                </div>
                <div class="grid grid-rows-1 grid-cols-4 gap-x-7 max-[480px]:grid-cols-2 max-[480px]:gap-4 mb-[88px]"
                    x-transition:enter="transition-all ease-out duration-200"
                    x-transition:enter-start="opacity-0 max-h-0"
                    x-transition:enter-end="opacity-100 max-h-[500px]"
                    x-transition:leave="transition-all ease-in duration-200"
                    x-transition:leave-start="opacity-100 max-h-[500px]"
                    x-transition:leave-end="opacity-0 max-h-0"
                    x-show="isOpen">
                    @foreach($relatedHandbooks as $relatedHandbook)
                        <a href="{{ route('handbooks.show', $relatedHandbook->id) }}" class="flex flex-col h-full">
                            <div class="relative w-full pb-[100%] mb-5">
                            @if ($relatedHandbook->getMedia('images')->isNotEmpty())
                                <img class="absolute top-0 left-0 w-full h-full object-cover object-center rounded-[10px]" src="{{ $relatedHandbook->getMedia('images')->first()->getUrl('thumb') }}" alt="Изображение">
                            @else
                                <p>No image available</p>
                            @endif
                            </div>
                            <div class="flex flex-col justify-between h-full">
                                <div>
                                    <p class="text-lg font-bold text-gray-800 w-full leading-tight mb-1">{{ $relatedHandbook->title }}</p>
                                    @if($relatedHandbook->price == 0 || empty($relatedHandbook->price))
                                        <div class="text-lg font-bold text-gray-800 w-full mb-5">Бесплатно</div>
                                    @else
                                        <div class="text-lg font-bold text-gray-800 w-full mb-5">{!! $relatedHandbook->price !!} ₽</div>
                                    @endif
                                </div>
                                <p class="text-sm font-normal text-gray-500">{{ $relatedHandbook->address }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
        @if($otherHandbooks->count() > 0 and !str_contains($handbook->client->name, 'user'))
            <div class="min-[769px]:hidden" x-data="{ isOpen: true }">
                <div class="flex mb-7 mt-16" @click="isOpen = !isOpen">
                    <h2 class="text-3xl max-[480px]:text-2xl font-semibold text-gray-800">Другие объявления продавца</h2>
                    <img x-bind:class="{ 'transform rotate-180': isOpen, 'transform rotate-0': !isOpen }" class="ml-7 transition-transform duration-300" src="{{ url('images/assets/icons/chevron-down.svg') }}" alt="admin">
                </div>
                <div class="grid grid-rows-1 grid-cols-4 gap-x-7 max-[480px]:grid-cols-2 max-[480px]:gap-4 mb-[88px]"
                    x-transition:enter="transition-all ease-out duration-200"
                    x-transition:enter-start="opacity-0 max-h-0"
                    x-transition:enter-end="opacity-100 max-h-[500px]"
                    x-transition:leave="transition-all ease-in duration-200"
                    x-transition:leave-start="opacity-100 max-h-[500px]"
                    x-transition:leave-end="opacity-0 max-h-0"
                    x-show="isOpen">
                    @foreach($otherHandbooks as $otherHandbook)
                        <a href="{{ route('handbooks.show', $otherHandbook->id) }}" class="flex flex-col h-full">
                            <div class="relative w-full pb-[100%] mb-5">
                                <img class="absolute top-0 left-0 w-full h-full object-cover object-center rounded-[10px]" src="{{ $otherHandbook->getMedia('images')->first()->getUrl('thumb') }}" alt="Изображение">
                            </div>
                            <div class="flex flex-col justify-between h-full">
                                <div>
                                    <p class="text-lg font-bold text-gray-800 w-full leading-tight mb-1">{{ $otherHandbook->title }}</p>
                                    @if($otherHandbook->price == 0 || empty($otherHandbook->price))
                                        <div class="text-lg font-bold text-gray-800 w-full mb-5">Бесплатно</div>
                                    @else
                                        <div class="text-lg font-bold text-gray-800 w-full mb-5">{!! $otherHandbook->price !!} ₽</div>
                                    @endif
                                </div>
                                <p class="text-sm font-normal text-gray-500">{{ $otherHandbook->address }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </main>
@endsection

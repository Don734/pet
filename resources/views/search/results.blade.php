@extends('layouts.app')

@section('title', $query ?? 'Все услуги')

@section('content')
<main class="w-full" id="content" role="main">
        <div class="relative overflow-hidden">
            <div class="max-w-[85rem] mx-auto py-8 px-4 mt-5">                
                <div class="flex flex-col md:flex-row md:space-x-8 xl:space-x-16">
                    <div class="w-full lg:w-1/4">
                        @if(count(array_filter($handbooks->items(), function($handbook) use ($city) {
                            return isset($handbook['coord_x']) && isset($handbook['coord_y']) && stripos($handbook['address'], $city->name) !== false;
                        })) > 0)
                            <div class="flex mb-12 border-4 border-lime-200 rounded-3xl bg-map-image bg-no-repeat bg-cover h-[191px] justify-center items-center">
                        @else
                            <div class="flex mb-12 border-4 border-gray-100 rounded-3xl bg-map-image bg-no-repeat bg-cover h-[191px] justify-center items-center">
                        @endif
                            <div x-data="{ 'showModal': false }" @keydown.escape="showModal = false" x-cloak>
                                @if(count(array_filter($handbooks->items(), function($handbook) use ($city) {
                                    return isset($handbook['coord_x']) && isset($handbook['coord_y']) && stripos($handbook['address'], $city->name) !== false;
                                })) > 0)
                                    <div @click="showModal = true; myFunction();" id="mapContainer" class="flex h-fit px-4 py-3 border border-gray-800 rounded-full backdrop-blur-[2px] bg-[#c1c1c1]/[.39] cursor-pointer">
                                        <span class="mr-2.5 text-sm font-semibold text-gray-800 hover:text-lime-600 hover:transition-all hover:duration-500">Смотреть метки на карте</span>
                                        <img src="{{ asset('images/assets/icons/button-mailing-list.svg') }}" alt="edit">
                                    </div>
                                @else
                                    <button @click="showModal = true; myFunction();" id="mapContainer" class="flex h-fit px-4 py-3 border border-gray-800 rounded-full backdrop-blur-[2px] bg-[#717171]/[.39] items-center" disabled>
                                        <span class="mr-2.5 text-sm font-semibold text-gray-800">Нет меток на карте</span>
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
                                        @php
                                        $myPoints = [];
                                        foreach ($handbooks as $handbook) {
                                            if (str_contains($handbook->address, $city->name) && !empty($handbook->coord_x) && !empty($handbook->coord_y)) {
                                                $coord_x = (float) $handbook->coord_x;
                                                $coord_y = (float) $handbook->coord_y;

                                                $myPoints[] = [
                                                    'coords' => [$coord_y, $coord_x],
                                                    'text' => $handbook->title,
                                                ];
                                            }
                                        }
                                        @endphp
                                        <script>
                                            var map;

                                            function myFunction() {
                                                var myPoints = @json($myPoints);
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

                                                    // Загружаем библиотеку и отображаем карту
                                                    var script = document.createElement('script');
                                                    script.src = "https://maps.api.2gis.ru/2.0/loader.js";
                                                    document.body.appendChild(script);

                                                    setTimeout(function () {
                                                        DG.then(function () {
                                                            map = DG.map('map', {});

                                                            // Создаем массив с координатами всех меток, кроме метки пользователя
                                                            var markerCoordinates = myPoints.filter(function (point) {
                                                                return !point.customIcon || userMarkerAdded;
                                                            }).map(function (point) {
                                                                return point.coords;
                                                            });

                                                            // Устанавливаем начальный центр карты и масштаб на основе координат меток
                                                            var bounds = DG.latLngBounds(markerCoordinates);
                                                            map.fitBounds(bounds);

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
                                                                    marker.addTo(map).bindPopup(point.text);
                                                                }
                                                            });
                                                        });
                                                    }, 100);
                                                }, function (error) {
                                                    console.error('Ошибка получения местоположения пользователя:', error);
                                                    // Если не удалось получить местоположение пользователя, просто загружаем карту с метками
                                                    var script = document.createElement('script');
                                                    script.src = "https://maps.api.2gis.ru/2.0/loader.js";
                                                    document.body.appendChild(script);
                                                    setTimeout(function () {
                                                        DG.then(function () {
                                                            map = DG.map('map', {});
                                                            // Создаем массив с координатами всех меток
                                                            var markerCoordinates = myPoints.map(function (point) {
                                                                return point.coords;
                                                            });
                                                            // Устанавливаем начальный центр карты и масштаб на основе координат меток
                                                            var bounds = DG.latLngBounds(markerCoordinates);
                                                            map.fitBounds(bounds);
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
                                                                marker.addTo(map).bindPopup(point.text);
                                                            });
                                                        });
                                                    }, 100);
                                                });
                                            }
                                        </script>

                                        <div class="rounded-3xl overflow-hidden w-full h-full" id="map"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg overflow-hidden">
                            <!-- <form hx-target="_top" action="{{ route('search') }}" method="GET">
                                @csrf
                                <div class="relative flex space-x-3 bg-white justify-center items-center">
                                    <div class="flex w-full">
                                        <label for="hs-search-article-1" class="block text-sm text-gray-700 font-medium"><span class="sr-only">Искать</span></label>
                                        <input type="text"
                                            name="query"
                                            id="query"
                                            class="py-3 px-4 block w-full text-sm font-medium border border-gray-200 shadow-sm rounded-full focus:z-10 focus:border-lime-600 focus:ring-lime-600"
                                            hx-post="{{ route('search.autocomplete') }}"
                                            hx-trigger="keyup changed"
                                            hx-target="#search-results"
                                            x-model="query"
                                            placeholder="Поиск по названию">
                                    </div>
                                    <button class="flex-[1_0%]" type="submit" hx-boost="true">
                                        <div class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-full border border-transparent font-semibold bg-lime-600 text-white hover:bg-lime-700 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-lime-600 focus:ring-offset-2 text-sm">
                                            Поиск
                                        </div>
                                    </button>
                                </div>
                            </form> -->
                        </div>
                    </div>
                    <div class="w-full lg:w-3/4 space-y-6">
                        <h2 class="text-3xl sm:text-4xl lg:text-5xl xl:text-7xl mt-5 md:mt-0 font-bold md:leading-tight w-full">{{ $query ?? 'Все услуги' }}</h2>
                        <!-- <div class="flex items-center">
                            <p class="text-2xl font-bold">Сортировать:</p>
                            <div class="flex w-full mx-11">
                                <div class="flex w-1/3 rounded-l-xl border text-base font-medium py-3 px-4 hover:bg-lime-200 hover:transition-all hover:duration-500">
                                    <img class="mr-2" src="{{ asset('images/assets/icons/coin.svg') }}" alt="">По цене
                                </div>
                                <div class="flex w-1/3 border-y border-r text-base font-medium py-3 px-4 hover:bg-lime-200 hover:transition-all hover:duration-500">
                                    <img class="mr-2" src="{{ asset('images/assets/icons/map.svg') }}" alt="">По расстроянию
                                </div>
                                <div class="flex w-1/3 border-y border-r rounded-r-xl text-base font-medium py-3 px-4 hover:bg-lime-200 hover:transition-all hover:duration-500">
                                    <img class="mr-2" src="{{ asset('images/assets/icons/rating.svg') }}" alt="">По рейтингу
                                </div>
                            </div>
                        </div> -->
                        @php
                            $foundHandbooksInCity = false;
                        @endphp

                        @foreach($handbooks as $handbook)
                            @if(str_contains($handbook->address, $city->name))
                                @php
                                    $foundHandbooksInCity = true;
                                @endphp
                                @component('components.search-card', ['handbook' => $handbook, 'query' => $query ?? '', 'animals' => $animals])
                                @endcomponent
                            @endif
                        @endforeach

                        @if(!$foundHandbooksInCity)
                            <div class="text-2xl font-bold md:text-4xl md:leading-tight w-full">В данной категории нет объявлений</div>
                        @endif

                        <div class="flex justify-center mt-6">
                            <nav class="block">
                                <ul class="grid grid-rows-1 grid-flow-col gap-2 pl-0 rounded list-none flex-wrap">
                                    @if ($handbooks->onFirstPage())
                                        <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                                            <span class="text-sm rounded-lg font-bold px-4 py-2 leading-relaxed border border-gray-300 text-gray-500 cursor-not-allowed hover:bg-gray-300 hover:transition-all hover:duration-500" aria-hidden="true">&lsaquo;</span>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ $handbooks->previousPageUrl() }}" rel="prev" class="text-sm rounded-lg font-bold px-4 py-2 leading-relaxed border border-lime-600 text-lime-600 hover:bg-lime-600 hover:text-white hover:transition-all hover:duration-500" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                                        </li>
                                    @endif

                                    @foreach ($handbooks->getUrlRange(max(1, $handbooks->currentPage() - 2), min($handbooks->lastPage(), $handbooks->currentPage() + 2)) as $page => $url)
                                        @if ($page == $handbooks->currentPage())
                                            <li class="active" aria-current="page">
                                                <span class="text-sm rounded-lg font-bold px-4 py-2 leading-relaxed border border-lime-600 bg-lime-600 text-white hover:bg-lime-600 hover:text-white hover:transition-all hover:duration-500">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li>
                                                <a href="{{ $url }}" class="text-sm rounded-lg font-bold px-4 py-2 leading-relaxed border border-lime-600 text-lime-600 hover:bg-lime-600 hover:text-white hover:transition-all hover:duration-500">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    @if ($handbooks->hasMorePages())
                                        <li>
                                            <a href="{{ $handbooks->nextPageUrl() }}" rel="next" class="text-sm rounded-lg font-bold px-4 py-2 leading-relaxed border border-lime-600 text-lime-600 hover:bg-lime-600 hover:text-white hover:transition-all hover:duration-500" aria-label="@lang('pagination.next')">&rsaquo;</a>
                                        </li>
                                    @else
                                        <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                                            <span class="text-sm rounded-lg font-bold px-4 py-2 leading-relaxed border border-gray-300 text-gray-500 cursor-not-allowed hover:bg-gray-300 hover:transition-all hover:duration-500" aria-hidden="true">&rsaquo;</span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection


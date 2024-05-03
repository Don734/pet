<!-- resources/views/components/handbook-card.blade.php -->
<div class="w-full border rounded-lg overflow-hidden mx-auto p-5">
    <div class="flex flex-wrap flex-col-reverse lg:flex-nowrap lg:flex-row">
        <div class="xl:h-full w-full lg:w-2/5 2xl:w-1/3">
            <div x-data="{ isLoading: true, retinaImageUrl: '{{ $handbook->media->first() ? asset($handbook->media->first()->getUrl('retina')) : asset('images/assets/images/no-photo.webp') }}', thumbImageUrl: '{{ $handbook->media->first() ? asset($handbook->media->first()->getUrl('thumb')) : asset('images/assets/images/no-photo.webp') }}' }">
                <!-- Прелоадер -->
                <div x-show="isLoading" class="w-full h-full flex items-center justify-center animate-pulse">
                    <div class="bg-slate-200 w-full h-60 max-h-96 rounded-xl"></div>
                </div>
                <!-- Загрузка изображения -->
                <img class="w-full h-60 max-h-96 object-cover object-center rounded-xl" x-show="!isLoading" x-on:load="isLoading = false" x-on:error="isLoading = false" x-bind:srcset="retinaImageUrl + ' 2x, ' + thumbImageUrl + ' 1x'"/>
            </div>
            <p class="text-base font-medium text-gray-500 mt-7">{{ $handbook->address }}</p>
            <!-- <div class="flex mt-1.5 items-center">
                <img src="{{ asset('images/assets/icons/green-dot.svg') }}" alt="">
                <span class="text-base ml-5">Речной вокзал (300 м.)</span>
            </div>
            <div class="flex mt-1.5 items-center">
                <img src="{{ asset('images/assets/icons/calendar.svg') }}" alt="">
                <span class="text-base ml-4">Сегодня 09:00 – 21:00</span>
            </div> -->
            <div class="flex mt-1.5 items-center">
                <img src="{{ asset('images/assets/icons/phone.svg') }}" alt="">
                @if($handbook->phone)
                <a class="text-base ml-1.5" href="tel:{{ $handbook->phone }}">{{ $handbook->phone }}</a>
                @else
                <span class="text-base ml-1.5 text-gray-500">телефон скрыт</span>
                @endif
            </div>
            @if ($handbook->coord_x !== null && $handbook->coord_y !== null)
                <div class="flex justify-between mt-2 xl:mt-4" x-data="{ 'showModal': false }" @keydown.escape="showModal = false" x-cloak>
                    <button @click="showModal = true; myFunction2({{ $handbook->coord_x }}, {{ $handbook->coord_y }}, {{ $handbook->id }});" class="px-4 py-2 w-full border-2 border-lime-600 text-sm text-lime-600 font-semibold rounded-lg hover:bg-lime-200 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-lime-600">
                        <a class="flex items-center justify-center">
                            <svg class="ml-1 mr-1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <path d="M20 10C20 14.4183 12 22 12 22C12 22 4 14.4183 4 10C4 5.58172 7.58172 2 12 2C16.4183 2 20 5.58172 20 10Z" stroke="currentColor" stroke-width="1.5" />
                                <path d="M12 11C12.5523 11 13 10.5523 13 10C13 9.44772 12.5523 9 12 9C11.4477 9 11 9.44772 11 10C11 10.5523 11.4477 11 12 11Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span>Местоположение на карте</span>
                        </a>
                    </button>
                    <!-- Modal -->
                    <div class="fixed inset-0 px-4 z-[60] flex items-center justify-center bg-black bg-opacity-50" x-show="showModal">
                        <!-- Modal inner -->
                        <div class="relative max-w-[85rem] max-h-[85dvh] w-full h-full mt-14" @click.away="showModal = false;">
                            <div class="absolute -top-14 right-0 flex bg-white rounded-md p-2.5 cursor-pointer" @click="showModal = false;">
                                <span class="text-xs font-bold mr-1.5">Закрыть</span>
                                <div class="p-1 bg-gray-200 rounded-full">
                                    <img src="{{ asset('images/assets/icons/close.svg') }}" alt="edit">
                                </div>
                            </div>
                            <script>
                                function myFunction2(coord_x, coord_y, id) {
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

                                        var map2;
                                        var script = document.createElement('script');
                                        script.src = "https://maps.api.2gis.ru/2.0/loader.js";
                                        document.body.appendChild(script);

                                        setTimeout(function () {
                                            DG.then(function () {
                                                map2 = DG.map(`map-${id}`, {});

                                                // Создаем массив с координатами всех меток, кроме метки пользователя
                                                var markerCoordinates = myPoints.filter(function (point) {
                                                    return !point.customIcon || userMarkerAdded;
                                                }).map(function (point) {
                                                    return point.coords;
                                                });

                                                // Устанавливаем начальный центр карты и масштаб на основе координат меток
                                                var bounds = DG.latLngBounds(markerCoordinates);
                                                map2.fitBounds(bounds);

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
                                                        marker.addTo(map2).bindPopup(point.text);
                                                    }
                                                });
                                            });
                                        }, 100);
                                    }, function (error) {
                                        console.error('Ошибка получения местоположения пользователя:', error);
                                        // Если не удалось получить местоположение пользователя, просто загружаем карту с метками
                                        // Добавляем метку из функции myFunction2
                                        myPoints.push({
                                            coords: [coord_y, coord_x],
                                            text: 'Метка места',
                                        });
                                        var script = document.createElement('script');
                                        script.src = "https://maps.api.2gis.ru/2.0/loader.js";
                                        document.body.appendChild(script);
                                        setTimeout(function () {
                                            DG.then(function () {
                                                map2 = DG.map(`map-${id}`, {});
                                                // Создаем массив с координатами всех меток
                                                var markerCoordinates = myPoints.map(function (point) {
                                                    return point.coords;
                                                });
                                                // Устанавливаем начальный центр карты и масштаб на основе координат меток
                                                var bounds = DG.latLngBounds(markerCoordinates);
                                                map2.fitBounds(bounds);
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
                                                    marker.addTo(map2).bindPopup(point.text);
                                                });
                                            });
                                        }, 100);
                                    });
                                }
                            </script>
                            <div id="map-{{ $handbook->id }}" class="rounded-3xl w-full h-full"></div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="ml-0 lg:ml-6 w-full lg:w-3/5 2xl:w-2/3">
            <h2 class="text-2xl font-semibold text-gray-800"><a href="{{ route('handbooks.show', $handbook->id) }}">{{ $handbook->title }}</a></h2>
            <!-- <p class="text-sm text-gray-500 font-semibold mt-6">10 свободных номеров</p> -->
            <div class="flex flex-wrap mt-4">
                @if ($handbook->tags)
                    @foreach ($handbook->tags as $tag)
                        <div class="flex border border-gray-400 text-gray-500 justify-center text-[10px] font-bold mr-2.5 mt-2 px-0.5 rounded-md">{{ $tag }}</div>
                    @endforeach
                @endif
            </div>
            <p class="text-gray-500 font-medium mt-6">{{ Str::limit(strip_tags(str_replace(['•', '&nbsp;'], '', $handbook->description)), 150) }}</p>
            @if (($handbook->price > 0) && in_array($handbook->category_id, $animals->pluck('id')->toArray()))
                <p class="mt-6 text-xl font-bold">Цена: {{ $handbook->price }} ₽</p>
            @elseif ($handbook->price === 0 || $handbook->price === null && in_array($handbook->category_id, $animals->pluck('id')->toArray()))
                <p class="mt-6 text-xl font-bold">Цена: Бесплатно</p>
            @endif
            @if ($handbook->reviews->count() > 0)
                <p class="mt-6 text-xl font-bold">Рейтинг</p>
                @if ($handbook->reviews->avg('rating') == 5)
                    <div class="flex items-center w-full mt-2.5">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                        <span class="font-normal text-sm text-gray-500">{{ round($handbook->reviews->avg('rating'), 1) }}</span>
                        <img class="ml-2.5" src="{{ asset('images/assets/icons/reviews-card.svg') }}" alt="">
                        <span class="text-sm text-gray-500 ml-2.5 mb-1">{{ $handbook->reviews->count() }} @if ($handbook->reviews->count()%10 == 1 and $handbook->reviews->count()%100 != 11)отзыв @elseif ($handbook->reviews->count()%10 >= 2 and $handbook->reviews->count()%10 <= 4 and $handbook->reviews->count()%100 != 12 and $handbook->reviews->count()%100 != 13 and $handbook->reviews->count()%100 != 14)отзыва @else отзывов @endif</span>
                    </div>
                @elseif ($handbook->reviews->avg('rating') < 5)
                    <div class="flex items-center w-full mt-2.5">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                        <span class="font-normal text-sm text-gray-500">{{ round($handbook->reviews->avg('rating'), 1) }}</span>
                        <img class="ml-2.5" src="{{ asset('images/assets/icons/reviews-card.svg') }}" alt="">
                        <span class="text-sm text-gray-500 ml-2.5 mb-1">{{ $handbook->reviews->count() }} @if ($handbook->reviews->count()%10 == 1 and $handbook->reviews->count()%100 != 11)отзыв @elseif ($handbook->reviews->count()%10 >= 2 and $handbook->reviews->count()%10 <= 4 and $handbook->reviews->count()%100 != 12 and $handbook->reviews->count()%100 != 13 and $handbook->reviews->count()%100 != 14)отзыва @else отзывов @endif</span>
                    </div>
                @elseif ($handbook->reviews->avg('rating') < 4)
                    <div class="flex items-center w-full mt-2.5">    
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                        <span class="font-normal text-sm text-gray-500">{{ round($handbook->reviews->avg('rating'), 1) }}</span>
                        <img class="ml-2.5" src="{{ asset('images/assets/icons/reviews-card.svg') }}" alt="">
                        <span class="text-sm text-gray-500 ml-2.5 mb-1">{{ $handbook->reviews->count() }} @if ($handbook->reviews->count()%10 == 1 and $handbook->reviews->count()%100 != 11)отзыв @elseif ($handbook->reviews->count()%10 >= 2 and $handbook->reviews->count()%10 <= 4 and $handbook->reviews->count()%100 != 12 and $handbook->reviews->count()%100 != 13 and $handbook->reviews->count()%100 != 14)отзыва @else отзывов @endif</span>
                    </div>
                @elseif ($handbook->reviews->avg('rating') < 3)
                    <div class="flex items-center w-full mt-2.5">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                        <span class="font-normal text-sm text-gray-500">{{ round($handbook->reviews->avg('rating'), 1) }}</span>
                        <img class="ml-2.5" src="{{ asset('images/assets/icons/reviews-card.svg') }}" alt="">
                        <span class="text-sm text-gray-500 ml-2.5 mb-1">{{ $handbook->reviews->count() }} @if ($handbook->reviews->count()%10 == 1 and $handbook->reviews->count()%100 != 11)отзыв @elseif ($handbook->reviews->count()%10 >= 2 and $handbook->reviews->count()%10 <= 4 and $handbook->reviews->count()%100 != 12 and $handbook->reviews->count()%100 != 13 and $handbook->reviews->count()%100 != 14)отзыва @else отзывов @endif</span>
                    </div>
                @elseif ($handbook->reviews->avg('rating') < 2)
                    <div class="flex items-center w-full mt-2.5">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-green.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                        <span class="font-normal text-sm text-gray-500">{{ round($handbook->reviews->avg('rating'), 1) }}</span>
                        <img class="ml-2.5" src="{{ asset('images/assets/icons/reviews-card.svg') }}" alt="">
                        <span class="text-sm text-gray-500 ml-2.5 mb-1">{{ $handbook->reviews->count() }} @if ($handbook->reviews->count()%10 == 1 and $handbook->reviews->count()%100 != 11)отзыв @elseif ($handbook->reviews->count()%10 >= 2 and $handbook->reviews->count()%10 <= 4 and $handbook->reviews->count()%100 != 12 and $handbook->reviews->count()%100 != 13 and $handbook->reviews->count()%100 != 14)отзыва @else отзывов @endif</span>
                    </div>
                @else
                    <div class="flex items-center w-full mt-2.5">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                        <img class="mr-1" src="{{ asset('images/assets/icons/star-white.svg') }}" alt="">
                        <span class="font-normal text-sm text-gray-500">{{ round($handbook->reviews->avg('rating'), 1) }}</span>
                        <img class="ml-2.5" src="{{ asset('images/assets/icons/reviews-card.svg') }}" alt="">
                        <span class="text-sm text-gray-500 ml-2.5 mb-1">{{ $handbook->reviews->count() }} @if ($handbook->reviews->count()%10 == 1 and $handbook->reviews->count()%100 != 11)отзыв @elseif ($handbook->reviews->count()%10 >= 2 and $handbook->reviews->count()%10 <= 4 and $handbook->reviews->count()%100 != 12 and $handbook->reviews->count()%100 != 13 and $handbook->reviews->count()%100 != 14)отзыва @else отзывов @endif</span>
                    </div>
                @endif
                <p class="mt-6 text-xl font-bold">Последний отзыв</p>
                <div class="flex mt-5">
                    <img class="mr-1.5" src="{{ asset('images/assets/icons/avatar.svg') }}" alt="">
                    <p class="text-lg font-bold">{{ optional($handbook->reviews->last())->name }}</p>
                </div>
                <p class="mt-1.5 text-base font-medium text-gray-500">{{ optional($handbook->reviews->last())->comment }}</p>
            @else
                <!-- <p class="mt-6 text-xl font-bold">Отзывов нет</p> -->
            @endif
        </div>
    </div>
</div>

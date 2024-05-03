<!-- resources/views/components/handbook-card.blade.php -->
<div class="w-11/12 xl:w-11/12 bg-white shadow-md rounded-lg overflow-hidden mx-auto">
    <div class="xl:flex items-center">
        @if($handbook->getMedia('images')->first())
            <img class="w-full h-48 xl:h-full xl:w-1/3 max-h-96 object-cover object-center" src="{{ $handbook->getMedia('images')->first()->getUrl('thumb') }}" alt="Product Image">
        @endif
        <div class="p-4 xl:w-2/3">
            <h2 class="text-xl font-semibold text-gray-800"><a href="{{ route('handbooks.show', $handbook->id) }}">{{ $handbook->title }}</a></h2>
            <p class="text-gray-600">{{ Str::limit($handbook->description, 150) }}</p>

            <div class="mt-6 text-gray-600">
                @if($handbook->averageRating())
                    <div>
                        <span class="font-semibold">Оценка: </span> {{ number_format($handbook->averageRating(), 1) }}
                    </div>
                @endif
                @if($handbook->address)
                    <div>
                        @if($handbook->coord_x && $handbook->coord_y)
                            <span class="font-semibold">Адрес: </span><a href="https://yandex.ru/maps/?ll={{ $handbook->coord_y }}%2C{{ $handbook->coord_x }}&mode=whatshere&whatshere%5Bpoint%5D={{ $handbook->coord_y }}%2C{{ $handbook->coord_x }}&whatshere%5Bzoom%5D=11.81&z=15.85" target="_blank" class="text-decoration-line: underline">{{ $handbook->address }}</a>
                        @else
                            <span class="font-semibold">Адрес: </span>{{ $handbook->address }}
                        @endif
                    </div>
                @endif
                @if($handbook->working_hours)
                    <div>
                        <span class="font-semibold">Время работы: </span> {{ $handbook->working_hours }}
                    </div>
                @endif
                @if($handbook->phone)
                    <div>
                        <span class="font-semibold">Телефон:</span> {{ $handbook->phone }}
                    </div>
                @endif
            </div>

            <div class="flex justify-between mt-4">
                <button class="px-4 py-2 bg-lime-600 text-white font-semibold rounded-lg hover:bg-lime-700 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-lime-600"><a href="{{ route('profile.handbooks.show', $handbook->id) }}">Редактировать</a></button>
            </div>
        </div>
    </div>
</div>

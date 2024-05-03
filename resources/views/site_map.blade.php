@extends('layouts.app')

@section('title', 'Карта сайта')

@section('content')
    <main id="content" class="max-w-[85rem] w-full" role="main">
        <div class="px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <h2 class="text-3xl sm:text-4xl lg:text-5xl xl:text-7xl mt-5 md:mt-0 font-bold md:leading-tight w-full">Карта сайта</h2>
            <div class="bg-white rounded-xl shadow mt-6 p-4 sm:p-7">
                <div class="mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="bg-white">
                        <p class="text-2xl font-bold mb-2 cursor-pointer hover:text-lime-600 hover:transition-all hover:duration-500"><a href="{{ route('home') }}">Главная</a></p>
                        <p class="text-lg text-gray-400" title="Находится в разработке" disabled>Для бизнеса</p>
                        <p class="text-lg text-gray-400" title="Находится в разработке" disabled>Помощь</p>
                        <p class="text-lg text-gray-400" title="Находится в разработке" disabled>Польза</p>
                        <p class="text-lg text-gray-400" title="Находится в разработке" disabled>Блог</p>
                        <p class="text-2xl font-bold mt-2 mb-2">Категории</p>
                        @foreach($categories as $category)
                        <p><a class="text-lg inline-flex gap-x-2 text-gray-400 hover:text-lime-600 hover:transition-all hover:duration-500 ml-6 cursor-pointer" href="{{ route('categories.show', $category->slug) }}">{{ $category->name }}</a></p>
                        @endforeach
                        <p class="text-2xl font-bold mt-2 mb-2">Животные</p>
                        @foreach($animals as $animal)
                            <p><a class="text-lg inline-flex gap-x-2 text-gray-400 hover:text-lime-600 hover:transition-all hover:duration-500 ml-6 cursor-pointer" href="{{ route('categories.show', $animal->slug) }}">{{ $animal->name }}</a></p>
                        @endforeach
                        <p class="text-2xl font-bold mt-2 mb-2  cursor-pointer hover:text-lime-600 hover:transition-all hover:duration-500"><a href="{{ route('policy.show') }}">Политика конфиденциальности</a></p>
                        <p class="text-2xl font-bold mt-2 mb-2" title="Находится в разработке" disabled>Обратная связь</p>
                        <p class="text-2xl font-bold mt-2 mb-2" title="Находится в разработке" disabled>Контакты</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

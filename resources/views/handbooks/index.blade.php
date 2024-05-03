@extends('layouts.app')

@section('content')
    <main id="content" role="main">
        <div class="relative overflow-hidden">
            <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-10">
                <div class="flex flex-col md:flex-row space-x-4">
                    <div class="w-full md:w-1/5 bg-white shadow-lg rounded-lg overflow-hidden">
                        <div class="p-4">
                            <form action="{{ route('handbooks.index') }}" method="GET">
                                <div class="mb-3">
                                    <label for="title">Заголовок:</label>
                                    <input type="text" id="title" name="title" class="py-2 my-2 px-4 border-b border-lime-200 block w-full border-transparent shadow-sm rounded-md focus:z-10 focus:border-lime-600 focus:ring-lime-600" value="{{ request('title') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="category_id">Категория:</label>
                                    <select id="category_id" class="py-2 my-2 px-4 border-b border-lime-200 block w-full border-transparent shadow-sm rounded-md focus:z-10 focus:border-lime-600 focus:ring-lime-600" name="category_id">
                                        <option value="" >Выберите категорию</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @if(request('category_id') == $category->id) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button class="px-4 py-2 w-full bg-lime-600 text-white font-semibold rounded-lg hover:bg-lime-700 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-lime-600" type="submit">Применить фильтр</button>
                            </form>
                        </div>
                    </div>

                    <div class="w-full md:w-4/5 space-y-6">
                        @forelse($handbooks as $handbook)
                            @component('components.handbook-card', ['handbook' => $handbook])
                            @endcomponent
                            @if(count(array_filter($handbooks->items(), function($handbook) use ($city) {
                                return isset($handbook['coord_x']) && isset($handbook['coord_y']) && $handbook['city'] == $city->name;
                            })) == 0)
                            <div class="text-2xl font-bold md:text-4xl md:leading-tight w-full sm:w-3/4 mt-3 py-10 px-4">В данной категории нет объявлений</div>
                            @endif
                        @endforelse

                        <div class="flex justify-center mt-6">
                            <nav class="block">
                                <ul class="flex pl-0 rounded list-none flex-wrap">
                                    @if ($handbooks->onFirstPage())
                                        <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                                            <span class="text-sm font-bold px-4 py-2 leading-relaxed border border-gray-300 text-gray-500 cursor-not-allowed hover:bg-gray-300 hover:transition-all hover:duration-500" aria-hidden="true">&lsaquo;</span>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ $handbooks->previousPageUrl() }}" rel="prev" class="text-sm font-bold px-4 py-2 leading-relaxed border border-lime-600 text-lime-600 hover:bg-lime-600 hover:text-white hover:transition-all hover:duration-500" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                                        </li>
                                    @endif

                                    @foreach ($handbooks->getUrlRange(max(1, $handbooks->currentPage() - 2), min($handbooks->lastPage(), $handbooks->currentPage() + 2)) as $page => $url)
                                        @if ($page == $handbooks->currentPage())
                                            <li class="active" aria-current="page">
                                                <span class="text-sm font-bold px-4 py-2 leading-relaxed border border-lime-600 bg-lime-600 text-white hover:bg-lime-600 hover:text-white hover:transition-all hover:duration-500">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li>
                                                <a href="{{ $url }}" class="text-sm font-bold px-4 py-2 leading-relaxed border border-lime-600 text-lime-600 hover:bg-lime-600 hover:text-white transition duration-300 ease-in-out">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    @if ($handbooks->hasMorePages())
                                        <li>
                                            <a href="{{ $handbooks->nextPageUrl() }}" rel="next" class="text-sm font-bold px-4 py-2 leading-relaxed border border-lime-600 text-lime-600 hover:bg-lime-600 hover:text-white hover:transition-all hover:duration-500" aria-label="@lang('pagination.next')">&rsaquo;</a>
                                        </li>
                                    @else
                                        <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                                            <span class="text-sm font-bold px-4 py-2 leading-relaxed border border-gray-300 text-gray-500 cursor-not-allowed hover:bg-gray-300 hover:transition-all hover:duration-500" aria-hidden="true">&rsaquo;</span>
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

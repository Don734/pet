@extends('layouts.app')

@section('content')
    <main id="content" role="main">
        <div class="px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <div class="bg-white rounded-xl shadow p-4 sm:p-7">
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800">
                        {{ $handbook->title }}
                    </h2>
                </div>

                <form action="{{ route('profile.handbooks.update', $handbook->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">

                        <!-- Title -->
                        <div class="sm:col-span-3">
                            <label for="title" class="inline-block text-sm text-gray-800 mt-2.5">Название объявления</label>
                        </div>
                        <div class="sm:col-span-9">
                            <input id="title" type="text" value="{{ $handbook->title }}" name="title" class="py-2 px-3 pr-11 block w-full border-gray-200 shadow-sm -mt-px -ml-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-l-lg sm:mt-0 sm:first:ml-0 sm:first:rounded-tr-none sm:last:rounded-bl-none sm:last:rounded-r-lg text-sm relative focus:z-10 focus:border-lime-600 focus:ring-lime-600">
                        </div>

                        <div class="sm:col-span-3">
                            <label for="title" class="inline-block text-sm text-gray-800 mt-2.5">Изображения</label>
                        </div>

                        <div class="sm:col-span-9">
                            @foreach($handbook->getMedia('images') as $image)
                                <img src="{{ $image->getUrl() }}" alt="{{ $handbook->title }}" style="max-width: 100px; max-height: 100px;">
                            @endforeach
                                <input id="images" type="file" name="images[]" multiple>
                        </div>

                        <!-- Description -->
                        <div class="sm:col-span-3">
                            <label for="description" class="inline-block text-sm text-gray-800 mt-2.5">Описание</label>
                        </div>
                        <div class="sm:col-span-9">
                            <textarea id="description" name="description" class="py-2 px-3 pr-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-lime-600 focus:ring-lime-600">{{ $handbook->description }}</textarea>
                        </div>

                        <!-- Address -->
                        <div class="sm:col-span-3">
                            <label for="address" class="inline-block text-sm text-gray-800 mt-2.5">Адрес</label>
                        </div>
                        <div class="sm:col-span-9">
                            <input id="address" type="text" value="{{ $handbook->address }}" name="address" class="py-2 px-3 pr-11 block w-full border-gray-200 shadow-sm -mt-px -ml-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-l-lg sm:mt-0 sm:first:ml-0 sm:first:rounded-tr-none sm:last:rounded-bl-none sm:last:rounded-r-lg text-sm relative focus:z-10 focus:border-lime-600 focus:ring-lime-600">
                        </div>

                        <!-- Phone -->
                        <div class="sm:col-span-3">
                            <label for="phone" class="inline-block text-sm text-gray-800 mt-2.5">Телефон</label>
                        </div>
                        <div class="sm:col-span-9">
                            <input id="phone" type="text" value="{{ $handbook->phone }}" name="phone" class="py-2 px-3 pr-11 block w-full border-gray-200 shadow-sm -mt-px -ml-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-l-lg sm:mt-0 sm:first:ml-0 sm:first:rounded-tr-none sm:last:rounded-bl-none sm:last:rounded-r-lg text-sm relative focus:z-10 focus:border-lime-600 focus:ring-lime-600">
                        </div>

                        <!-- Coordinates -->
                        <div class="sm:col-span-3">
                            <label class="inline-block text-sm text-gray-800 mt-2.5">Координаты</label>
                        </div>
                        <div class="sm:col-span-9 sm:flex">
                            <label for="coord_x" class="px-3 inline-block text-sm sm:w-full text-gray-800 w-1/6 mt-2.5">Координата X</label>
                            <input id="coord_x" type="text" name="coord_x" value="{{ $handbook->coord_x }}" class="sm:w-full py-2 px-3 pr-11 block w-1/3 border-gray-200 shadow-sm -mt-px -ml-px focus:z-10 focus:border-lime-600 focus:ring-lime-600">
                            <label for="coord_y" class="px-3 inline-block text-sm sm:w-full text-gray-800 w-1/6 mt-2.5">Координата Y</label>
                            <input id="coord_y" type="text" name="coord_y" value="{{ $handbook->coord_y }}" class="sm:w-full py-2 px-3 pr-11 block w-1/3 border-gray-200 shadow-sm -mt-px -ml-px focus:z-10 focus:border-lime-600 focus:ring-lime-600">
                        </div>

                        <!-- Working Hours -->
                        <div class="sm:col-span-3">
                            <label for="working_hours" class="inline-block text-sm text-gray-800 mt-2.5">Время работы</label>
                        </div>
                        <div class="sm:col-span-9">
                            <input id="working_hours" type="text" name="working_hours" value="{{ $handbook->working_hours }}" class="py-2 px-3 pr-11 block w-full border-gray-200 shadow-sm -mt-px -ml-px sm:mt-0 sm:first:ml-0 sm:first:rounded-tr-none text-sm relative focus:z-10 focus:border-lime-600 focus:ring-lime-600">
                        </div>

                        <!-- Category -->
                        <div class="sm:col-span-3">
                            <label for="category_id" class="inline-block text-sm text-gray-800 mt-2.5">Категория</label>
                        </div>
                        <div class="sm:col-span-9">
                            <select id="category_id" name="category_id" class="py-3 px-4 block w-full border border-gray-200 rounded-md text-sm focus:border-lime-600 focus:ring-lime-600" required>
                                <option value="" disabled>Выберите категорию</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if($category->id == old('category_id', $handbook->category->id ?? null)) selected @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="mt-5 flex justify-end gap-x-2">
                        @if(session('success'))
                            <div class="text-xs text-green-600 mt-2">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <p class="text-xs text-red-600 mt-2">{{ $error }}</p>
                            @endforeach
                        @endif

                        <button type="button" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-lime-600 transition-all text-sm">Отмена</button>
                        <button type="submit" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-lime-600 text-white hover:bg-lime-700 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-lime-600 focus:ring-offset-2 transition-all text-sm">Сохранить изменения</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection


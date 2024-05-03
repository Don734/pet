@extends('layouts.app')

@section('title', 'Новое объявление')

@section('content')
    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main">
        <!-- Card Section -->
        <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <!-- Card -->
            <div class="p-7">
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800">
                        Создать новое объявление
                    </h2>
                </div>

                <form action="{{ route('profile.handbooks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <!-- Grid -->
                    <div x-data="{ selectedCategory: '' }" class="grid sm:grid-cols-12 gap-2 sm:gap-6">
                        <div class="sm:col-span-3">
                            <label for="title" class="inline-block text-sm text-gray-800 mt-2.5">
                                Название объявления
                            </label>
                        </div>
                        <!-- End Col -->

                        <div class="sm:col-span-9">
                            <div class="sm:flex">
                                <input id="title" type="text" name="title" class="py-2 px-3 pr-11 block w-full border-2 border-gray-300 rounded-lg shadow-sm -mt-px -ml-px sm:mt-0 sm:first:ml-0 text-sm relative focus:z-10 focus:border-lime-600 focus:ring-lime-600" value="{{ old('title') }}">
                            </div>
                        </div>
                        <!-- End Col -->

                        <div class="sm:col-span-3">
                            <label for="images" class="inline-block text-sm text-gray-800 mt-2.5">
                                Изображения
                            </label>
                        </div>
                        <!-- End Col -->

                        <div class="sm:col-span-9">
                            <div class="sm:flex">
                                <input id="images" type="file" name="images[]" multiple class="w-full file:bg-gradient-to-b file:bg-lime-600 file:hover:bg-lime-700 file:hover:transition-all file:hover:duration-500 focus:outline-none file:px-4 file:py-2 file:mr-5 file:border-none file:rounded-full file:text-neutral-900 file:font-semibold file:cursor-pointer file:shadow-blue-600/50" value="{{ old('title') }}">
                            </div>
                        </div>
                        <!-- End Col -->

                        <div class="sm:col-span-3">
                            <label for="description" class="inline-block text-sm text-gray-800 mt-2.5">
                                Описание
                            </label>
                        </div>
                        <!-- End Col -->

                        <div class="sm:col-span-9">
                            <textarea id="description" name="description" class="py-2 px-3 pr-11 block w-full border-2 border-gray-300 rounded-lg shadow-sm -mt-px -ml-px sm:mt-0 sm:first:ml-0 text-sm relative focus:z-10 focus:border-lime-600 focus:ring-lime-600">{{ old('description') }}</textarea>
                        </div>
                        <!-- End Col -->

                        <div class="sm:col-span-3">
                            <div class="inline-block">
                                <label for="address" class="inline-block text-sm text-gray-800 mt-2.5">
                                    Адрес
                                </label>
                            </div>
                        </div>
                        <!-- End Col -->

                        <div class="sm:col-span-9">
                            <div class="sm:flex">
                                <input id="address" type="text" name="address" class="py-2 px-3 pr-11 block w-full border-2 border-gray-300 rounded-lg shadow-sm -mt-px -ml-px sm:mt-0 sm:first:ml-0 text-sm relative focus:z-10 focus:border-lime-600 focus:ring-lime-600" value="{{ old('address') }}">
                            </div>
                        </div>
                        <!-- End Col -->

                        <div class="sm:col-span-3">
                            <div class="inline-block">
                                <label for="phone" class="inline-block text-sm text-gray-800 mt-2.5">
                                    Телефон
                                </label>
                            </div>
                        </div>
                        <!-- End Col -->

                        <div class="sm:col-span-9">
                            <div class="sm:flex">
                                <input id="phone" type="text" name="phone" class="py-2 px-3 pr-11 block w-full border-2 border-gray-300 rounded-lg shadow-sm -mt-px -ml-px sm:mt-0 sm:first:ml-0 text-sm relative focus:z-10 focus:border-lime-600 focus:ring-lime-600" value="{{ old('phone') }}">
                            </div>
                        </div>
                        <!-- End Col -->

                        <div class="sm:col-span-3">
                            <div class="inline-block">
                                <div class="inline-block text-sm text-gray-800 mt-2.5">
                                    Координаты
                                </div>
                            </div>
                        </div>
                        <!-- End Col -->

                        <div class="sm:col-span-9">
                            <div class="sm:flex">
                                <label for="coord_x" class="inline-block text-sm text-gray-800 mt-2.5 mr-5">Координата X</label>
                                <input id="coord_x" type="text" name="coord_x" value="{{ old('coord_x') }}" class="py-2 px-3 mr-5 block border-2 border-gray-300 rounded-lg shadow-sm -mt-px -ml-px sm:mt-0 sm:first:ml-0 text-sm relative focus:z-10 focus:border-lime-600 focus:ring-lime-600">
                                <label for="coord_y" class="inline-block text-sm text-gray-800 mt-2.5 mr-5">Координата Y</label>
                                <input id="coord_y" type="text" name="coord_y" value="{{ old('coord_y') }}" class="py-2 px-3 block border-2 border-gray-300 rounded-lg shadow-sm -mt-px -ml-px sm:mt-0 sm:first:ml-0 text-sm relative focus:z-10 focus:border-lime-600 focus:ring-lime-600">
                            </div>
                        </div>
                        <!-- End Col -->

                        <div class="sm:col-span-3">
                            <div class="inline-block">
                                <label for="working_hours" class="inline-block text-sm text-gray-800 mt-2.5">
                                    Время работы
                                </label>
                            </div>
                        </div>
                        <!-- End Col -->

                        <div class="sm:col-span-9">
                            <div class="sm:flex">
                                <input id="working_hours" type="text" name="working_hours" value="{{ old('working_hours') }}" class="py-2 px-3 pr-11 block w-full border-2 border-gray-300 rounded-lg shadow-sm -mt-px -ml-px sm:mt-0 sm:first:ml-0 text-sm relative focus:z-10 focus:border-lime-600 focus:ring-lime-600">
                            </div>
                        </div>
                        <!-- End Col -->

                        <div class="sm:col-span-3">
                            <div class="inline-block">
                                <label for="categoryMenu_id" class="inline-block text-sm text-gray-800 mt-2.5">
                                    Категория
                                </label>
                            </div>
                        </div>
                        <!-- End Col -->

                        <div class="sm:col-span-9">
                            <div class="sm:flex">
                                <select x-model="selectedCategory" id="categoryMenu_id" class="py-2 px-3 pr-11 block w-full border-2 border-gray-300 rounded-lg shadow-sm -mt-px -ml-px sm:mt-0 sm:first:ml-0 text-sm relative focus:z-10 focus:border-lime-600 focus:ring-lime-600" required>
                                    <option value="" disabled></option>
                                    @foreach($categoriesMenu as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- End Col -->

                        <div x-show="selectedCategory == '{{ $parentCategory->id }}'" class="sm:col-span-3">
                            <div class="inline-block">
                                <label for="animal_id" class="inline-block text-sm text-gray-800 mt-2.5">
                                    Подкатегория
                                </label>
                            </div>
                        </div>
                        <!-- End Col -->

                        <div x-show="selectedCategory == '{{ $parentCategory->id }}'" class="sm:col-span-9">
                            <div class="sm:flex">
                                <select :name="selectedCategory == '{{ $parentCategory->id }}' ? 'category_id' : 'animal_id'" id="animal_id" class="py-2 px-3 pr-11 block w-full border-2 border-gray-300 rounded-lg shadow-sm -mt-px -ml-px sm:mt-0 sm:first:ml-0 text-sm relative focus:z-10 focus:border-lime-600 focus:ring-lime-600" required>
                                    <option value="" disabled></option>
                                    @foreach($animals as $animal)
                                        <option value="{{ $animal->id }}">{{ $animal->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- End Col -->

                        <div x-show="selectedCategory == '{{ $parentCategory2->id }}'" class="sm:col-span-3">
                            <div class="inline-block">
                                <label for="category_id" class="inline-block text-sm text-gray-800 mt-2.5">
                                    Подкатегория
                                </label>
                            </div>
                        </div>
                        <!-- End Col -->

                        <div x-show="selectedCategory == '{{ $parentCategory2->id }}'" class="sm:col-span-9">
                            <div class="sm:flex">
                                <select :name="selectedCategory == '{{ $parentCategory2->id }}' ? 'category_id' : 'animal_id'" id="category_id" class="py-2 px-3 pr-11 block w-full border-2 border-gray-300 rounded-lg shadow-sm -mt-px -ml-px sm:mt-0 sm:first:ml-0 text-sm relative focus:z-10 focus:border-lime-600 focus:ring-lime-600" required>
                                    <option value="" disabled></option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Grid -->

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

                        <template x-if="selectedType === 'partner'">
                            <a href="{{ route('profile.handbooks.create') }}" class="py-2 px-5 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-lime-600 text-white hover:bg-lime-700 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-lime-600 focus:ring-offset-2 transition-all text-sm">
                                Добавить объявление
                            </a>
                        </template>
                        <button type="button" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-lime-600 transition-all text-sm">
                            Отмена
                        </button>
                        <button type="submit" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-lime-600 text-neutral-900 hover:bg-lime-700 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-lime-600 focus:ring-offset-2 transition-all text-sm">
                            Сохранить изменения
                        </button>
                    </div>
                </form>
            </div>
            <!-- End Card -->
        </div>
        <!-- End Card Section -->
    </main>
    <!-- ========== END MAIN CONTENT ========== -->
@endsection

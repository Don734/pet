@extends('layouts.app')

@section('title', 'Профиль')

@section('content')
    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main">
        <!-- Card Section -->
        <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <!-- Card -->
            <div class="p-7">
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800">
                        Аккаунт
                    </h2>
                    <p class="text-sm text-gray-600">
                        Управляйте настройками своего профиля
                    </p>
                </div>

                <form action="{{ route('profile.update') }}" method="post" x-data="{ selectedType: '{{ $user->type }}' }">
                @csrf
                @method('PUT')
                    <!-- Grid -->
                    <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">

                        <div class="sm:col-span-3">
                            <label for="af-account-full-name" class="inline-block text-sm text-gray-800 mt-2.5">
                                ФИО
                            </label>
                            <div class="hs-tooltip inline-block">
                                <button type="button" class="hs-tooltip-toggle ml-1">
                                    <svg class="inline-block w-3 h-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                    </svg>
                                </button>
                                <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible w-40 text-center z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-sm" role="tooltip">
                                  Отображается в отзывах к товарам
                                </span>
                            </div>
                        </div>
                        <!-- End Col -->

                        <div class="sm:col-span-9">
                            <div class="sm:flex">
                                <input id="af-account-full-name" type="text" name="name" class="py-2 px-3 pr-11 block w-full border-2 border-gray-300 rounded-lg shadow-sm -mt-px -ml-px sm:mt-0 sm:first:ml-0 text-sm relative focus:z-10 focus:border-lime-600 focus:ring-lime-600" value="{{ $user->name }}">
                            </div>
                        </div>
                        <!-- End Col -->

                        <div class="sm:col-span-3">
                            <label for="af-account-email" class="inline-block text-sm text-gray-800 mt-2.5">
                                Email
                            </label>
                        </div>
                        <!-- End Col -->

                        <div class="sm:col-span-9">
                            <input disabled id="af-account-email" type="email" class="py-2 px-3 pr-11 block w-full border-2 border-gray-300 rounded-lg shadow-sm -mt-px -ml-px sm:mt-0 sm:first:ml-0 text-sm relative focus:z-10 focus:border-lime-600 focus:ring-lime-600" value="{{ $user->email }}">
                        </div>
                        <!-- End Col -->

                        <div class="sm:col-span-3">
                            <div class="inline-block">
                                <label for="af-account-phone" class="inline-block text-sm text-gray-800 mt-2.5">
                                    Телефон
                                </label>
                                <span class="text-sm text-gray-400">
                                  (Не обязательное поле)
                                </span>
                            </div>
                        </div>
                        <!-- End Col -->

                        <div class="sm:col-span-9">
                            <div class="sm:flex">
                                <input id="af-account-phone" type="text" name="phone" class="py-2 px-3 pr-11 block w-full border-2 border-gray-300 rounded-lg shadow-sm -mt-px -ml-px sm:mt-0 sm:first:ml-0 text-sm relative focus:z-10 focus:border-lime-600 focus:ring-lime-600" value="{{ $user->phone }}">
                            </div>
                        </div>
                        <!-- End Col -->

                        <div class="sm:col-span-3">
                            <label for="af-account-gender-checkbox" class="inline-block text-sm text-gray-800 mt-2.5">
                                Роль
                            </label>
                        </div>
                        <!-- End Col -->

                        <div class="sm:col-span-9">
                            <div class="sm:flex">
                                <label for="checkbox-customer" class="flex py-2 px-3 w-full border-2 border-gray-300 shadow-sm -mt-px -ml-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-l-lg sm:mt-0 sm:first:ml-0 sm:first:rounded-tr-none sm:last:rounded-bl-lg sm:last:rounded-r-lg text-sm relative focus:z-10 focus:border-lime-600 focus:ring-lime-600">
                                    <!-- <input type="radio" name="type" value="customer" x-model="selectedType" {{ $user->type === 'customer' ? 'checked' : '' }} class="shrink-0 mt-0.5 border-gray-200 rounded-full text-lime-600 pointer-events-none focus:ring-lime-600" id="checkbox-customer"> -->
                                    <span class="text-sm text-gray-500">Клиент</span>
                                </label>
                                <!-- <label for="checkbox-partner" class="flex py-2 px-3 w-full border-2 border-gray-300 shadow-sm -mt-px -ml-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-l-lg sm:mt-0 sm:first:ml-0 sm:first:rounded-tr-none sm:last:rounded-bl-none sm:last:rounded-r-lg text-sm relative focus:z-10 focus:border-lime-600 focus:ring-lime-600">
                                    <input type="radio" name="type" value="partner" x-model="selectedType" {{ $user->type === 'partner' ? 'checked' : '' }} class="shrink-0 mt-0.5 border-gray-200 rounded-full text-lime-600 pointer-events-none focus:ring-lime-600" id="checkbox-partner">
                                    <span class="text-sm text-gray-500 ml-3">Партнер</span>
                                </label> -->
                            </div>
                        </div>
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
                                Добавить справочник
                            </a>
                        </template>
                        <button type="button" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-lime-600 transition-all text-sm">
                            Отмена
                        </button>
                        <button type="submit" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-lime-600 text-white hover:bg-lime-700 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-lime-600 focus:ring-offset-2 transition-all text-sm">
                            Сохранить изменения
                        </button>
                    </div>
                </form>

                <div class="my-8">
                    <h2 class="text-xl font-bold text-gray-800">
                        Безопасность
                    </h2>
                    <p class="text-sm text-gray-600">
                        Сменить пароль аккаунта
                    </p>
                </div>
                <form action="{{ route('password.update') }}" method="post">
                @csrf
                @method('POST')
                <!-- Grid -->
                    <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">

                        <div class="sm:col-span-3">
                            <label for="password" class="inline-block text-sm text-gray-800 mt-2.5">
                                Пароль
                            </label>
                        </div>
                        <!-- End Col -->

                        <div class="sm:col-span-9">
                            <div class="space-y-2">
                                <input id="password" type="password" class="py-2 px-3 pr-11 block w-full border-2 border-gray-300 rounded-lg shadow-sm -mt-px -ml-px sm:mt-0 sm:first:ml-0 text-sm relative focus:z-10 focus:border-lime-600 focus:ring-lime-600" name="current_password" placeholder="Введите текущий пароль">
                                <input type="password" class="py-2 px-3 pr-11 block w-full border-2 border-gray-300 rounded-lg shadow-sm -mt-px -ml-px sm:mt-0 sm:first:ml-0 text-sm relative focus:z-10 focus:border-lime-600 focus:ring-lime-600" name="password" placeholder="Введите новый пароль">
                            </div>
                        </div>
                        <!-- End Col -->
                    </div>

                    <!-- End Grid -->
                    <div class="mt-5 flex justify-end gap-x-2">
                        @if(session('success_pass'))
                            <div class="text-xs text-green-600 mt-2">
                                {{ session('success_pass') }}
                            </div>
                        @endif
                        @error('password')
                            <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                        @error('current_password')
                        <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                        <button type="button" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-lime-600 transition-all text-sm">
                            Отмена
                        </button>
                        <button type="submit" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-lime-600 text-white hover:bg-lime-700 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-lime-600 focus:ring-offset-2 transition-all text-sm">
                            Сменить пароль
                        </button>
                    </div>
                </form>
            </div>
            <!-- End Card -->
        </div>
        <!-- End Card Section -->

        @if($user->handbooks()->count() && $user->type == 'partner')
        <div class="px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <!-- Card -->
            <div class="bg-white rounded-xl shadow p-4 sm:p-7 space-y-6">
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800">
                        Объявления
                    </h2>
                </div>
                @foreach($user->handbooks()->get() as $handbook)
                    @component('components.handbook-personal-card', ['handbook' => $handbook])
                    @endcomponent
                @endforeach
            </div>
        </div>
        @endif
    </main>
    <!-- ========== END MAIN CONTENT ========== -->
@endsection

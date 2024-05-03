@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main" class="w-full max-w-md mx-auto p-6">
        <div class="mt-7 bg-white border border-gray-200 rounded-xl shadow-sm">
            <div class="p-4 sm:p-7">
                <div class="text-center">
                    <h1 class="block text-2xl font-bold text-gray-800">Зарегистрироваться</h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Уже есть аккаунт?
                        <a class="text-lime-600 decoration-2 hover:underline hover:transition-all hover:duration-500 font-medium" href="{{ route('login') }}">
                            Войти
                        </a>
                    </p>
                </div>

                <div class="mt-5">

                    <div class="py-3 flex items-center text-xs text-gray-400 uppercase before:flex-[1_1_0%] before:border-t before:border-gray-200 before:mr-6 after:flex-[1_1_0%] after:border-t after:border-gray-200 after:ml-6">или</div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="grid gap-y-4">
                            <!-- Form Group -->
                            <div>
                                <label for="type" class="block text-sm mb-2">Тип пользователя</label>
                                <div class="relative">
                                    <select id="type" name="type" class="py-3 px-4 block w-full border border-gray-200 rounded-md text-sm focus:border-lime-600 focus:ring-lime-600" required>
                                        <option value="" disabled></option>
                                        <option value="customer" {{ old('options') === 'customer' ? 'selected' : '' }}>Клиент</option>
                                        <!-- <option value="partner" {{ old('options') === 'partner' ? 'selected' : '' }}>Партнер</option> -->
                                        <!-- Add more options as needed -->
                                    </select>
                                </div>
                                @error('type')
                                    <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- End Form Group -->

                            <!-- Form Group -->
                            <div>
                                <label for="name" class="block text-sm mb-2">ФИО</label>
                                <div class="relative">
                                    <input type="name" value="{{ old('name') }}" id="name" name="name" class="py-3 px-4 block w-full border border-gray-200 rounded-md text-sm focus:border-lime-600 focus:ring-lime-600" required>
                                </div>
                                @error('name')
                                    <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- End Form Group -->

                            <!-- Form Group -->
                            <div>
                                <label for="email" class="block text-sm mb-2">Email</label>
                                <div class="relative">
                                    <input type="email" value="{{ old('email') }}" id="email" name="email" class="py-3 px-4 block w-full border border-gray-200 rounded-md text-sm focus:border-lime-600 focus:ring-lime-600" required>
                                </div>
                                @error('email')
                                    <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- End Form Group -->

                            <!-- Form Group -->
                            <div>
                                <label for="password" class="block text-sm mb-2">Пароль</label>
                                <div class="relative">
                                    <input type="password" id="password" name="password" class="py-3 px-4 block w-full border border-gray-200 rounded-md text-sm focus:border-lime-600 focus:ring-lime-600" required>
                                </div>
                                @error('password')
                                    <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- End Form Group -->

                            <!-- Form Group -->
                            <div>
                                <label for="password_confirmation" class="block text-sm mb-2">Подтвердите пароль</label>
                                <div class="relative">
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="py-3 px-4 block w-full border border-gray-200 rounded-md text-sm focus:border-lime-600 focus:ring-lime-600" required>
                                </div>
                            </div>
                            @error('incorrect')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <!-- End Form Group -->
                            <button type="submit" class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-lime-600 text-white hover:bg-lime-700 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-lime-600 focus:ring-offset-2 transition-all text-sm">Зарегистрироваться</button>
                        </div>
                    </form>
                    <!-- End Form -->
                </div>
            </div>
        </div>
    </main>
    <!-- ========== END MAIN CONTENT ========== -->
@endsection

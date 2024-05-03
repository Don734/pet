@extends('layouts.app')

@section('title', 'Авторизация')

@section('content')
    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main" class="w-full max-w-md mx-auto p-6">
        <div class="mt-7 bg-white border border-gray-200 rounded-xl shadow-sm">
            <div class="p-4 sm:p-7">
                <div class="text-center">
                    <h1 class="block text-2xl font-bold text-gray-800">Войти</h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Еще нет аккаунта?
                        <a class="text-lime-600 decoration-2 hover:underline hover:transition-all hover:duration-500 font-medium" href="{{ route('register') }}">
                            Зарегистрироваться
                        </a>
                    </p>
                </div>

                <div class="mt-5">

                    <div class="py-3 flex items-center text-xs text-gray-400 uppercase before:flex-[1_1_0%] before:border-t before:border-gray-200 before:mr-6 after:flex-[1_1_0%] after:border-t after:border-gray-200 after:ml-6">Или</div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="grid gap-y-4">
                            <!-- Form Group -->
                            <div>
                                <label for="email" class="block text-sm mb-2">Email</label>
                                <div class="relative">
                                    <input type="email" id="email" value="{{ old('email') }}" name="email" class="py-3 px-4 block w-full border-gray-200 border rounded-md text-sm focus:border-lime-600 focus:ring-lime-600" required aria-describedby="email-error">
                                    <div class="hidden absolute inset-y-0 right-0 items-center pointer-events-none pr-3">
                                        <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                        </svg>
                                    </div>
                                    @error('email')
                                        <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <!-- Form Group -->
                            <div>
                                <div class="flex justify-between items-center">
                                    <label for="password" class="block text-sm mb-2">Пароль</label>
                                    <a class="text-sm text-lime-600 decoration-2 hover:underline hover:transition-all hover:duration-500 font-medium" href="{{ route('forget.password.form') }}">Забыли пароль?</a>
                                </div>
                                <div x-data="{show: false}" class="relative">
                                    <input :type="show ? 'text' : 'password' " id="password" name="password" class="py-3 px-4 mb-[17px] w-full border-gray-200 border rounded-md text-sm focus:border-lime-600 focus:ring-lime-600" required aria-describedby="password-error">
                                    <div @click="show = !show" class="absolute inline-block bottom-7 right-5">
                                        <img x-show="!show" class="w-6 h-6" src="{{ asset('images/assets/icons/show-password.svg') }}" alt="edit">
                                        <img x-show="show" class="w-6 h-6" src="{{ asset('images/assets/icons/hide-password.svg') }}" alt="edit">
                                    </div>
                                </div>
                                @error('password')
                                    <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- End Form Group -->

                            <!-- Checkbox -->
                            <div class="flex items-center">
                                <div class="flex">
                                    <input id="remember" name="remember" type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded text-lime-600 pointer-events-none focus:ring-lime-600">
                                </div>
                                <div class="ml-3">
                                    <label for="remember" class="text-sm">Запомнить меня</label>
                                </div>
                            </div>
                            <!-- End Checkbox -->
                            @error('incorrect')
                                <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                            @if(session('success_restore'))
                                <div class="text-xs text-green-600 mt-2">
                                    {{ session('success_restore') }}
                                </div>
                            @endif
                            <button type="submit" class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-lime-600 text-white hover:bg-lime-700 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-lime-600 focus:ring-offset-2 transition-all text-sm">Войти</button>
                        </div>
                    </form>
                    <!-- End Form -->
                </div>
            </div>
        </div>
    </main>
    <!-- ========== END MAIN CONTENT ========== -->
@endsection

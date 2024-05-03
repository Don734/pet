@extends('layouts.app')

@section('content')
    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main" class="w-full max-w-md mx-auto p-6">
        <div class="mt-7 bg-white border border-gray-200 rounded-xl shadow-sm">
            <div class="p-4 sm:p-7">
                <div class="text-center">
                    <h1 class="block text-2xl font-bold text-gray-800">Восстановление пароля</h1>
                </div>

                <div class="mt-5">
                    <!-- Form -->
                    <form method="POST" action="{{ route('forget.password') }}">
                        @csrf
                        <div class="grid gap-y-4">
                            <!-- Form Group -->
                            <div>
                                <label for="email" class="block text-sm mb-2">Email</label>
                                <div class="relative">
                                    <input type="email" id="email" name="email" class="py-3 px-4 block w-full border-gray-200 border rounded-md text-sm focus:border-lime-600 focus:ring-lime-600" required aria-describedby="email-error">
                                    @error('email')
                                    <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                                    @enderror
                                    @if(session('success_restore'))
                                        <div class="text-xs text-green-600 mt-2">
                                            {{ session('success_restore') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <button type="submit" class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-lime-600 text-white hover:bg-lime-700 hover:transition-all hover:duration-500 focus:outline-none focus:ring-2 focus:ring-lime-600 focus:ring-offset-2 transition-all text-sm">Отправить</button>
                        </div>
                    </form>
                    <!-- End Form -->
                </div>
            </div>
        </div>
    </main>
    <!-- ========== END MAIN CONTENT ========== -->
@endsection

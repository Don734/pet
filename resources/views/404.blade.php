@extends('layouts.app')

@section('content')
    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main">
        <div class="flex flex-wrap content-center relative h-[500px]">
            <h1 class="flex w-full justify-center text-7xl font-bold text-white sm:text-9xl z-10 relative">404</h1>
            <p class="flex w-full justify-center mt-3 text-white z-10 relative">Страница не найдена</p>
            <div class="flex w-full justify-center text-white z-10 relative">
                <p>Но не расстраивайтесь, вы можете&nbsp;</p>
                <a href="{{ route('home') }}" class="font-semibold"> вернуться на главную</a>
            </div>
            <span class="circle big"></span>
            <span class="circle med"></span>
            <span class="circle small"></span>
        </div>
    </main>
    <!-- ========== END MAIN CONTENT ========== -->
@endsection

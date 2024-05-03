<form id="location" class="bg-white flex flex-wrap w-full rounded-3xl p-5 sm:p-10 text-gray-800">
    @csrf
    <div class="flex w-full justify-between">
        <span class="text-2xl sm:text-5xl md:text-6xl lg:text-7xl font-bold w-full">Выберите город</span>
        <a class="flex items-baseline max-[480px]:items-start hover:text-lime-600 hover:transition-all hover:duration-500 mt-[5px] cursor-pointer" hx-post="{{ route('back-to-region') }}" hx-swap="outerHTML" hx-trigger="click" hx-target="#location">
            <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 17" height="17" width="16"><g xmlns="http://www.w3.org/2000/svg" transform="matrix(-1 0 0 -1 16 17)">
                <path stroke="currentColor" d="M0.975821 9.5C0.43689 9.5 -2.41412e-08 9.05228 0 8.5C2.41411e-08 7.94771 0.43689 7.5 0.975821 7.5L12.7694 7.5L7.60447 2.20711C7.22339 1.81658 7.22339 1.18342 7.60447 0.792893C7.98555 0.402369 8.60341 0.402369 8.98449 0.792893L15.6427 7.61612C16.1191 8.10427 16.1191 8.89573 15.6427 9.38388L8.98449 16.2071C8.60341 16.5976 7.98555 16.5976 7.60447 16.2071C7.22339 15.8166 7.22339 15.1834 7.60447 14.7929L12.7694 9.5H0.975821Z" fill="currentColor" /></g>
            </svg>
            <span class="text-sm sm:text-xl font-bold whitespace-nowrap">К списку регионов</span>
        </a>
    </div>
    <div class="grid grid-cols-1 gap-4">
        <div class="flex flex-wrap">
            <span class="text-2xl md:text-3xl lg:text-4xl h-fit font-semibold w-full mt-11">{{ $region }}</span>
            <div class="flex flex-wrap mt-7">
                @foreach($cities->where('region', $region)->sortBy('name') as $city)
                    <a class="text-base font-normal w-full mb-2.5 hover:text-lime-600 hover:transition-all hover:duration-500 cursor-pointer" href="{{ route('set-city', ['city' => $city['slug']]) }}">{{ $city->name }}</a>
                @endforeach
            </div>
        </div>
    </div>
</form>
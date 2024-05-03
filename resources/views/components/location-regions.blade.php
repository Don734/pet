<form id="location" class="bg-white flex flex-wrap w-full rounded-3xl p-5 sm:p-10 text-gray-800">
    @csrf
    <span class="text-2xl sm:text-5xl md:text-6xl lg:text-7xl font-bold w-full">Выберите регион</span>
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
        @foreach($cities->sortBy('district')->pluck('district')->unique() as $district)
        <div class="flex flex-wrap content-start">
            <span class="text-2xl md:text-3xl lg:text-4xl h-fit font-semibold w-full mt-11">{{ $district }}</span>
            <div class="flex flex-wrap mt-7">
                @foreach($cities->where('district', $district)->sortBy('region')->unique('region') as $region)
                    <a class="text-base font-normal w-full mb-2.5 hover:text-lime-600 hover:transition-all hover:duration-500 cursor-pointer" hx-post="{{ route('set-region', ['region' => $region['region']]) }}" hx-swap="outerHTML" hx-trigger="click" hx-target="#location">{{ $region['region'] }}</a>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</form>
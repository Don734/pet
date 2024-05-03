<div class="rounded-xl border">
    @if ($results->count() > 0)
        <ul class="my-2">
            @foreach ($results as $result)
                <li class="px-4 py-2 hover:bg-gray-100 hover:transition-all hover:duration-500">
                    <a class="flex items-center" href="{{ route('handbooks.show', $result->id) }}">
                        {{ $result->title }}
                        @foreach ($result->categories as $category)
                <p class="ml-2 p-1 bg-gray-200 text-[10px] text-gray-400 w-fit h-fit rounded-md leading-none">
                    {{ $category->name }}
                </p>
            @endforeach
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p class="my-2 px-4 py-2 text-gray-500">Результаты не найдены</p>
    @endif
</div>
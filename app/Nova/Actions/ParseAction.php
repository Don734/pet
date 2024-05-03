<?php

namespace App\Nova\Actions;

use Alexwenzel\DependencyContainer\DependencyContainer;
use Alexwenzel\DependencyContainer\HasDependencies;
use App\Jobs\ParseTwoGisApi;
use App\Models\Category;
use App\Models\City;
use App\Services\AvitoParserService;
use App\Services\TwoGisParserService;
use App\Services\YandexParserService;
use Datomatic\Nova\Tools\DetachedActions\DetachedAction;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class ParseAction extends DetachedAction
{
    use HasDependencies;
    use InteractsWithQueue, Queueable;

    public $name = 'Парсинг данных';

    public function handle(ActionFields $fields)
    {
        if ($fields->type == 'avito')
        {
            $category = Category::find($fields->category);
            if ($category->parse_link)
            {
                $avitoParserService = new AvitoParserService();
                $avitoParserService->parseAsync($category);
                return DetachedAction::message('Задачи на парсинг успешно добавлены в очередь.');
            }
        } elseif ($fields->type == '2gis'){
            $category = Category::find($fields->category);
            ParseTwoGisApi::dispatch($fields->city, $category, $fields->start_page);

            return DetachedAction::message('Задачи на парсинг успешно добавлены в очередь.');
        } elseif ($fields->type == 'yandex') {
            $category = Category::find($fields->category);
            $yandexParserService = new YandexParserService();
            $yandexParserService->storeData(
                $yandexParserService->getOrganizations(
                    $category
                ),
                $category
            );
            return DetachedAction::message('Задачи на парсинг успешно добавлены в очередь.');
        }

        return DetachedAction::danger('Проверьте правильность данных для инициализации парсинга');
    }

    public function fields(NovaRequest $request)
    {
        return [
            Select::make('Тип', 'type')
                ->options([
                    'avito' => 'Авито',
                    'yandex' => 'Яндекс',
                    '2gis' => '2гис'
                ]),
            DependencyContainer::make([
                Select::make('Категория', 'category')
                    ->options(Category::pluck('name', 'id')),
            ])->dependsOn('type', 'avito'),
            DependencyContainer::make([
                Select::make('Категория', 'category')
                    ->options(Category::pluck('name', 'id')),
                Select::make('Город', 'city')
                    ->options(City::pluck('name', 'name')),
                Select::make('Стартовая страница', 'start_page')
                    ->options(range(1, 100))
            ])->dependsOn('type', '2gis'),
            DependencyContainer::make([
                Select::make('Категория', 'category')
                    ->options(Category::pluck('name', 'id')),
            ])->dependsOn('type', 'yandex'),
        ];
    }
}

<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Whitecube\NovaFlexibleContent\Flexible;

class Service extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Service>
     */
    public static $model = \App\Models\Service::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
    ];

    public static function label()
    {
        return 'Услуги';
    }

    public static function singularLabel()
    {
        return match (request()->editMode)
        {
            'create' => /* Создание   */ 'Услуга',
            'update' => /* Обновление */ 'услуги',
            default =>  'услуга'
        };
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Заголовок', 'title')->sortable(),
            Images::make('Изображения', 'images')
                ->hideFromIndex(),
            Textarea::make('Описание', 'description'),
            Select::make('Тип', 'type')
                ->options($this->model()::types)
                ->displayUsingLabels(),
            Flexible::make('Характеристики', 'characteristics')
                ->addLayout('Услуга', 'service', [
                    Text::make('Текст', 'text'),
                ]),
            Flexible::make('Услуги', 'services')
                ->addLayout('Услуга', 'service', [
                    Text::make('Текст', 'text'),
                ]),
            Number::make('Цена', 'price'),
            BelongsTo::make('Справочник', 'handbook', 'App\Nova\Handbook'),
            HasMany::make('Отзывы', 'reviews', 'App\Nova\Review')
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}

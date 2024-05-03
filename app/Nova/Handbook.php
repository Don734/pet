<?php

namespace App\Nova;

use App\Nova\Actions\ParseAction;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Http\Requests\NovaRequest;
use Whitecube\NovaFlexibleContent\Flexible;

class Handbook extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Handbook>
     */
    public static $model = \App\Models\Handbook::class;

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
        'id',
    ];

    public static function label()
    {
        return 'Объявления';
    }

    public static function singularLabel()
    {
        return match (request()->editMode)
        {
            'create' => /* Создание   */ 'объявления',
            'update' => /* Обновление */ 'объявления',
            default =>  'объявления'
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
            Boolean::make('Выводить в списке популярных', 'popular')
                ->nullable()
                ->hideFromIndex(),
            Text::make('Заголовок', 'title')->sortable(),
            Slug::make('Slug', 'slug')->sortable()->from('title'),
            Textarea::make('Описание', 'description'),
            Text::make('Адрес', 'address')
                ->hideFromIndex(),
            Text::make('Характеристики', 'characteristics')
                ->hideFromIndex()
                ->hideFromDetail(),
            Images::make('Изображения', 'images')
                ->hideFromIndex(),
            Text::make('Телефон', 'phone')
                ->hideFromIndex()
                ->hideFromDetail(),
            Text::make('Координата по X', 'coord_x')
                ->hideFromIndex()
                ->hideFromDetail(),
            Text::make('Координата по Y', 'coord_y')
                ->hideFromIndex()
                ->hideFromDetail(),
            Text::make('Время работы', 'working_hours')
                ->hideFromIndex()
                ->hideFromDetail(),
            BelongsTo::make('Категория', 'category', 'App\Nova\Category')
                ->hideFromDetail(function () use($request){
                    return empty($this->category);
                }),
            BelongsTo::make('Пользователь', 'client', 'App\Nova\Client')->nullable(),
            HasMany::make('Услуги', 'services', 'App\Nova\Service'),
            HasMany::make('Отзывы', 'reviews', 'App\Nova\Review'),
            KeyValue::make('Tags')->rules('json'),
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
        return [
            new ParseAction,
        ];
    }
}

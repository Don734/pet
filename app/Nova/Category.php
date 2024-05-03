<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Alexwenzel\DependencyContainer\DependencyContainer;
use Alexwenzel\DependencyContainer\HasDependencies;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Category extends Resource
{
    use HasDependencies;
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Category>
     */
    public static $model = \App\Models\Category::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

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
        return 'Категории';
    }

    public static function singularLabel()
    {
        return match (request()->editMode)
        {
            'create' => /* Создание   */ 'новой категории',
            'update' => /* Обновление */ 'категории',
            default =>  'категории'
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
            Boolean::make('Выводить в шапке', 'menu_item'),
            Images::make('Изображение', 'image'),
            Text::make('Имя', 'name')->sortable(),
            Textarea::make('Описание', 'description')->sortable(),
            Slug::make('Slug', 'slug')->from('name'),
            Text::make('Ссылка на источник для парсинга', 'parse_link')
                ->nullable(),
            HasMany::make('Объявления', 'handbooksCategories', 'App\Nova\HandbooksCategory'),


            BelongsTo::make('Родительская категория', 'parent', Category::class)
                ->nullable(),
            HasMany::make('Подкатегории', 'children', Category::class),
            Boolean::make('Выводить на главной', 'on_main'),
            DependencyContainer::make([
                Select::make('Тип карточки', 'card_type')
                    ->options([
                        'rectangle' => 'Квадратные',
                        'round' => 'Круглые'
                        ]),
            ])->dependsOn('on_main', true),
            Select::make('Тип кнопки', 'button_type')
                ->options([
                    'reservation' => 'Бронь',
                    'appointment' => 'Запись',
                    'address' => 'Только адрес',
                    'product' => 'Товар'
                    ]),
            Boolean::make('Выводить на слайдере', 'on_swiper'),
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

<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Review extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Review>
     */
    public static $model = \App\Models\Review::class;

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
        'content',
    ];

    public static function label()
    {
        return 'Отзывы';
    }

    public static function singularLabel()
    {
        return match (request()->editMode)
        {
            'create' => /* Создание   */ 'нового отзыва',
            'update' => /* Обновление */ 'отзыва',
            default =>  'отзыва'
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
            Boolean::make('Опубликовать', 'is_published'),
            Text::make('Имя', 'name'),
            Text::make('Комментарий', 'comment'),
            Number::make('Оценка', 'rating')
                ->help('Введите оценку от 1 до 5')
                ->rules('required', 'numeric', 'min:1', 'max:5'),
            MorphTo::make('Сущность', 'reviewable')->types([
                Handbook::class,
                Service::class,
            ]),
            BelongsTo::make('Пользователь', 'Client', 'App\Nova\Client')
                ->nullable(),
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

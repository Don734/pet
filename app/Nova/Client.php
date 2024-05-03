<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Spatie\Image\Image;

class Client extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Client>
     */
    public static $model = \App\Models\Client::class;

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
        return 'Клиенты';
    }

    public static function singularLabel()
    {
        return match (request()->editMode)
        {
            'create' => /* Создание   */ 'новго клиента',
            'update' => /* Обновление */ 'клиента',
            default =>  'клиента'
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
            Images::make('Изображение', 'image'),
            Text::make('ФИО', 'name')
                ->rules('required')
                ->hideFromIndex()
                ->sortable(),
            Text::make('Телефон', 'phone')
                ->sortable(),
            Text::make('Почта', 'email')
                ->exceptOnForms(),
            Select::make('type')
                ->options([
                    'customer' => 'Клиент',
                    // 'partner' => 'Партнер'
                ]),
            new Panel('Данные для авторизации', $this->authFields()),

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

    protected function authFields()
    {
        return [
            Text::make('Э-почта', 'email')
                ->onlyOnForms(),
            Password::make('Пароль', 'password')
                ->updateRules('nullable', PasswordRule::defaults())
                ->creationRules('required', PasswordRule::defaults())
                ->onlyOnForms(),
        ];
    }
}

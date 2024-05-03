@component('mail::message')

    Пожалуйста, перейдите по ссылке для восстановления пароля:

    @component('mail::button', ['url' => $token, 'color' => 'success'])
        Сменить пароль
    @endcomponent

    С уважением,<br>
    {{ config('app.name') }}
@endcomponent

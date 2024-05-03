@component('mail::message')
# Спасибо за регистрацию!

Пожалуйста, перейдите по ссылке для завершения регистрации:

@component('mail::button', ['url' => $confirmationUrl, 'color' => 'success'])
    Завершить регистрацию
@endcomponent

Если вы не регистрировались на нашем сайте, пожалуйста, проигнорируйте это письмо.

С уважением,
{{ config('app.name') }}
@endcomponent

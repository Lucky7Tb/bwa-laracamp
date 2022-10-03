@component('mail::message')
# Welcome!

Hi {{ $user->name }}

<br>
Welcome to laracamp, your account has been created successfully. Now you can choose you best match camp!

@component('mail::button', ['url' => route('login')])
Login here
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

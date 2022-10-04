@component('mail::message')
# Your transaction has been confirmed

Hi {{ $checkout->user->name }}
<br>
Your transaction has been confirmed. now you can enjoy the benefit of <b>{{ $checkout->camp->title }}</b> camp

@component('mail::button', ['url' => 'user.view.dashboard'])
My dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

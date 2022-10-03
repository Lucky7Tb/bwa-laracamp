@component('mail::message')
# Register camp {{ $checkout->camp->title }}

Hi {{ $checkout->User->name }}
<br>
Thank you for register on <b>{{ $checkout->camp->title }}</b>, please see payment instruction by click the button below.

@component('mail::button', ['url' => route('view.checkout.invoice', $checkout->id)])
Get invoice
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
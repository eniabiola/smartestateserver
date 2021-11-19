@component('mail::message')
Dear {{ $maildata['name'] }}

{!! $maildata['message'] !!}

@component('mail::panel')
    Your logging details below:
    Email: {{ $maildata['email'] }}
    Password: {{ $maildata['password'] }}
@endcomponent

@component('mail::button', ['url' => $maildata['url']])
Login to dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

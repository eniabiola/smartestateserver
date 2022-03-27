@component('mail::message')
Dear {{ $maildata['name'] }}

{!! $maildata['message'] !!}

@component('mail::panel')
    Your log in details below:
    Email: {{ $maildata['email'] }}
    Password: {{ $maildata['password'] }}
@endcomponent

@component('mail::button', ['url' => $maildata['url']])
Login to dashboard
@endcomponent

Thanks,<br>
{{ $maildata['from'] }}
@endcomponent

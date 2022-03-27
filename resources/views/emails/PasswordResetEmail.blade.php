@component('mail::message')
Dear {{ $maildata['name'] }}

{!! $maildata['message'] !!}

@component('mail::button', ['url' => $maildata['url']])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

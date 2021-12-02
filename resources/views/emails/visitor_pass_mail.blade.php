@component('mail::message')
Dear {{ $maildata['user'] }}

{!! $maildata['message'] !!}


Thanks,<br>
{{ config('app.name') }}
@endcomponent

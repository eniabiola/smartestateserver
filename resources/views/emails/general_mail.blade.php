@component('mail::message')
Dear {{ $maildata['name'] }}

{{$maildata['message']}}

@if($maildata['url'])
@component('mail::button', ['url' => $maildata["url"]])
Button Text
@endcomponent
@endif
Thanks,<br>
{{ config('app.name') }}
@endcomponent

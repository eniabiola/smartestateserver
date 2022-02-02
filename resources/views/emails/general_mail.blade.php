@component('mail::message')
Dear {{ $maildata['name'] }}

{{$maildata['message']}}

@if($maildata['url'])
    @component('mail::button', ['url' => $maildata["url"]])
    {{$maildata["button_text"]}}
    @endcomponent
@endif
Thanks,<br>
{{ config('app.name') }}
@endcomponent

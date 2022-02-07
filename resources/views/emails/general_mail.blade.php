@component('mail::message')
Dear {{ $maildata['name'] }}

{{$maildata['message']}}

@if(\Illuminate\Support\Arr::exists($maildata, 'url'))
    @component('mail::button', ['url' => $maildata["url"]])
    {{$maildata["button_text"]}}
    @endcomponent
@endif
Thanks,<br>
{{ $maildata["from"] }}
@endcomponent

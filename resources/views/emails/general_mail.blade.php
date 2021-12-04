@component('mail::message')
Dear {{ $maildata['name'] }}

{{$maildata['message']}}

{{--@component('mail::button', ['url' => ''])
Button Text
@endcomponent--}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent

@component('mail::message')
Dear {{ $maildata['surname']." ".$maildata['othernames'] }}

We welcome you to {{ $maildata['estate'] }}

Your login email is {{$maildata['email']}}
And Password is as set.

To login to your dashbord please click
@component('mail::button', ['url' => 'http://dev.smartestateapp.com/auth/login'])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

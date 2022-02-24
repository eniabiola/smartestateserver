@component('mail::message')
Dear {{ $maildata['surname']." ".$maildata['othernames'] }}

We welcome you to {{ $maildata['estate'] }}

Your login email is {{$maildata['email']}}
And Password is as set.

To login to your dashbord please click the activate link below
@component('mail::button', ['url' => config("url_constants.front_end_url").'/auth/login'])
Activate
@endcomponent

Thank You,<br>
{{ config('app.name') }}
@endcomponent

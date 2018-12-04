@component('mail::message')
# Introduction
Hola {{ $user->name }}
Et donem la Benvinguda ala nostra web de tasques!
@component('mail::button', ['url' => ''])
Button Text
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent
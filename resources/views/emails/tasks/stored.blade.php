@component('mail::message')
La Tasca <b>{{ $task->name }}</b> ha estat creada.
@component('mail::button', ['url' => url('/tasques')])
Veure tasca
@endcomponent
Gracies,<br>
{{ config('app.name') }}
@endcomponent

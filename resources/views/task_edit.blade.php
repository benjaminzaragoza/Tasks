@extends('layouts.app')

@section('title')
    Tasques
@endsection
@section('content')
<form action="/tasks/{{$task->id}}" method="POST">
    @csrf
    {{ method_field('PUT') }}
    <h4>Taska modifica:</h4> <input name="name" type="text" value="{{$task->name}}">
    {{--// CHECKBOX--}}
    {{--Completed:--}}
    {{--@if ( $task->completed )--}}
    {{--<input name="completed" type="checkbox" checked>--}}
    {{--@else--}}
    {{--<input name="completed" type="checkbox">--}}
    {{--@endif--}}
    <v-btn color="success">
    <button>Editar</button>
    </v-btn>
</form>
@endsection
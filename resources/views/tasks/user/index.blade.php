@extends('layouts.app')

@section('content')
    {{--<tasques :tasks="{{ $tasks }}" :uri="{{ $uri }}"></tasques>--}}
    <tasques :tasks="{{ $tasks }}" ></tasques>
@endsection
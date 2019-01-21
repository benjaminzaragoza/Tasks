@extends('layouts.app')
@section('title')
Registre d'activitats
@endsection
@section('content')
    <changelog :logs="{{ $logs }}" :users="{{ $users }}"></changelog>
@endsection

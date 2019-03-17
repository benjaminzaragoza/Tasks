@extends('layouts.app')
@section('title')
    NewsLetter
@endsection
@section('content')
    <newsletters :newsletter="{{ $newsletter }}"></newsletters>
@endsection

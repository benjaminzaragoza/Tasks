@extends('layouts.app')

@section('title')
    Funcions Vue
@endsection

@section('content')
    <h1 style="color: black">Mobile Functions</h1>

    <div class="main-wrapper" style="margin-top: 2%">
        <geolocation class="material-icons "></geolocation>
        <orientation class="material-icons " ></orientation>
        <vibrate class="material-icons" ></vibrate>
        <network class="material-icons" ></network>
        <battery class="material-icons" ></battery>
        <memory class="material-icons" ></memory>
    </div>

@endsection

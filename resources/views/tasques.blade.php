@extends('layouts.app')
@section('title')
    Tasques amb Vue
@endsection
@section('content')
    <v-container fluid>
    <v-layout>
        <v-flex class="mt-5">
            <tasques :tasks="{{$tasks}}" :users="{{$users}}" uri="{{$uri}}"></tasques>
        </v-flex>
    </v-layout>
    </v-container>
@endsection
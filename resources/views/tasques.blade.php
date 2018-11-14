@extends('layouts.app')

@section('content')
    <v-container fluid>
    <v-layout>
        <v-flex class="mt-5">
            <tasques :tasks="{{$tasks}}" :users="{{$users}}"></tasques>
        </v-flex>
    </v-layout>
    </v-container>
@endsection
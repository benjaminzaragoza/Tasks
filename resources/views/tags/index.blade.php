@extends('layouts.app')
@section('content')
    <v-container fluid>
        <v-layout>
            <v-flex class="mt-5">
                <tags :tags="{{$tags}}" uri="{{$uri}}" ></tags>
            </v-flex>
        </v-layout>
    </v-container>
@endsection()
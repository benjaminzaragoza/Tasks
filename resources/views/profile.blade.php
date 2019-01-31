@extends('layouts.app')
@section('title')
    Perfil
@endsection
@section('content')
    <v-container fluid>
        <v-layout>
            <v-flex>
                <profile :user="{{ $user }}"></profile>
            </v-flex>
        </v-layout>
    </v-container>
@endsection

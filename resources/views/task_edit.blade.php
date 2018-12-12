@extends('layouts.app')

@section('title')
    Edit Tasques
@endsection
@section('content')
    <v-container>
        <v-layout row wrap>
            <v-flex xs12 sm8 offset-sm2 align-center justify-center>
                <v-card class="elevation-12">
                    <v-toolbar  dark color="pink">
                        <v-toolbar-title>Editar</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                        <v-container>
                            <form action="/tasks/{{$task->id}}" method="POST" >
                                @csrf
                                {{ method_field('PUT') }}
                                <v-layout row>
                                    <v-flex xs12>
                                        <v-text-field
                                                name="name"
                                                label="Tasca a editar"
                                                value="{{$task->name}}"
                                        ></v-text-field>
                                    </v-flex>
                                </v-layout>
                                <v-layout row xs12>
                                    <v-flex>
                                        <v-btn color="success">
                                            <button>Editar</button>
                                        </v-btn>
                                    </v-flex>
                                </v-layout>
                            </form>
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>


{{--<form action="/tasks/{{$task->id}}" method="POST">--}}
    {{--@csrf--}}
    {{--{{ method_field('PUT') }}--}}
    {{--<h4>Taska modifica:</h4> <input name="name" type="text" value="{{$task->name}}">--}}
    {{--// CHECKBOX--}}
    {{--Completed:--}}
    {{--@if ( $task->completed )--}}
    {{--<input name="completed" type="checkbox" checked>--}}
    {{--@else--}}
    {{--<input name="completed" type="checkbox">--}}
    {{--@endif--}}
    {{--<v-btn color="success">--}}
    {{--<button>Editar</button>--}}
    {{--</v-btn>--}}
{{--</form>--}}
@endsection
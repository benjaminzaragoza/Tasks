@extends('layouts.app')

@section('title')
    Tasques PHP
@endsection
@section('content')
    <v-card>
        <v-toolbar dark color="blue accent-4" dark>

            <v-toolbar-title color="black">Tasques</v-toolbar-title>
        </v-toolbar>

        <v-list>

            <form action="/tasks" method="POST">
                @csrf

                <v-layout row right xs10>
                    <v-flex p>
                        <v-btn fab dark color="light-green accent-4
" >
                            <v-icon style="margin-top: -11px" dark>add</v-icon>
                            <button>Afegir</button>
                        </v-btn>
                    </v-flex>
                    <v-flex x1 class="pt-3">
                        <v-text-field  name="name" type="text" placeholder="Crear tasca" required
                         label="Tasques" name="Services" hint="Ex. Consultation" type="text" ></v-text-field>
                    </v-flex>
                </v-layout>

            </form>
            <br>
            <?php foreach ($tasks as $task) : ?>
            <v-list-tile >
                <v-list-tile-avatar>
                    <img src="http://www.iconarchive.com/download/i78247/igh0zt/ios7-style-metro-ui/MetroUI-Other-Task.ico">
                </v-list-tile-avatar>
                @if($task->completed)
                    <del>{{ $task->name}}</del>
                    <form action="/completed_task/{{ $task->id }}" method="POST">
                        @csrf
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="id" value="{{ $task->id  }}">
                        <v-btn type="submit" dark color="warning">
                            <button>Descompletar</button>
                        </v-btn>
                    </form>
                    <form action="/tasks/{{ $task->id }}" method="POST">
                        @csrf
                        {{ method_field('DELETE') }}
                        <v-btn  color="error">
                            <button>Eliminar</button>
                        </v-btn>

                    </form>

                @else
                    {{ $task->name }}

                    <form action="/completed_task/{{ $task->id }}" method="POST">
                        @csrf

                        <input type="hidden" name="id" value="{{ $task->id  }}">
                        <v-btn type="submit" dark color="cyan" >
                            <button>Completar</button>
                        </v-btn>
                    </form>

                    <v-btn  type="submit" dark color="pink lighten-1" href="/task_edit/{{ $task->id }}">
                        <button>Modificar</button>
                    </v-btn>
                    <form action="/tasks/{{ $task->id }}" method="POST">
                        @csrf
                        {{ method_field('DELETE') }}
                        <v-btn type="submit" dark color="red darken-1">
                            <button>Eliminar</button>
                        </v-btn>
                    </form>
                @endif
            </v-list-tile>
            <br>
            <?php endforeach;?>


        </v-list>

    </v-card>
@endsection

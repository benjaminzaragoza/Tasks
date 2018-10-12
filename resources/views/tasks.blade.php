@extends('layouts.app')

@section('title')
    Tasques
@endsection
@section('content')
    <v-card>
        <v-toolbar color="cyan" dark>

            <v-toolbar-title color="black">Tasques</v-toolbar-title>
        </v-toolbar>

        <v-list>

            <form action="/tasks" method="POST">
                @csrf

                <v-layout row right xs10>
                    <v-flex p>
                        <v-btn  fab dark color="green accent-2" >
                            <v-icon dark>add</v-icon>
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
            <v-list-tile>
                <v-list-tile-avatar>
                    <img src="http://www.iconarchive.com/download/i78247/igh0zt/ios7-style-metro-ui/MetroUI-Other-Task.ico">
                </v-list-tile-avatar>
                @if($task->completed)
                    <del>{{ $task->name }}</del>

                    <form action="/tasks/{{ $task->id }}" method="POST">
                        @csrf
                        {{ method_field('DELETE') }}
                        <v-btn color="error">
                            <button>Eliminar</button>
                        </v-btn>

                    </form>

                @else
                    {{ $task->name }}

                    <form action="" method="POST">
                        @csrf
                        {{ method_field('PUT') }}
                        <input type="hidden" name="id" value="{{ $task->id  }}">
                        <v-btn color="primary">
                            <button>Completar</button>
                        </v-btn>
                    </form>

                    <v-btn color="warning" href="/task_edit/{{ $task->id }}">
                        <button>Modificar</button>
                    </v-btn>
                    <form action="/tasks/{{ $task->id }}" method="POST">
                        @csrf
                        {{ method_field('DELETE') }}
                        <v-btn color="error">
                            <button >Eliminar</button>
                        </v-btn>
                    </form>
                @endif
            </v-list-tile>
            <br>
            <?php endforeach;?>


        </v-list>

    </v-card>
@endsection

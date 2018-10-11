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
                <input name="name" type="text" placeholder="Crear tasca" required>
                <v-btn color="success">
                    <button>Afegir</button>
                </v-btn>
            </form>
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
                            <button>Eliminar</button>
                        </v-btn>
                    </form>
                @endif
            </v-list-tile>
            <?php endforeach;?>


        </v-list>

    </v-card>
@endsection

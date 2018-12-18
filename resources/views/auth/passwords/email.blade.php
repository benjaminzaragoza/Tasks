@extends('layouts.login')
@section('title')
    Reseteijar Contrasenya
@endsection
@section('content')

    @if (session('status'))
        <v-alert type="success" :value="true">
            {{ session('status') }}
        </v-alert>
    @endif
    <v-container fluid fill-height>
        <v-layout align-center justify-center>
    <v-flex xs12 sm4 class="mt-5" >
        <v-card class="elevation-12" >
            <v-toolbar color="red lighten-1" dark>
                <v-toolbar-title>
                    {{ __('Resetejar Password') }}
                </v-toolbar-title>
                <v-spacer></v-spacer>
            </v-toolbar>

            <v-form method="POST" action="{{ route('password.email') }}">
                <v-card-text>
                    @csrf
                    <v-text-field
                            prepend-icon="person"
                            label="{{ __('E-Mail') }}"
                            name="email"
                            type="email"
                    ></v-text-field>
                    <v-card-actions>
                        <v-btn href="/" type="submit" color="primary">
                            <v-icon class="mr-2" >home</v-icon>
                        </v-btn>
                        <v-spacer></v-spacer>
                        <v-btn
                                color="green"
                                class="white--text"
                                type="submit"
                        >
                            {{ __('Enviar') }}
                            <v-icon right dark>send</v-icon>
                        </v-btn>
                    </v-card-actions>
                </v-card-text>
            </v-form>
        </v-card>
    </v-flex>
        </v-layout>
    </v-container>
@endsection
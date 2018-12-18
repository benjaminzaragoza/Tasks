@extends('layouts.login')

@section('content')

    <v-flex xs12 sm4 offset-sm4 class="mt-5">
        <v-card class="elevation-12">
            <v-toolbar color="red lighten-1" dark>
                <v-toolbar-title>
                    {{ __('Reset Password') }}
                </v-toolbar-title>
            </v-toolbar>
            <v-form method="POST" action="{{ route('password.update') }}">
                <v-card-text>
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <v-text-field
                            prepend-icon="person"
                            label="{{ __('E-Mail Address') }}"
                            name="email"
                            type="email"
                    ></v-text-field>

                    <v-text-field
                            prepend-icon="lock"
                            label="{{ __('Password') }}"
                            name="password"
                            type="password"
                    ></v-text-field>

                    <v-text-field
                            prepend-icon="lock"
                            label="{{ __('Password Confirmation') }}"
                            name="password_confirmation"
                            type="password"
                    ></v-text-field>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue lighten-1" dark type="submit">
                            {{ __('Reset Password') }}
                        </v-btn>
                    </v-card-actions>
                </v-card-text>
            </v-form>
        </v-card>
    </v-flex>
@endsection
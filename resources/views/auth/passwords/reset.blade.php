@extends('layouts.login')
@section('title', config('app.name').' - '.__('Reset Password'))

@section('title')
    Nova Contrasenya
@endsection
@section('content')
@section('title', config('app.name').' - '.__('Reset Password'))
<v-container fluid fill-height>
    <v-layout align-center justify-center>
        <v-flex xs12 sm4>
            <v-card class="elevation-12">
                <v-toolbar color="primary lighten-1" dark>
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
                                error-messages="{{ $errors->first('email') }}"
                                value="{{ old('email') }}"
                        ></v-text-field>

                        <v-text-field
                                prepend-icon="lock"
                                label="{{ __('Password') }}"
                                name="password"
                                type="password"
                                error-messages="{{ $errors->first('password') }}"
                        ></v-text-field>

                        <v-text-field
                                prepend-icon="lock"
                                label="{{ __('Password Confirmation') }}"
                                name="password_confirmation"
                                type="password"
                                error-messages="{{ $errors->first('password_confirmation') }}"
                        ></v-text-field>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                                color="green"
                                class="white--text"
                                type="submit"
                        >
                            {{ __('Reset') }}
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
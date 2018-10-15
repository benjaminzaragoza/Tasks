@extends('layouts.app')

@section('content')
    <v-layout>
        <v-flex xs12 sm6 offset-sm3 >
            <v-card >
                <v-img
                        style="margin-top: 5%;"
                        src="https://www.icot.es/wp-content/uploads/2016/12/informatica-profesional.jpg"
                        aspect-ratio="1.75"
                ></v-img>

                <v-card-title primary-title>
                    <div>
                        <h3  style="float: left;" class="headline mb-1 " >Qui som i que fem ?</h3>
                        <br>
                        <br>
                        <div>Estem desarrollan una web de taskes per la administracio i el control de taskes ...</div>
                    </div>
                </v-card-title>

                <v-card-actions>
                    <v-btn flat color="blue" href="https://github.com/benjaminzaragoza">Saber mes</v-btn>
                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
@endsection

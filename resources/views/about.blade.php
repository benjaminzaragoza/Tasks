@extends('layouts.app')
@section('title')
    Sabem mes?
@endsection
@section('content')
    <v-layout>
        <v-flex xs12 sm6 offset-sm3 >
            <v-card >
                <v-img
                        style="margin-top: 5%;"
                        src="https://d2v9y0dukr6mq2.cloudfront.net/video/thumbnail/BRDf5QkViozx5sck/artificial-intelligence-concept_beunyf0-x_thumbnail-full01.png"
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
                    <v-btn flat color="blue" class=" font-weight-bold text-xs-center" href="https://github.com/benjaminzaragoza">Saber mes</v-btn>
                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
@endsection

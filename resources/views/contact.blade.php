@extends('layouts.app')

@section('content')
        <v-carousel>
            <v-carousel-item
                    v-for="(item,i) in items"
                    :key="i"
                    :src="item.src"
            ></v-carousel-item>
        </v-carousel>
@endsection
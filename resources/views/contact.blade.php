@extends('layouts.app')

@section('content')
    <br>
    <br>
        <v-carousel style="width: 90%; margin-left: 5%;height: 80%;margin-top: -2%;">
            <v-carousel-item
                    v-for="(item,i) in items"
                    :key="i"
                    :src="item.src"
            ></v-carousel-item>
        </v-carousel>
        <br>
    <br>
        <v-layout
                align-center
                justify-space-around
                wrap
        >
            <v-avatar color="indigo" >
                <v-icon dark >account_circle</v-icon>
            </v-avatar>

            <v-avatar>
                <img
                        src="https://avatars3.githubusercontent.com/u/23049441?s=400&u=5c5dc952dffe0ce6a6dbe84efd9ddca2dea87622&v=4"
                        alt="Benjamin"
                >
            </v-avatar>

            <v-badge overlap>
                <span slot="badge">3</span>

                <v-avatar
                        color="purple red--after"
                >
                    <v-icon dark>notifications</v-icon>
                </v-avatar>
            </v-badge>

            <v-avatar color="teal">
                <span class="white--text headline">B</span>
            </v-avatar>

            <v-avatar color="red">
                <span  class="white--text headline">Z</span>
            </v-avatar>
        </v-layout>
@endsection
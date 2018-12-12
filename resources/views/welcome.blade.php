@extends('layouts.landing')
@section('title')
    Benvingut a Tasques
@endsection
@section('content')
    <v-app light>
    <v-toolbar class="white">
            @auth
            <h1 class="primary--text mb-2 font-weight-bold font-italic text-xs-center">Tasques de {{(Auth::user()->name)}}</h1>&nbsp;&nbsp;&nbsp;&nbsp;<img src="img/task.png" height="40">
            @else
                <h1 class="primary--text mb-2 font-weight-bold font-italic text-xs-center">Tasques</h1>&nbsp;&nbsp;&nbsp;&nbsp;<img src="img/task.png" height="40">
            @endauth
        <v-spacer></v-spacer>
            <div class="top-right links">
                @auth
                    <v-layout>
                        <v-avatar @click="drawerRight=!drawerRight" style="margin-top: 2%;" title="{{Auth::user()->name}}({{(Auth::user()->email)}} )">
                            <img src="https://www.gravatar.com/avatar/{{md5(Auth::user()->email)}} " alt="avatar" style="margin-right: 60%;margin-top: -11%;">
                        </v-avatar>
                        <v-layout>
                            @impersonating
                                <v-avatar title="{{ Auth::user()->impersonatedBy()->name }} ( {{ Auth::user()->email }} )" style="margin-top: 10%;">
                                    <img src="https://www.gravatar.com/avatar/{{ md5(Auth::user()->impersonatedBy()->email) }}" alt="avatar" style="margin-right: 36%;margin-top: 11%;">
                                </v-avatar>
                            @endImpersonating
                            <v-flex xs12 style="margin-top: 1%">
                                @canImpersonate
                                <impersonate label="Entrar com..." url="/api/v1/regular_users"></impersonate>
                                @endCanImpersonate
                            </v-flex>
                        </v-layout>
                        @impersonating
                        <a style="margin-top: 3%;" href="impersonate/leave">Abandonar la suplantació</a>
                        @endImpersonating
                    <v-form style="margin-top: 1%">
                        <v-btn class=" font-weight-bold text-xs-center" color="primary" href="{{ url('home') }}"><v-icon>assignment</v-icon>&nbsp;Tasques</v-btn>
                    </v-form>
                    <v-form style="margin-top: 1%" action="logout" method="POST" >
                        @csrf
                        <v-btn type="submit" medium color="red">
                            <v-icon color="white" large >exit_to_app</v-icon>
                        </v-btn>
                    </v-form>
                        </v-layout>
                        @else
                    <v-btn color="primary" class=" font-weight-bold text-xs-center" href="{{ route('login') }}">Login</v-btn>
                    <v-btn color="primary" class=" font-weight-bold text-xs-center" href="{{ route('register') }}">Register</v-btn>
                @endauth
            </div>
    </v-toolbar>
    <v-content style="margin-top: 0%;">
        <section>
            <v-parallax src="img/paper.jpg" height="720">
                <v-layout column align-center justify-center class="white--text" >
                    <img src="img/task.png" alt="Vuetify.js" height="200">
                    <h1 class="black--text mb-2 display-1 text-xs-center " style="margin-top: 4%;" ><strong>Tasques i Tags amb Vue</strong></h1>
                    <div class=" black--text subheading mb-3 text-xs-center"><strong>by Benjamin Zaragoza Pla<strong></strong></div>
                    <v-layout>
                    <v-btn
                            class="light-blue darken-4 lighten-2 mt-5 font-weight-bold text-xs-center text-uppercase"
                            dark
                            large
                            href="/home"
                    >
                        Tasques Go
                    </v-btn>
                    <v-btn depressed
                           class="dark mt-5"
                           target="_blank"
                           large
                           href="https://github.com/benjaminzaragoza/Tasks"
                    ><img src="img/github.png" alt="Github" height="65">
                    </v-btn>
                    </v-layout>
            </v-parallax>
        </section>

        <section>
            <v-layout
                    column
                    wrap
                    class="my-5"
                    align-center
            >
                <v-flex xs12 sm4 class="my-3">
                    <div class="text-xs-center">
                        <h2 class="headline">The best way to start developing</h2>
                        <span class="subheading">
                Cras facilisis mi vitae nunc
              </span>
                    </div>
                </v-flex>
                <v-flex xs12 style="margin-top: -11%;">
                    <v-container grid-list-xl>
                        <v-layout row wrap align-center>
                            <v-flex xs12 md4>
                                <v-card class="elevation-0 transparent">
                                    <v-card-text class="text-xs-center">
                                        <v-icon x-large class="blue--text text--lighten-2">assignment</v-icon>
                                    </v-card-text>
                                    <v-card-title primary-title class="layout justify-center">
                                        <div class="headline text-xs-center">Material Design</div>
                                    </v-card-title>
                                    <v-card-text>
                                        Cras facilisis mi vitae nunc lobortis pharetra. Nulla volutpat tincidunt ornare.
                                        Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                                        Nullam in aliquet odio. Aliquam eu est vitae tellus bibendum tincidunt. Suspendisse potenti.
                                    </v-card-text>
                                </v-card>
                            </v-flex>
                            <v-flex xs12 md4>
                                <v-card class="elevation-0 transparent">
                                    <v-card-text class="text-xs-center">
                                        <v-icon x-large class="blue--text text--lighten-2">assignment_turned_in</v-icon>
                                    </v-card-text>
                                    <v-card-title primary-title class="layout justify-center">
                                        <div class="headline">Fast development</div>
                                    </v-card-title>
                                    <v-card-text>
                                        Cras facilisis mi vitae nunc lobortis pharetra. Nulla volutpat tincidunt ornare.
                                        Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                                        Nullam in aliquet odio. Aliquam eu est vitae tellus bibendum tincidunt. Suspendisse potenti.
                                    </v-card-text>
                                </v-card>
                            </v-flex>
                            <v-flex xs12 md4>
                                <v-card class="elevation-0 transparent">
                                    <v-card-text class="text-xs-center">
                                        <v-icon x-large class="blue--text text--lighten-2">assessment</v-icon>
                                    </v-card-text>
                                    <v-card-title primary-title class="layout justify-center">
                                        <div class="headline text-xs-center">Completely Open Sourced</div>
                                    </v-card-title>
                                    <v-card-text>
                                        Cras facilisis mi vitae nunc lobortis pharetra. Nulla volutpat tincidunt ornare.
                                        Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                                        Nullam in aliquet odio. Aliquam eu est vitae tellus bibendum tincidunt. Suspendisse potenti.
                                    </v-card-text>
                                </v-card>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-flex>
            </v-layout>
        </section>

        <section style="margin-top: -31%;">
            <v-parallax src="img/task2.jpg" height="480">
                <v-layout column align-center justify-center>
                    {{--<v-btn--}}
                            {{--class="blue lighten-2 mt-5"--}}
                            {{--dark--}}
                            {{--large--}}
                            {{--href="/home"--}}
                    {{-->--}}
                        {{--Start!--}}
                    {{--</v-btn>--}}
                    <v-btn large color="primary"
                            href="/home"
                    >
                        <v-icon large left>favorite</v-icon>
                        Start Experience
                    </v-btn>
                </v-layout>
            </v-parallax>
        </section>

        <section>
            <v-container grid-list-xl>
                <v-layout row wrap justify-center class="my-5">
                    <v-flex xs12 sm4>
                        <v-card class="elevation-0 transparent">
                            <v-card-title primary-title class="layout justify-center">
                                <div class="headline">Company info</div>
                            </v-card-title>
                            <v-card-text>
                                Cras facilisis mi vitae nunc lobortis pharetra. Nulla volutpat tincidunt ornare.
                                Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                                Nullam in aliquet odio. Aliquam eu est vitae tellus bibendum tincidunt. Suspendisse potenti.
                            </v-card-text>
                        </v-card>
                    </v-flex>
                    <v-flex xs12 sm4 offset-sm1>
                        <v-card class="elevation-0 transparent">
                            <v-card-title primary-title class="layout justify-center">
                                <div class="headline">Contact us</div>
                            </v-card-title>
                            <v-card-text>
                                Cras facilisis mi vitae nunc lobortis pharetra. Nulla volutpat tincidunt ornare.
                            </v-card-text>
                            <v-list class="transparent">
                                <v-list-tile>
                                    <v-list-tile-action>
                                        <v-icon class="blue--text text--lighten-2">phone</v-icon>
                                    </v-list-tile-action>
                                    <v-list-tile-content>
                                        <v-list-tile-title>777-867-5309</v-list-tile-title>
                                    </v-list-tile-content>
                                </v-list-tile>
                                <v-list-tile>
                                    <v-list-tile-action>
                                        <v-icon class="blue--text text--lighten-2">place</v-icon>
                                    </v-list-tile-action>
                                    <v-list-tile-content>
                                        <v-list-tile-title>Chicago, US</v-list-tile-title>
                                    </v-list-tile-content>
                                </v-list-tile>
                                <v-list-tile>
                                    <v-list-tile-action>
                                        <v-icon class="blue--text text--lighten-2">email</v-icon>
                                    </v-list-tile-action>
                                    <v-list-tile-content>
                                        <v-list-tile-title>john@vuetifyjs.com</v-list-tile-title>
                                    </v-list-tile-content>
                                </v-list-tile>
                            </v-list>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </section>

        <v-footer class="blue darken-2">
            <v-layout row wrap align-center>
                <v-flex xs12>
                    <div class="white--text ml-3">
                        Made with
                        <v-icon class="red--text">favorite</v-icon>
                        by <a class="white--text" href="https://vuetifyjs.com" target="_blank">Vuetify</a>
                        and <a class="white--text" href="https://github.com/vwxyzjn">Costa Huang</a>
                    </div>
                </v-flex>
            </v-layout>
        </v-footer>
    </v-content>
    </v-app>
@endsection
<script>
  import VInput from "vuetify/lib/components/VInput/VInput"
  export default {
    components: {VInput}
  }
  import VToolbar from "vuetify/src/components/VToolbar/VToolbar"
  export default {
    components: {VToolbar}
  }
</script>
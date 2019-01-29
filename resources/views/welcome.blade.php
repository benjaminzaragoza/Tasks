@extends('layouts.landing')
@section('title')
    Benvingut a Tasques
@endsection
@section('content')
    <v-app light>
    <v-toolbar class="white">
            @auth
            <p class="primary--text mb-2 font-weight-bold font-italic text-xs-center hidden-sm-and-down" style="font-size:20px ;margin-right: 1%">Tasques de {{(Auth::user()->name)}}</p><img src="img/task.png" height="40">
            @else
            <v-toolbar-title class="primary--text mb-2 font-weight-bold font-italic text-xs-center hidden-sm-and-down" >Tasques</v-toolbar-title><img style="padding-left: 2%" src="img/task.png" height="40">
            @endauth
        <v-spacer></v-spacer>
                @if (Route::has('login'))
                @auth
                        <div style="margin-left: 40%">
                    <v-layout >
                        <v-avatar @click="drawerRight=!drawerRight" style="margin-top: 2%;" title="{{Auth::user()->name}}({{(Auth::user()->email)}} )">
                            <img src="https://www.gravatar.com/avatar/{{md5(Auth::user()->email)}} " alt="avatar" style="margin-right: 60%;margin-top: -11%;">
                        </v-avatar>
                        <v-layout class="hidden-sm-and-down">
                            @impersonating
                                <v-avatar title="{{ Auth::user()->impersonatedBy()->name }} ( {{ Auth::user()->email }} )" style="margin-top: 10%;">
                                    <img src="https://www.gravatar.com/avatar/{{ md5(Auth::user()->impersonatedBy()->email) }}" alt="avatar" style="margin-right: 36%;margin-top: 11%;">
                                </v-avatar>
                            @endImpersonating
                            <v-flex xs16 style="margin-top: 1%">
                                @canImpersonate
                                <impersonate label="Entrar com..." url="/api/v1/regular_users"></impersonate>
                                @endCanImpersonate
                            </v-flex>
                        </v-layout>
                        @impersonating
                        <a class="hidden-sm-and-down" style="margin-top: 3%;" href="impersonate/leave">Abandonar la suplantació</a>
                        @endImpersonating
                    <v-form style="margin-top: 1%">
                        <v-btn class=" font-weight-bold text-xs-center hidden-sm-and-down" color="primary" href="{{ url('home') }}"><v-icon>assignment</v-icon>&nbsp;Tasques</v-btn>
                    </v-form>
                    <v-form style="margin-top: 1%" action="logout" method="POST" >
                        @csrf
                        <v-btn type="submit" medium color="error">
                            <v-icon color="white" large >exit_to_app</v-icon>
                        </v-btn>
                    </v-form>
                        </v-layout>
                        </div>

                    @else
                    <v-btn color="primary" class=" font-weight-bold text-xs-center" href="{{ route('login') }}"><v-icon  left>person</v-icon>Login</v-btn>
                    <v-btn color="primary" class=" font-weight-bold text-xs-center" href="{{ route('register') }}"><v-icon  left>person_add</v-icon>Register</v-btn>
                @endauth
                @endif

    </v-toolbar>
    <v-content>
                <v-parallax  class="article" height="720" >
                <v-layout column align-center justify-center class="white--text justify-center" >
                    <img src="img/task.png" height="200">
                        <h1 style="margin-top: 4%;text-shadow: black 0.1em 0.1em 0.8em" class="dos" >Tasques i Tags amb Vue</h1>
                    @auth
                        <h4 class="white--text subheading mb-3 text-xs-center dos" style="text-shadow:  black 0.1em 0.1em 1em"><strong>{{(Auth::user()->name)}}<strong></strong></h4>
                    @else
                        <h4 class="white--text subheading mb-3 text-xs-center dos"style="text-shadow:  black 0.1em 0.1em 1em"><strong>by Benjamin Zaragoza Pla<strong></strong></h4>
                    @endauth
                    <div class="text-xs-center">
                    <v-btn
                            class="primary mt-5 font-weight-bold text-xs-center text-uppercase"
                            dark
                            large
                            href="/home"
                    >
                        <v-icon  color="yellow" left>star</v-icon>
                        Tasques Go
                    </v-btn>
                    <v-btn depressed
                           class="dark mt-5"
                           style="height: 6.2%"
                           target="_blank"
                           href="https://github.com/benjaminzaragoza/Tasks"
                    ><img src="img/github.png" alt="Github" height="65">
                    </v-btn>
                    </div>
                </v-layout>
            </v-parallax>

        <section>
            <v-layout
                    column
                    wrap
                    class="my-5"
                    align-center
            >
                <v-flex sm4 class="my-3">
                    <div class="text-xs-center">
                        <h2 class="headline">The best way to start developing</h2>
                        <span class="subheading">
                Cras facilisis mi vitae nunc
              </span>
                    </div>
                </v-flex>
                <v-flex style="margin-top: -10%;">
                    <v-container grid-list-xl>
                        <v-layout row wrap align-center>
                            <v-flex xs12 md4>
                                <v-card class="elevation-0 transparent">
                                    <v-card-text class="text-xs-center" style="margin-top: 5%;">
                                        <v-icon x-large class="secondary--text text--lighten-2">assignment</v-icon>
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
                                        <v-icon x-large class="secondary--text text--lighten-2">assignment_turned_in</v-icon>
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
                                        <v-icon x-large class="secondary--text text--lighten-2">assessment</v-icon>
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

        <section>
            <v-parallax src="img/task2.jpg" height="480">
                <v-layout column align-center justify-center>
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
                                        <v-icon class="secondary--text text--lighten-2">phone</v-icon>
                                    </v-list-tile-action>
                                    <v-list-tile-content>
                                        <v-list-tile-title>777-867-5309</v-list-tile-title>
                                    </v-list-tile-content>
                                </v-list-tile>
                                <v-list-tile>
                                    <v-list-tile-action>
                                        <v-icon class="secondary--text text--lighten-2">place</v-icon>
                                    </v-list-tile-action>
                                    <v-list-tile-content>
                                        <v-list-tile-title>Chicago, US</v-list-tile-title>
                                    </v-list-tile-content>
                                </v-list-tile>
                                <v-list-tile>
                                    <v-list-tile-action>
                                        <v-icon class="secondary--text text--lighten-2">email</v-icon>
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

        <v-footer class="primary">
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
<style>
    .article {
        display: compact;
        text-align: center;
        background-image: url('img/image.jpg');
        background-size: cover;
    }
    .article:before {
        content:'';
        position: absolute;
        top:0;right:0;bottom:0;left:0;
        background: rgba(93, 93, 146, 0.5);
    }
    .dos:before {
        background: rgba(0,0,0,.4)
    }
    h1 {
        color: #fff;
        font-size: 4vw;
        font-weight: 20;
        text-align: center;
    }
</style>
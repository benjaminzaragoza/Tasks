<!doctype html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#4828d7"/>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    {{--<link rel="manifest" href="/site.webmanifest">--}}
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="apple-mobile-web-app-title" content="Tasques">
    <meta name="application-name" content="Tasques">
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#ffffff">
    <link rel=" shortcut icon" href="https://upload.wikimedia.org/wikipedia/commons/thumb/d/dd/Antu_task-complete.svg/2000px-Antu_task-complete.svg.png" type="image/png">
    <meta name="user" content="{{ logged_user() }}">
    <meta name="user_impersonating" content="{{ app('impersonate')->getImpersonatorId()}}">
    <meta name="git" content="{{ git() }}">

    <meta property="og:type" content="website" />
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">
    <meta property="og:title" content="App Tasques">
    <meta property="og:description" content="creació de tasques by Benjamin Zaragoza Pla">
    <meta property="og:url" content="http://tasks.benjaminzaragoza.scool.cat">
    <meta property="og:image" content="https://tasks.benjaminzaragoza.scool.cat/img/task.png">
    <meta property="og:sitename" content="tasks.benjaminzaragoza.scool.cat" />

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@nytimesbits" />
    <meta name="twitter:creator" content="@nickbilton" />

    <title>@yield('title')</title>
    <style>
        [v-cloak] {display: none}
    </style>
</head>
<body>
<v-app id="app" v-cloak >
    <snackbar></snackbar>
    <service-worker></service-worker>
    <navigation v-model="drawer" :mini="mini" ></navigation>
    {{--<navigation-right :drawer-right="drawerRight" @changed="drawerRight = $event"></navigation-right>--}}
    <v-navigation-drawer
            v-model="drawerRight"
            fixed
            app
            clipped
            right
    >
        <v-toolbar color="secondary" dark class="white--text">
            <v-icon>face</v-icon><v-toolbar-title>Perfil</v-toolbar-title>
        </v-toolbar>
        <v-card flat>
            <v-card-text>
                <h3 style=" margin-left: 2%;text-align: center">
                    <v-avatar  @click="drawerRight=!drawerRight" style="margin-top: 2%;margin-right: 5%;" title="{{Auth::user()->name}}({{(Auth::user()->email)}} )">
                        <img v-if="{{ Auth::user()->online }}" style="border: lawngreen 2px solid; margin: 20px;" src="https://www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}" alt="avatar">
                        <img v-else style="border: red 2px solid; margin: 20px;" src="https://www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}" alt="avatar">
                    </v-avatar>{{ Auth::user()->name }}</h3>

                <v-list-tile-title style="margin-top: 11%;margin-bottom: 10%; text-align: center" class="font-weight-black font-italic">{{ Auth::user()->email }}</v-list-tile-title>
                <h4>Rol</h4>
                <p style="margin-top: 5%;">
                    @if(Auth::user()->admin)
                        <v-chip color="success darken3" text-color="white" >
                            <v-avatar>
                                <v-icon>check_circle</v-icon>
                            </v-avatar>
                            Super Administrador
                        </v-chip>
                    @else
                        <v-chip color="error darken3" text-color="white">
                            <v-avatar>
                                <v-icon>close</v-icon>
                            </v-avatar>
                            Usuari
                        </v-chip>
                    @endif
                </p>
                <h4>Permisos</h4>
                <template >
                    <v-treeview style="margin-top: 5%;">{{ implode(', ',Auth::user()->map()['permissions']) }}</v-treeview>
                </template>
                <p> </p>
                <h4>Colors Tema</h4>
                <color></color>
            </v-card-text>
        </v-card>

        <v-card>
            @canImpersonate
            <v-toolbar color="secondary" dark class="white--text">
                <v-toolbar-title>Opcions administrador</v-toolbar-title>
            </v-toolbar>
            <v-card flat>
                <v-card-text>
                    <impersonate label="Entrar com ... " url="/api/v1/regular_users"></impersonate>
                </v-card-text>
            </v-card>
            @endCanImpersonate
            @impersonating
            <v-card-text>

                <b>{{ Auth::user()->impersonatedBy()->name }}</b> està suplantant <b>{{ Auth::user()->name }}</b>
            </v-card-text>
            <v-btn color="error darken3" dark href="impersonate/leave" >Abandonar la suplantació
                <v-icon dark right>supervisor_account</v-icon>
            </v-btn>
            @endImpersonating
            </v-layout>
        </v-card>

    </v-navigation-drawer>
    <v-toolbar color="primary" dark app clipped-left clipped-right fixed >
        <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
            <v-toolbar-title class="hidden-sm-and-down" class="font-weight-bold " >Menú</v-toolbar-title>
            <img class="hidden-sm-and-down" src="img/task.png" style="margin-left: 1%;height:50%">
            <span class="hidden-sm-and-down" v-role="'SuperAdmin'" style="margin-left: 2%"><git-info></git-info></span>
            <v-spacer class="hidden-sm-and-down"></v-spacer>
        <notifications-widget></notifications-widget>

        <h4 class="white-text mb-3 font-italic text-center hidden-sm-and-down" style="margin-top: 1%">{{ Auth::user()->email }}&nbsp;&nbsp;&nbsp;&nbsp;</h4>
        <v-avatar @click.stop="drawerRight = !drawerRight" title="{{Auth::user()->name}}({{(Auth::user()->email)}})">
            <img v-if="{{ Auth::user()->online }}" style="border: lawngreen 2px solid; margin: 20px;" src="https://www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}" alt="avatar">
            <img v-else style="border: red 2px solid; margin: 20px;" src="https://www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}" alt="avatar">
        </v-avatar>
            <v-spacer class="hidden-sm-and-up"></v-spacer>
        <v-spacer class="hidden-md-and-up"></v-spacer>

        <v-btn large style="margin-left: 2%"flat icon color="white " href="/"  type="submit">
                <v-icon large>home</v-icon>
            </v-btn>
            {{--<v-btn color="primary" href="/" type="submit" medium dark><v-icon large>home</v-icon></v-btn>--}}
            <v-form  action="logout" method="POST" >
            @csrf
                <v-btn  type="submit" large style="margin-right: 50%" flat icon color="white " >
                    <v-icon large>exit_to_app</v-icon>
                </v-btn>
        </v-form>
        </v-toolbar>
    <v-content style="background-color:  #f2f2f2F">
        <v-container fluid fill-height  >
            <v-layout
                    justify-center
            >
                <v-flex text-xs-center >
                    @yield('content')
                </v-flex>
            </v-layout>
        </v-container>
    </v-content>
    <v-footer
            app
            color="primary"
            class=" white--text text-xs-center"
            height="auto"
    >
        <v-card
                flat
                tile
                color="primary"
                class=" white--text text-xs-center"
        >
            <v-divider></v-divider>

            <v-card-text class="white--text hidden-sm-and-down" >
                &copy;2018 — <strong >Created by Benjamin Zaragoza, &copy; 2018 All rights reserved                                                                                              </strong>
            </v-card-text>
        </v-card>
    </v-footer>
</v-app>

<script src="{{mix('/js/app.js')}}"></script>

</body>
</html>

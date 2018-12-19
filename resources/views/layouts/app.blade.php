<!doctype html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel=" shortcut icon" href="https://upload.wikimedia.org/wikipedia/commons/thumb/d/dd/Antu_task-complete.svg/2000px-Antu_task-complete.svg.png" type="image/png">
    <link rel=" shortcut icon" href="https://www.freeiconspng.com/uploads/tasks-icon-26.png" type="image/png">
    <meta name="user" content="{{ logged_user() }}">
    <meta name="git" content="{{ git() }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>@yield('title')</title>
    <style>
        [v-cloak] {display: none}
    </style>
</head>
<body>
<v-app id="app" v-cloak >
    <snackbar></snackbar>

    <v-navigation-drawer
            v-model="drawer"
            :mini-variant.sync="mini"
            fixed
            app
            clipped
            hide-overlay
            stateless

    >
        <v-toolbar flat class="transparent">
            <v-list class="pa-0">
                <v-list-tile avatar>
                    <v-list-tile-avatar >
                        <img src="https://www.gravatar.com/avatar/{{md5(Auth::user()->email)}} " alt="avatar">
                    </v-list-tile-avatar>
                    <v-list-tile-content>
                        <v-list-tile-title>{{ Auth::user()->name }}</v-list-tile-title>
                    </v-list-tile-content>

                    <v-list-tile-action>
                        <v-btn
                                icon
                                @click.stop="mini = !mini"
                        >
                            <v-icon>chevron_left</v-icon>
                        </v-btn>
                    </v-list-tile-action>
                </v-list-tile>
            </v-list>
        </v-toolbar>

        <v-list class="pt-0" dense >
            <v-divider></v-divider>
            <template v-for="item in items">
                <v-layout
                        v-if="item.heading"
                        :key="item.heading"
                        row
                        align-center
                >
                    <v-flex xs6>
                        <v-subheader v-if="item.heading">
                            @{{ item.heading }}
                        </v-subheader>
                    </v-flex>

                    <v-flex xs6 class="text-xs-center">
                        <a href="#!" class="body-2 black--text">EDIT</a>
                    </v-flex>
                </v-layout>

                <v-list-group
                        v-else-if="item.children"
                        v-model="item.model"
                        :key="item.text"
                        :prepend-icon="item.model ? item.icon : item['icon-alt']"
                        append-icon=""
                >
                    <v-list-tile slot="activator" :href="item.url" >
                        <v-list-tile-content>
                            <v-list-tile-title  >
                                @{{ item.text }}
                            </v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile
                            v-for="(child, i) in item.children"
                            :key="i"
                            @click=""
                            :href="child.url"
                    >
                        <v-list-tile-action v-if="child.icon">
                            <v-icon >@{{ child.icon }}</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content :href="item.url">
                            <v-list-tile-title>
                                @{{ child.text }}
                            </v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list-group>

                <v-list-tile v-else :key="item.text" :href="item.url">
                    <v-list-tile-action >
                        <v-icon >@{{ item.icon }}</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>
                            @{{ item.text }}
                        </v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </template>
        </v-list>
    </v-navigation-drawer>

    <v-navigation-drawer
            v-model="drawerRight"
            fixed
            app
            clipped
            right
    >
        <v-toolbar color="blue darken-3" dark>
            <v-icon>face</v-icon><v-toolbar-title>Perfil</v-toolbar-title>
        </v-toolbar>
        <v-card flat>
            <v-card-text>
                <h3 style=" margin-left: 2%;text-align: center">
                    <v-avatar @click="drawerRight=!drawerRight" style="margin-top: 2%;margin-right: 5%;" title="{{Auth::user()->name}}({{(Auth::user()->email)}} )">
                        <img src="https://www.gravatar.com/avatar/{{md5(Auth::user()->email)}} " alt="avatar" style="margin-left: 15%;margin-right: 40%;margin-top: -11%;">
                    </v-avatar>{{ Auth::user()->name }}</h3>

                <v-list-tile-title style="margin-top: 11%;margin-bottom: 10%; text-align: center" class="font-weight-black font-italic">{{ Auth::user()->email }}</v-list-tile-title>
                <h4>Rol</h4>
                <p style="margin-top: 5%;">
                    @if(Auth::user()->admin)
                        <v-chip color="teal" text-color="white" >
                            <v-avatar>
                                <v-icon>check_circle</v-icon>
                            </v-avatar>
                            Super Administrador
                        </v-chip>
                    @else
                        <v-chip color="red" text-color="white">
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
            </v-card-text>
        </v-card>

        <v-card>
            @canImpersonate
            <v-toolbar color="blue darken-3" dark>
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
            <v-btn color="red" dark href="impersonate/leave" >Abandonar la suplantació
                <v-icon dark right>supervisor_account</v-icon>
            </v-btn>
            @endImpersonating
            </v-layout>
        </v-card>

    </v-navigation-drawer>

        <v-toolbar color="#311B92" dark app clipped-left clipped-right fixed>
        <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
            <v-toolbar-title class="font-weight-bold" >Menú</v-toolbar-title>
            <img src="img/task.png" style="margin-left: 1%;height:50%">
            <span v-role="'SuperAdmin'" style="margin-left: 2%"><git-info></git-info></span>
            <v-spacer></v-spacer>
            <h4 class="white-text mb-3 font-italic text-center" style="margin-top: 1%">{{ Auth::user()->email }}&nbsp;&nbsp;&nbsp;&nbsp;</h4>
        <v-avatar @click="drawerRight=!drawerRight" title="{{Auth::user()->name}}({{(Auth::user()->email)}} )">
            <img src="https://www.gravatar.com/avatar/{{md5(Auth::user()->email)}} " alt="avatar">
        </v-avatar>
            <v-btn color="#311B92" href="/" type="submit" medium dark><v-icon large>home</v-icon></v-btn>
            <v-form  action="logout" method="POST" >
            @csrf
            <v-btn color="#311B92" type="submit" medium dark>
                <v-icon large >exit_to_app</v-icon>
            </v-btn>
        </v-form>

        </v-toolbar>
    <v-content >
        <v-container fluid fill-height >
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
            color="#311B92"
            class=" lighten-1 white--text text-xs-center"
            height="auto"
    >
        <v-card
                flat
                tile
                color="#311B92"
                class="lighten-1 white--text text-xs-center"
        >
            <v-divider></v-divider>

            <v-card-text class="white--text">
                &copy;2018 — <strong>Created by Benjamin Zaragoza, &copy; 2018 All rights reserved                                                                                              </strong>
            </v-card-text>
        </v-card>
    </v-footer>
</v-app>

<script src="{{mix('/js/app.js')}}"></script>

</body>
</html>
{{--<script>--}}
  {{--import VToolbar from "vuetify/src/components/VToolbar/VToolbar"--}}
  {{--export default {--}}
    {{--components: {VToolbar}--}}
  {{--}--}}
{{--</script>--}}
{{--<script>--}}
  {{--import VListTile from "vuetify/lib/components/VList/VListTile"--}}
  {{--export default {--}}
    {{--components: {VListTile}--}}
  {{--}--}}
{{--</script>--}}
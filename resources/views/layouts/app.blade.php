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
            fixed
            app
            clipped
            class="deep-purple darken-4
 white--text"
    >
        <v-list dense class="white--text font-weight-bold" >
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
                        class="white--text"
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
                            <v-icon class="white--text">@{{ child.icon }}</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content :href="item.url">
                            <v-list-tile-title>
                                @{{ child.text }}
                            </v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list-group>
                <v-list-tile v-else :key="item.text" @click="" :href="item.url">
                    <v-list-tile-action class="white--text">
                        <v-icon class="white--text">@{{ item.icon }}</v-icon>
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
            right
            clipped
            app
    >
        <v-card>
            <v-card-title class="blue darken-3 white--text"><h4>Perfil</h4></v-card-title>
            <v-layout row wrap>
                <v-flex xs12>
                    <ul>
                        <li>Nom : {{ Auth::user()->name }}</li>
                        <li>Email : {{ Auth::user()->email }}</li>
                        <li>Admin : {{ Auth::user()->admin }}</li>
                        <li>Roles : {{ implode(',',Auth::user()->map()['roles']) }}</li>
                        <li>Permissions : {{ implode(', ',Auth::user()->map()['permissions']) }}</li>
                    </ul>
                </v-flex>
            </v-layout>
        </v-card>
        <v-card>
            <v-card-title class="blue darken-3 white--text"><h4>Opcions administrador</h4></v-card-title>

            <v-layout row wrap>
                @impersonating
                <v-flex xs12>
                    <v-avatar title="{{ Auth::user()->impersonatedBy()->name }} ( {{ Auth::user()->email }} )">
                        <img src="https://www.gravatar.com/avatar/{{ md5(Auth::user()->impersonatedBy()->email) }}" alt="avatar">
                    </v-avatar>
                </v-flex>
                @endImpersonating
                <v-flex xs12>
                    @canImpersonate
                    <impersonate label="Entrar com..." url="/api/v1/regular_users"></impersonate>
                    @endCanImpersonate
                    @impersonating
                    {{ Auth::user()->impersonatedBy()->name }} està suplantant {{ Auth::user()->name }}
                    <a href="impersonate/leave">Abandonar la suplantació</a>
                    @endImpersonating
                </v-flex>
            </v-layout>
        </v-card>

    </v-navigation-drawer>

        <v-toolbar color="#311B92" dark app clipped-left clipped-right fixed>
        <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
        <v-toolbar-title class="font-weight-bold" >Menú</v-toolbar-title>
            <img src="img/task.png" style="margin-left: 1%;height:50%">
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
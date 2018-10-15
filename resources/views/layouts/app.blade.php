<!doctype html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" rel="stylesheet">
    <title>@yield('title')</title>
</head>
<body>
<v-app id="app">
    <v-navigation-drawer
            v-model="drawer"
            fixed
            app
    >
        <v-list dense>
            <v-list-tile href="/tasks">
                <v-list-tile-action>
                    <v-icon>assignment</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>Tasques en PHP</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile href="/tasks_vue">
                <v-list-tile-action>
                    <v-icon>format_list_bulleted
                    </v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>Tasques en Vue</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile href="/about">
                <v-list-tile-action>
                    <v-icon>info</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>Qui som?</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile href="/contact">
                <v-list-tile-action>
                    <v-icon>photo_camera
                    </v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>Imatges</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
        </v-list>
    </v-navigation-drawer>
    <v-toolbar color="dark" dark fixed app>
        <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
        <v-toolbar-title>Menú</v-toolbar-title>
    </v-toolbar>
    <v-content>
        <v-container fluid fill-height>
            <v-layout
                    justify-center

            >
                <v-flex text-xs-center>

                    @yield('content')
                </v-flex>
            </v-layout>
        </v-container>
    </v-content>
    <v-footer
            app
            class="indigo lighten-1 white--text text-xs-center"
            height="auto"
    >
        <v-card
                flat
                tile
                class="indigo lighten-1 white--text text-xs-center"
        >
            <v-divider></v-divider>


            {{--<v-card-actions style="text-align: center!important;" class="grey darken-3 justify-center">--}}
                {{--&copy;2018 — <strong>Created by Benjamin Zaragoza, &copy; 2018 All rights reserved</strong>--}}
            {{--</v-card-actions>--}}
            <v-card-text class="white--text">
                &copy;2018 — <strong>Created by Benjamin Zaragoza, &copy; 2018 All rights reserved                                                                                              </strong>
            </v-card-text>
        </v-card>
    </v-footer>
</v-app>

<script src="{{mix('/js/app.js')}}"></script>

</body>
</html>
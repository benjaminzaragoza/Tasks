<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel=" shortcut icon" href="https://upload.wikimedia.org/wikipedia/commons/thumb/d/dd/Antu_task-complete.svg/2000px-Antu_task-complete.svg.png" type="image/png">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <style>
        [v-cloak] {display: none}
    </style>
</head>
<body>
<div id="app">
    <v-app v-cloak>
@yield('content')
        </v-app>
</div>
<script src="{{mix('/js/app.js')}}"></script>
</body>
</html>
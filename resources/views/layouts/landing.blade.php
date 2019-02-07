 <!doctype html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    {{--<link rel="manifest" href="/site.webmanifest">--}}
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="apple-mobile-web-app-title" content="Tasques">
    <meta name="application-name" content="Tasques">
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#ffffff">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="user" content="{{ logged_user() }}">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#4828d7"/>
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">
    <meta property="og:title" content="App Tasques">
    <meta property="og:description" content="creació de tasques by Benjamin Zaragoza Pla">
    <meta property="og:url" content="http://tasks.benjaminzaragoza.scool.cat">
    <meta property="og:image" content="https://tasks.benjaminzaragoza.scool.cat/img/task.png">

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@nytimesbits" />
    <meta name="twitter:creator" content="@nickbilton" />
    <meta property="og:url" content="http://tasks.benjaminzaragoza.scool.cat" />
    <meta property="og:title" content="App Tasques" />
    <meta property="og:description" content="creació de tasques by Benjamin Zaragoza Pla" />
    <meta property="og:image" content="https://tasks.benjaminzaragoza.scool.cat/img/task.png" />

    <title>@yield('title')</title>
    <style>
        [v-cloak] {display: none}
    </style>
</head>
<body>
<div id="app" v-cloak>
 @yield('content')
 </div>
<script src="{{mix('/js/app.js')}}"></script>
</body>
</html>
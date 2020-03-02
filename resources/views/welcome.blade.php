<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>E-Trackers</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">

        <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet" >
        <!-- Styles -->
    </head>
    <body>
        <v-app id="app">
            <Navbar></Navbar>
            <router-view class="container"></router-view>
        </v-app>

        <script src="{{ secure_asset('js/app.js') }}"></script>
    </body>
</html>

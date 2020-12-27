<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Theatre Treat</title>
        <meta name="base-url" content="{{url('api')}}" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        
        <script>
            window.baseUrl = '{{ env('APP_URL') }}';
       </script>
    </head>
    <body>
        <div id="app">
            <app-component></app-component>
        </div>
        <script type="text/javascript" src="js/app.js"></script>
    </body>
</html>

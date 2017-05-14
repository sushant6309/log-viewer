<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }
        </style>
        <script>
            // rename myToken as you like
            window.Laravel =  "{{ json_encode([
            'csrfToken' => csrf_token(),
        ])}}";
        </script>
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
    </head>
    <body>
        <div id="app" >
            <app-header></app-header>
            <div class="container">
                <app-body></app-body>
            </div>
        </div>
    <script src="/js/app.js"></script>
    </body>
</html>

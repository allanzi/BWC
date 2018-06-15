<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>FULLSTACK</title>

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

    <script>
        window.laravel = {
            'url': '{{env('APP_URL')}}'
        }
    </script>
</head>
<body class="grey lighten-3">
<section id="app">
    <material-header></material-header>

    <div class="container">
        <div class="row">
            <br>
            <div class="col m11 l11 s10">
                <h5>VEÍCULO</h5>
            </div>

            <div class="col m1 l1 s2">
                <create-modal></create-modal>
            </div>
            <div class="col s12">
                <hr>
            </div>

            <index-card></index-card>
        </div>
    </div>
</section>

<script src="{{ mix('/js/app.js')  }}"></script>
<script>
    $(document).ready(function(){
        $('.modal').modal();
    });
</script>
</body>
</html>

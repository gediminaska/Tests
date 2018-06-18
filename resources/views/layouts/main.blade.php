<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tests | Gediminas Kašėta</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>
<body>
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-lg-3">
                @yield('panel-left')
            </div>
            <div class="col-lg-6" style="padding: 30px">
                @yield('content')
            </div>
            <div class="col-lg-3" style="padding: 30px">
                @yield('panel-right')
            </div>
        </div>
    </div>
</body>
</html>
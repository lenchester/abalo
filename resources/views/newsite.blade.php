<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <title>articles</title>
</head>
<body>
<div id='app'>
    <articles></articles>
</div>
@auth
     The data only available for auth user
@endauth
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>



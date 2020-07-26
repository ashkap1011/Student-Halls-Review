<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ Session::token() }}"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="{{ asset('css/style.css') }}" media="all" rel="stylesheet" type="text/css" />
    <title>@yield('title')</title>
</head>
<body>
    
    @yield('content')
    <script type="text/javascript" src="{{ asset('js/actions.js') }}"></script>

</body>


</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!--<meta name="csrf-token" content="{{ Session::token() }}"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('js/actions.js') }}"></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    @yield('link')
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" media="all" rel="stylesheet" type="text/css" />
    
    
    <title>@yield('title')</title>
</head>
<body>
    <nav class="navbar navbar-expand-sm navigation_bar pt-2 pb-1 pt-md-3 pb-md-2">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <img id="logo" src="/storage/Logo/Logo1.png" alt="Logo">
          </li>
        </ul>
        <a href="/add/new-review" class="ml-auto"><img id="write_review_button" src="/storage/icons/write_review_btn.svg" alt=""></a>
    </nav>
    @yield('content')
   

</body>


</html>
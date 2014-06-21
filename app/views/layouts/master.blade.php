<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <meta type="description" content="{{ $description }}">
    <meta type="author" content="Anthony Vipond">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ Config::get('app.bootstrap_path') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ Config::get('app.datatable_path') }}/css/jquery.dataTables.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="{{ Config::get('app.bootstrap_path') }}/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/css/main.css">
    
</head>
<body>
    <div class="container">
        @yield('content')
    </div>

    <script src="/js/jquery-1.11.1.min.js"></script>
    <script src="{{ Config::get('app.datatable_path') }}/js/jquery.dataTables.js"></script>
    <script src="{{ Config::get('app.bootstrap_path') }}/js/bootstrap.min.js"></script>
    <script src="/js/main.js"></script>
    @if (App::environment() == 'production')
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-8595180-11', 'stockstreaks.com');
        ga('send', 'pageview');
    </script>
    @endif
</body>
</html>
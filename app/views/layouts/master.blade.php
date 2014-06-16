<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <meta type="description" content="{{ $description }}">
    <meta type="author" content="Anthony Vipond">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
    <div class="container">
        @yield('content')
    </div>

    <script src="/js/jquery-1.11.1.min.js"></script>
    <script src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <script src="/js/main.js"></script>
</body>
</html>
<http>
<head>
    <title>RSS Reader</title>
    @section('javascripts')
        <script src="/vendor/rss-reader/js/vendor/jquery.js"></script>
        <script src="/vendor/rss-reader/js/vendor/bootstrap.js"></script>
        <script src="/vendor/rss-reader/js/vendor/angular.js"></script>

        <script src="/vendor/rss-reader/js/utils.js"></script>
        <script src="/vendor/rss-reader/js/app.js"></script>
        <script src="/vendor/rss-reader/js/rss-reader.js"></script>

    @show
    @section('styles')
        <link rel="stylesheet" href="/vendor/rss-reader/css/vendor/bootstrap.css"/>
        <link rel="stylesheet" href="/vendor/rss-reader/css/vendor/bootstrap-theme.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="/vendor/rss-reader/css/app.css">
</head>
<body>
    <header>
        <div class="navbar navbar-default">
            <div class="navbar-header">
                <div class="navbar-brand">RSS Reader</div>
            </div>
        </div>
    </header>
    <div id="content" class="container" ng-app="rssApp" >
        <div class="row">
            @yield('content')
        </div>
    </div>
    <footer></footer>
</body>
</http>
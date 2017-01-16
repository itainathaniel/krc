<!doctype html>
<html lang="{{ config('locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield ('title', trans('index.site.title'))</title>
    <meta name="description" content="See which Israeli Knesset Member is in the Knesset">
    <meta name="author" content="Itai Nathaniel">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include ('partials.twitter-cards')
    @include ('partials.facebook')

    <link href='https://fonts.googleapis.com/css?family=Alef:400,700&subset=hebrew' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield ('head')
</head>
<body>

    <div class="page" id="root">

        @yield ('master-content')

    </div> <!-- /#root -->

    <script src="{{ asset('js/app.js') }}"></script>

    @include ('partials.googleAnalytics')

</body>
</html>
<!doctype html>
<html lang="he">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield ('title', trans('index.site.title'))</title>
    <meta name="description" content="See which Israeli Knesset Member is in the Knesset">
    <meta name="author" content="Itai Nathaniel">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href='https://fonts.googleapis.com/css?family=Alef:400,700&subset=hebrew' rel='stylesheet' type='text/css'>
    <style>
html {
    color: #222;
    font-size: 1em;
    line-height: 1.4;
    font-family: 'Alef', sans-serif;
    text-align: right;
    direction: rtl;
    /*background-color: darksalmon;*/
}

a {
    text-decoration: none;
}

h1 {
    text-align: center;
}

footer {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 100%;
}

footer p {
    margin: 20px 50px;
}
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h2 class="text-muted">
                <a href="{{ route('homepage') }}">{{ trans('index.site.name') }}</a>
            </h2>
        </header>

        <h1>בקרוב חוזרים</h1>

        <footer>
            <p>
                <a href="http://it.ai" onclick="trackOutboundLink('http://it.ai'); return false;">
                    {{ trans('site.footer.link-itai') }}
                </a> |
                <a href="https://www.facebook.com/knessetrollcall" style="color:rgb(58,87,149);">
                    {{ trans('site.footer.link-facebook') }}
                </a>
            </p>
        </footer>

    </div> <!-- /container -->

    <script src="{{ asset('js/app.js') }}"></script>

    @include ('partials.googleAnalytics')
</body>
</html>
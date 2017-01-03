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
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    @yield ('head')
</head>
<body>
    <div class="container">
        <div class="header">
            <nav>
                <ul class="nav nav-pills pull-left">
                    @if (Auth::check())
                        <li role="presentation" @yield('nav-active-profile', '')>
                            <a href="{{ action('UsersController@edit') }}">{{ Auth::user()->name }}</a>
                        </li>
                        @if (Auth::user()->admin)
                            <li role="presentation" @yield('nav-active-admin', '')>
                                <a href="{{ action('Admin\AdminController@index') }}">אדמין</a>
                            </li>
                        @endif
                    @endif
                    <li role="presentation" @yield('nav-active-index', '')>
                        <a href="route('homepage') }}">{{ trans('site.nav.main') }}</a>
                    </li>
                    <li role="presentation" @yield('nav-active-parties', '')>
                        <a href="action('PartiesController@index') }}">{{ trans('site.nav.parties') }}</a>
                    </li>
                    <li role="presentation" @yield('nav-active-inside', '')>
                        <a href="route('inside_path') }}">{{ trans('site.nav.nowInside') }}</a>
                    </li>
                    <li role="presentation" @yield('nav-active-table', '')>
                        <a href="action('KnessetMembersController@allTimeTable') }}">{{ trans('site.nav.table') }}</a>
                    </li>
                    <li role="presentation" @yield('nav-active-about', '')>
                        <a href="action('PagesController@about') }}">{{ trans('site.nav.about') }}</a>
                    </li>
                    @if (Auth::check())
                        <li role="presentation">
                            <a href="{{ action('Auth\AuthController@getLogout') }}">התנתקות</a>
                        </li>
                    @endif
                </ul>
            </nav>
            <h2 class="text-muted">
                <a href="{{ route('homepage') }}">{{ trans('index.site.name') }}</a>
            </h2>
        </div>

        @yield('content')

        <footer class="footer">
            <p>
                <a href="http://it.ai" onclick="trackOutboundLink('http://it.ai'); return false;">
                    {{ trans('site.footer.link-itai') }}
                </a> |
                <a href="action('PagesController@about') }}">
                    {{ trans('site.footer.link-about') }}
                </a> |
                <a href="action('PagesController@contact') }}">
                    {{ trans('site.footer.link-contact') }}
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
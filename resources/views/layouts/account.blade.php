<!DOCTYPE html>
<html>
<head>
    <title>Laravel Blogs</title>
    <meta charset="utf-8"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" >
    <link rel="stylesheet" href="/css/styles.css" >
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="/js/script.js"></script>
    <script src="/js/bootstrap-notify.min.js"></script>
</head>

<body>
<div class="container" style="width: 1000px; margin-top: 5px">

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li @if(Request::route()->getName()=='index') class="active" @endif ><a href="{{ route('index') }}">Главная</a></li>
                <li @if(strpos(Request::route()->getName(), 'public.posts.')!==false) class="active" @endif ><a href="{{ route('public.posts.index') }}">Записи</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                <li><a href="{{ url('/auth/login') }}">Вход</a></li>
                <li><a href="{{ url('/auth/register') }}">Регистрация</a></li>
                @else
                @if( Auth::user()->is_admin)
                <li><a href="{{ route('admin.index') }}">Админ панель</a></li>
                @endif
                <li><a href="{{ route('account.index') }}">{{ Auth::user()->name }}</a></li>
                <li><a href="{{ url('/auth/logout') }}">Выход</a></li>
                @endif
            </ul>


        </div>
    </nav>


    <div class="page-header">
        <h1>Личный кабинет</h1>
    </div>

    <div class="row">
        <div class="col-md-2">@include('account._menu')</div>
        <div class="col-md-10">
            @yield('content')
        </div>
    </div>

</div>
</body>
</html>
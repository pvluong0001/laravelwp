<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lit</title>

    @stack('before_styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('after_styles')
</head>
<body>
@include('admin.particles.header')

<div class="columns is-fullheight">
    {!! cache('navigation') !!}

    <div class="column is-main-content">
        @yield('content')
    </div>
</div>

@stack('before_scripts')
@stack('after_scripts')
</body>
</html>

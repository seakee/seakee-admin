<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('admin.name') }}</title>
        <!-- Styles -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="//unpkg.com/element-ui@2.4.11/lib/theme-chalk/index.css">
    </head>
    <body>
    <div id="app"></div>
    <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>

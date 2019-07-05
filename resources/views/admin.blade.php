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
        <link rel="stylesheet" href="//cdn.bootcss.com/element-ui/2.4.11/theme-chalk/index.css">
        <link rel="stylesheet" href="//ccdn.bootcss.com/font-awesome/5.6.3/css/all.min.css">
    </head>
    <body>
    <div id="app"></div>
    <script src="//cdn.bootcss.com/vue/2.5.21/vue.min.js"></script>
    <script src="//cdn.bootcss.com/element-ui/2.4.11/index.js"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>

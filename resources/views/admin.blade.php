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
    @if(config('admin.cdn.enable'))
        <link rel="stylesheet" href="//cdn.bootcss.com/element-ui/2.10.1/theme-chalk/index.css">
        <link rel="stylesheet" href="//cdn.bootcss.com/font-awesome/5.9.0/css/all.min.css">
    @else
        <link href="/css/element-ui/2.10.1/index.css" rel="stylesheet">
        <link href="/css/font-awesome/5.9.0/all.min.css" rel="stylesheet">
    @endif
</head>
<body>
<div id="app"></div>
@if(config('admin.cdn.enable'))
    <script src="//cdn.bootcss.com/vue/2.6.10/vue.min.js"></script>
    <script src="//cdn.bootcss.com/element-ui/2.10.1/index.js"></script>
@endif
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>

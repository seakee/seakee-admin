<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $config['name'] }}</title>
    <!-- Styles -->
    <link href="{{ mix('css/admin/app.css') }}" rel="stylesheet">
    @if($config['cdn']['enable'])
        @foreach($config['cdn']['css'] as $css)
            <link rel="stylesheet" href="{{ $css }}">
        @endforeach
    @else
        <link href="/css/admin/element-ui/2.10.1/index.css" rel="stylesheet">
        <link href="/css/admin/font-awesome/5.9.0/all.min.css" rel="stylesheet">
    @endif
</head>
<body>
<div id="app"></div>
<script>
    let appConfig = @json($config);
</script>
@if($config['cdn']['enable'])
    @foreach($config['cdn']['js'] as $js)
        <script src="{{ $js }}"></script>
    @endforeach
@endif
<script src="{{ mix('js/admin/app.js') }}"></script>
</body>
</html>

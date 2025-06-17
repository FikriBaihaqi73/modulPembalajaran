<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Error')</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <div class="text-zone">
        <h1>@yield('status_code', 'Error')</h1>
        <p>@yield('error_message', 'Terjadi kesalahan.')</p>
        @isset($suggestion)
            <p>@yield('suggestion')</p>
        @endisset
        @isset($dynamicInfo)
            <p>@yield('dynamic_info')</p>
        @endisset
        <a href="/">Kembali ke Beranda</a>
    </div>
</body>
</html>

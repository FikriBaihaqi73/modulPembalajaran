<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $status_code ?? '404' }} Not Found</title>
    <link rel="stylesheet" href="{{ asset('css/404-style.css') }}">
</head>
<body>
    <div class="text-zone">
        <h1>{{ $status_code ?? '404' }}</h1>
        <p>{{ $errorMessage ?? 'Halaman yang Anda cari tidak ditemukan.' }}</p>
        @isset($suggestion)
            <p>{{ $suggestion }}</p>
        @endisset
        <a href="/">Kembali ke Beranda</a>
    </div>

    <script>
        const dynamicInfo = @json($dynamic_info ?? []);
        console.log('Dynamic Info:', dynamicInfo);
        // Anda bisa menggunakan `dynamicInfo.timestamp` atau `dynamicInfo.request_path` di sini
    </script>
    <script src="{{ asset('js/404-script.js') }}"></script>
</body>
</html>

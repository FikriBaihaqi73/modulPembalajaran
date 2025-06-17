@extends('errors.layout')

@section('title', ($status_code ?? '404') . ' Not Found')
@section('status_code', $status_code ?? '404')
@section('error_message', $errorMessage ?? 'Halaman yang Anda cari tidak ditemukan.')
@section('suggestion', $suggestion ?? '')
@section('dynamic_info', $dynamicInfo ?? '')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/app.js'])
</head>
<body>
    <div class="text-zone">
        <h1>{{ $status_code ?? '404' }}</h1>
        <p>{{ $errorMessage ?? 'Halaman yang Anda cari tidak ditemukan.' }}</p>
        @isset($suggestion)
            <p>{{ $suggestion }}</p>
        @endisset
        @isset($dynamicInfo)
            <p>{{ $dynamicInfo }}</p>
        @endisset
        <a href="/">Kembali ke Beranda</a>
    </div>
</body>
</html>

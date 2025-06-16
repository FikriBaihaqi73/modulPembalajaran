@extends('errors.layout')

@section('title', ($status_code ?? '419') . ' Page Expired')

@section('content')
    <p>{{ $errorMessage ?? 'Halaman telah kedaluwarsa karena tidak aktif. Harap segarkan dan coba lagi.' }}</p>
    @isset($suggestion)
        <p>{{ $suggestion }}</p>
    @endisset
    <a href="/">Kembali ke Beranda</a>
@endsection

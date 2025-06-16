@extends('errors.layout')

@section('title', ($status_code ?? '404') . ' Not Found')

@section('content')
    <p>{{ $errorMessage ?? 'Halaman yang Anda cari tidak ditemukan.' }}</p>
    @isset($suggestion)
        <p>{{ $suggestion }}</p>
    @endisset
    <a href="/">Kembali ke Beranda</a>
@endsection

@extends('errors.layout')

@section('title', ($status_code ?? '500') . ' Internal Server Error')

@section('content')
    <h1>{{ $status_code ?? '500' }}</h1>
    <p>{{ $errorMessage ?? 'Terjadi kesalahan internal server. Silakan coba lagi nanti.' }}</p>
    @isset($suggestion)
        <p>{{ $suggestion }}</p>
    @endisset
    <a href="/">Kembali ke Beranda</a>
@endsection

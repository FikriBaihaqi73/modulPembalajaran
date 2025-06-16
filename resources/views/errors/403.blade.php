@extends('errors.layout')

@section('title', ($status_code ?? '403') . ' Forbidden')

@section('content')
    <h1>{{ $status_code ?? '403' }}</h1>
    <p>{{ $errorMessage ?? 'Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.' }}</p>
    @isset($suggestion)
        <p>{{ $suggestion }}</p>
    @endisset
    <a href="/">Kembali ke Beranda</a>
@endsection

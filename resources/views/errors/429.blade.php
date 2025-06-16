@extends('errors.layout')

@section('title', ($status_code ?? '429') . ' Too Many Requests')

@section('content')
    <p>{{ $errorMessage ?? 'Terlalu banyak permintaan. Harap tunggu sebentar sebelum mencoba lagi.' }}</p>
    @isset($suggestion)
        <p>{{ $suggestion }}</p>
    @endisset
    <a href="/">Kembali ke Beranda</a>
@endsection

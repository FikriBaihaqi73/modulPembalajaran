@extends('errors.layout')

@section('title', ($status_code ?? '401') . ' Unauthorized')

@section('content')
    <p>{{ $errorMessage ?? 'Maaf, Anda tidak memiliki otentikasi untuk mengakses halaman ini.' }}</p>
    @isset($suggestion)
        <p>{{ $suggestion }}</p>
    @endisset
    <a href="/">Kembali ke Beranda</a>
@endsection

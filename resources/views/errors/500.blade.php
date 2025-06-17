@extends('errors.layout')

@section('title', ($status_code ?? '500') . ' Internal Server Error')
@section('status_code', $status_code ?? '500')
@section('error_message', $errorMessage ?? 'Terjadi kesalahan internal server. Silakan coba lagi nanti.')
@section('suggestion', $suggestion ?? '')

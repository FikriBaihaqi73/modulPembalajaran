@extends('errors.layout')

@section('title', ($status_code ?? '401') . ' Unauthorized')
@section('status_code', $status_code ?? '401')
@section('error_message', $errorMessage ?? 'Maaf, Anda tidak memiliki otentikasi untuk mengakses halaman ini.')
@section('suggestion', $suggestion ?? '')


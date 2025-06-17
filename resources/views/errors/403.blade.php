@extends('errors.layout')

@section('title', ($status_code ?? '403') . ' Forbidden')
@section('status_code', $status_code ?? '403')
@section('error_message', $errorMessage ?? 'Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.')
@section('suggestion', $suggestion ?? '')


@extends('errors.layout')

@section('title', ($status_code ?? '419') . ' Page Expired')
@section('status_code', $status_code ?? '419')
@section('error_message', $errorMessage ?? 'Halaman telah kedaluwarsa karena tidak aktif. Harap segarkan dan coba lagi.')
@section('suggestion', $suggestion ?? '')



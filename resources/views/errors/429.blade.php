@extends('errors.layout')

@section('title', ($status_code ?? '429') . ' Too Many Requests')
@section('status_code', $status_code ?? '429')
@section('error_message', $errorMessage ?? 'Terlalu banyak permintaan. Harap tunggu sebentar sebelum mencoba lagi.')
@section('suggestion', $suggestion ?? '')


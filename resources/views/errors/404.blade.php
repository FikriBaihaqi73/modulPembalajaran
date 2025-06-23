@extends('errors.layout')

@section('title', ($status_code ?? '404') . ' Not Found')
@section('status_code', $status_code ?? '404')
@section('error_message', $errorMessage ?? 'Halaman yang Anda cari tidak ditemukan.')
@section('suggestion', $suggestion ?? '')
@section('dynamic_info', $dynamicInfo ?? '')


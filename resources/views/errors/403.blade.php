@extends('errors.layout')

@section('title', 'Akses Ditolak')
@section('code', '403')
@section('message')
    Maaf, Anda tidak memiliki izin untuk melihat halaman ini.
    <br class="hidden sm:block">Akses ke halaman ini dibatasi dan Anda tidak memiliki hak akses yang diperlukan.
    <br class="hidden sm:block">Silakan hubungi administrator jika Anda merasa ini adalah kesalahan.
@endsection

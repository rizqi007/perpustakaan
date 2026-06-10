@extends('errors.layout')

@section('title', 'Layanan Tidak Tersedia')
@section('code', '503')
@section('message')
    Maaf, layanan sedang tidak tersedia saat ini.
    <br class="hidden sm:block">Kami sedang melakukan pemeliharaan rutin atau server sedang sibuk.
    <br class="hidden sm:block">Cobalah beberapa saat lagi, kami akan segera kembali.
@endsection

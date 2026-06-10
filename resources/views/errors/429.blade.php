@extends('errors.layout')

@section('title', 'Terlalu Banyak Permintaan')
@section('code', '429')
@section('message')
    Maaf, Anda telah mengirimkan terlalu banyak permintaan dalam waktu singkat.
    <br class="hidden sm:block">Sistem mendeteksi aktivitas berlebihan dari perangkat Anda.
    <br class="hidden sm:block">Silakan tunggu beberapa saat lagi sebelum mencoba kembali.
@endsection

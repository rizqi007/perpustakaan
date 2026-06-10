@extends('errors.layout')

@section('title', 'Terjadi Kesalahan Server')
@section('code', '500')
@section('message')
    Maaf, terjadi kesalahan internal pada server kami.
    <br class="hidden sm:block">Sistem mendeteksi adanya masalah teknis dan tidak dapat memproses permintaan Anda saat ini.
    <br class="hidden sm:block">Tim teknis kami akan segera memperbaiki masalah ini. Silakan coba beberapa saat lagi.
@endsection

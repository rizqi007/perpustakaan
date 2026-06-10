@extends('errors.layout')

@section('title', 'Halaman Tidak Ditemukan')
@section('code', '404')
@section('message')
    Maaf, kami tidak dapat menemukan halaman yang Anda cari. 
    <br class="hidden sm:block">Mungkin halaman telah dipindahkan, dihapus, atau nama url salah ketik.
    <br class="hidden sm:block">Periksa kembali URL atau kembali ke halaman utama untuk melanjutkan.
@endsection

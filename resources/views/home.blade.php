@extends('layouts.app')

@section('content')
    @if(Auth::user()->role == 'admin')
        @include('pages.home.admin')
    @endif
    @if(Auth::user()->role == 'pengguna')
        @include('pages.home.pengguna')
    @endif
@endsection

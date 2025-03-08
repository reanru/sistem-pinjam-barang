@extends('layouts.app')

@section('content')
    {{-- @if(Auth::user()->role == 'admin') --}}
        @include('pages.home.admin')
    {{-- @endif --}}
@endsection

@extends('layouts.app')

@section('tittle')
    <title>Dashboard</title>
@endsection

@section('sidebar')
    @include('dashboard.sidebar')
@endsection

@section('navbar')
    @include('dashboard.navbar')
@endsection

@section('content')
    @yield('content')
@endsection

@section('footer')
    @include('dashboard.footer')
@endsection

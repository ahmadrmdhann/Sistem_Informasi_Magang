@extends('layouts.app')

@section('tittle')
    <title>Sistem Informasi Magang</title>
@endsection

@section('navbar')
    @include('landing.navbar')
@endsection

@section('content')
    @include('landing.content.hero')

    @include('landing.content.features')

    @include('landing.content.about')

    @include('landing.content.contact')

    @include('landing.content.cta')
    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.onclick = function (e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            };
        });
    </script>
@endsection

@section('footer')
    @include('landing.footer')
@endsection

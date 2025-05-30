@extends('layouts.app')

@section('tittle')
    <title>Sistem Informasi Magang</title>
    <meta name="description"
        content="Platform terbaik untuk mengelola program magang dengan mudah, efisien, dan terintegrasi.">
@endsection

@section('navbar')
    @include('landing.navbar')
@endsection

@section('content')
    <div class="flex flex-col min-h-screen">
        <main class="flex-1">
            @include('landing.content.hero')

            @include('landing.content.features')

            @include('landing.content.about')

            @include('landing.content.contact')

            @include('landing.content.cta')
        </main>

        @section('footer')
            @include('landing.footer')
        @endsection
    </div>

    <script>
        // Smooth scroll untuk link anchor dengan penanganan error yang lebih baik
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();

                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);

                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
@endsection
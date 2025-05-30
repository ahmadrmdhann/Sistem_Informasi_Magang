@extends('layouts.app')

@section('tittle')
    <title>Masuk</title>
@endsection

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-100 via-white to-blue-200">
        <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-2xl shadow-2xl animate-fade-in border border-blue-100">
            <div class="flex top-6 left-6">
                <a href="{{ route('landing') }}"
                    class="text-gray-700 hover:underline focus:underline transition font-semibold">
                    <i class="fa-solid fa-chevron-left mr-1"></i>Kembali ke Beranda
                </a>
            </div>
            <div class="flex justify-center mb-4">
                <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-8 mr-3">
            </div>
            <h2 class="text-3xl font-extrabold text-center text-gray-800 tracking-tight">Masuk ke Akun Anda</h2>
            {{-- Error message --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative text-sm animate-shake"
                    role="alert">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded relative text-sm animate-fade-in"
                    role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form class="space-y-5" method="POST" action="{{ route('login') }}" autocomplete="on">
                @csrf
                <div>
                    <label for="email" class="block mb-1 text-sm font-semibold text-gray-700">Email</label>
                    <input id="email" name="email" type="email" required autofocus autocomplete="email"
                        class="form-input block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition duration-150 ease-in-out shadow-sm bg-blue-50 hover:bg-blue-100"
                        placeholder="you@example.com" aria-label="Email" />
                </div>
                <div class="relative">
                    <label for="password" class="block mb-1 text-sm font-semibold text-gray-700">Kata Sandi</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password"
                        class="form-input block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition duration-150 ease-in-out shadow-sm pr-12 bg-blue-50 hover:bg-blue-100"
                        placeholder="Kata sandi Anda" aria-label="Kata Sandi" />
                    <button type="button" tabindex="0"
                        class="absolute inset-y-0 right-0 flex items-center justify-center w-10 mt-6 text-gray-400 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 rounded"
                        onclick="togglePasswordVisibility()" aria-label="Tampilkan atau sembunyikan kata sandi">
                        <i id="togglePasswordIcon" class="fa-solid fa-eye text-lg"></i>
                    </button>
                </div>
                <button type="submit"
                    class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 focus:bg-blue-800 text-white font-semibold rounded-lg shadow-md transition duration-150 ease-in-out flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i>Masuk
                </button>
            </form>
            <p class="text-sm text-center text-gray-600">
                Belum memiliki akun?
                <a href="{{ route('register') }}"
                    class="text-blue-600 hover:underline focus:underline focus:outline-none transition font-semibold">Daftar</a>
            </p>
        </div>
    </div>
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
            passwordInput.focus();
        }
    </script>
    <style>
        .animate-fade-in {
            animation: fadeIn 0.7s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-shake {
            animation: shake 0.3s;
        }

        @keyframes shake {
            0% {
                transform: translateX(0);
            }

            20% {
                transform: translateX(-8px);
            }

            40% {
                transform: translateX(8px);
            }

            60% {
                transform: translateX(-8px);
            }

            80% {
                transform: translateX(8px);
            }

            100% {
                transform: translateX(0);
            }
        }

        .form-input:focus {
            outline: none;
            box-shadow: 0 0 0 2px #3b82f6;
        }
    </style>
@endsection
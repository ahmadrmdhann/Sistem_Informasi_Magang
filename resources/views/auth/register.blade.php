@extends('layouts.app')

@section('tittle')
    <title>Daftar</title>
@endsection

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-100 via-white to-blue-200">
        <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-2xl shadow-2xl border border-blue-100 animate-fade-in">
            <div class="flex top-6 left-6">
                <a href="{{ route('landing') }}"
                    class="text-gray-700 hover:underline focus:underline transition font-semibold">
                    <i class="fa-solid fa-chevron-left mr-1"></i>Kembali ke Beranda
                </a>
            </div>
            <div class="flex justify-center mb-4">
                <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-8 mr-3">
            </div>
            <h2 class="text-3xl font-extrabold text-center text-gray-800 tracking-tight">Buat Akun Baru</h2>
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
            <form class="space-y-5" method="POST" action="{{ route('register') }}">
                @csrf
                <div>
                    <label for="username" class="block mb-1 text-sm font-semibold text-gray-700">Username</label>
                    <input id="username" name="username" type="text" required autofocus
                        placeholder="Masukkan username Anda"
                        class="form-input block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 bg-blue-50 hover:bg-blue-100 transition duration-150 ease-in-out shadow-sm" />
                </div>
                <div>
                    <label for="nama" class="block mb-1 text-sm font-semibold text-gray-700">Nama Lengkap</label>
                    <input id="nama" name="nama" type="text" required autofocus
                        placeholder="Masukkan nama pengguna Anda"
                        class="form-input block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 bg-blue-50 hover:bg-blue-100 transition duration-150 ease-in-out shadow-sm" />
                </div>
                <div>
                    <label for="nim" class="block mb-1 text-sm font-semibold text-gray-700">NIM</label>
                    <input id="nim" name="nim" type="text" required autofocus
                        placeholder="Masukkan NIM pengguna Anda"
                        class="form-input block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 bg-blue-50 hover:bg-blue-100 transition duration-150 ease-in-out shadow-sm" />
                </div>
                <div>
                    <label for="prodi_id" class="block mb-1 text-sm font-semibold text-gray-700">Program Studi</label>
                    <select id="prodi_id" name="prodi_id" required
                        class="form-select block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 bg-blue-50 hover:bg-blue-100 transition duration-150 ease-in-out shadow-sm">
                        <option value="">Pilih Program Studi</option>
                        @foreach($prodi as $item)
                            <option value="{{ $item->prodi_id }}">{{ $item->prodi_nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="email" class="block mb-1 text-sm font-semibold text-gray-700">Email</label>
                    <input id="email" name="email" type="email" required placeholder="you@example.com"
                        class="form-input block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 bg-blue-50 hover:bg-blue-100 transition duration-150 ease-in-out shadow-sm" />
                </div>
                <div class="relative">
                    <label for="password" class="block mb-1 text-sm font-semibold text-gray-700">Kata Sandi</label>
                    <input id="password" name="password" type="password" required placeholder=" "
                        class="form-input block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 bg-blue-50 hover:bg-blue-100 transition duration-150 ease-in-out shadow-sm pr-12"
                        autocomplete="new-password" />
                    <button type="button" tabindex="0"
                        class="absolute inset-y-0 right-0 flex items-center justify-center w-10 mt-6 text-gray-400 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 rounded"
                        onclick="togglePasswordVisibility('password', 'togglePasswordIcon1')"
                        aria-label="Tampilkan atau sembunyikan kata sandi">
                        <i id="togglePasswordIcon1" class="fa-solid fa-eye text-lg"></i>
                    </button>
                </div>
                <div class="relative">
                    <label for="password_confirmation" class="block mb-1 text-sm font-semibold text-gray-700">Konfirmasi
                        Kata Sandi</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required placeholder=" "
                        class="form-input block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 bg-blue-50 hover:bg-blue-100 transition duration-150 ease-in-out shadow-sm pr-12"
                        autocomplete="new-password" />
                    <button type="button" tabindex="0"
                        class="absolute inset-y-0 right-0 flex items-center justify-center w-10 mt-6 text-gray-400 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 rounded"
                        onclick="togglePasswordVisibility('password_confirmation', 'togglePasswordIcon2')"
                        aria-label="Tampilkan atau sembunyikan konfirmasi kata sandi">
                        <i id="togglePasswordIcon2" class="fa-solid fa-eye text-lg"></i>
                    </button>
                </div>
                <button type="submit"
                    class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 focus:bg-blue-800 text-white font-semibold rounded-lg shadow-md transition duration-150 ease-in-out flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <i class="fa-solid fa-user-plus mr-1"></i> Daftar
                </button>
            </form>
            <p class="text-sm text-center text-gray-600">
                Sudah memiliki akun?
                <a href="{{ route('login') }}"
                    class="text-blue-600 hover:underline focus:underline focus:outline-none transition font-semibold">Masuk</a>
            </p>
        </div>
    </div>
    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
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
            box-shadow: 0 0 0 2px #2563eb;
        }
    </style>
@endsection

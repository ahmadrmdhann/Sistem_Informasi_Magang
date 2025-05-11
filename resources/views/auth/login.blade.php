<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8 flex flex-col items-center">
        {{-- Logo Nanti Taruh Sini --}}
        <div class="text-4xl font-extrabold text-blue-700 mb-1">Sisforma</div>
        @if ($errors->has('loginError'))
            <div class="mb-4 text-red-600 text-sm text-center">
                {{ $errors->first('loginError') }}
            </div>
        @endif
        <form action="{{ url('login') }}" method="POST" class="w-full">
            @csrf
            <div class="mb-4">
                <label for="username" class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
                <input type="text" id="username" name="username" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-400" required>
            </div>
            <div class="mb-2">
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-400" required>
            </div>
            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center text-sm text-gray-600">
                    <input type="checkbox" class="form-checkbox rounded border-gray-300 mr-2">
                    Remember this Device
                </label>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg shadow transition">
                Login
            </button>
        </form>
        <div class="mt-6 text-center text-gray-700 text-sm">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar Sekarang</a>
        </div>
    </div>
</body>
</html>

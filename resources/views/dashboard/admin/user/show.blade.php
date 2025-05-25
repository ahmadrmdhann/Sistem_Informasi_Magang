@extends('layouts.dashboard')

@section('content')
    <div id="mainContent"
        class="p-6 w-auto pt-[109px] md:pt-[61px] min-h-screen bg-gray-50 transition-all duration-300 ml-64">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Detail User</h2>
            <a href="{{ route('user.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg shadow">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <div class="px-3 py-2 border rounded-md bg-gray-100">{{ $user->username }}</div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <div class="px-3 py-2 border rounded-md bg-gray-100">{{ $user->nama }}</div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <div class="px-3 py-2 border rounded-md bg-gray-100">{{ $user->email }}</div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Level</label>
                <div class="px-3 py-2 border rounded-md bg-gray-100">{{ $level->level_nama }}</div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Dibuat</label>
                <div class="px-3 py-2 border rounded-md bg-gray-100">
                    {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-' }}</div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Diperbarui</label>
                <div class="px-3 py-2 border rounded-md bg-gray-100">
                    {{ $user->updated_at ? $user->updated_at->format('d/m/Y H:i') : '-' }}</div>
            </div>
        </div>
    </div>
@endsection

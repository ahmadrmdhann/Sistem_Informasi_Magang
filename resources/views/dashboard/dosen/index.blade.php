@extends('layouts.dashboard')

@section('title')
    <title>Dashboard Dosen</title>
@endsection

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Dashboard Dosen</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded shadow p-4 text-center">
            <div class="text-lg font-semibold">Mahasiswa Bimbingan</div>
            <div class="text-3xl">{{ $mahasiswaBimbingan }}</div>
        </div>
    </div>
    {{-- Tambahkan daftar pengajuan magang, notifikasi, dll --}}
</div>
@endsection
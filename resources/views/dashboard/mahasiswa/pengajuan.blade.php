@extends('layouts.dashboard')

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Pengajuan Magang Mandiri</h1>
            <p class="text-gray-600 mt-1">Ajukan permohonan magang ke perusahaan partner atau lihat status pengajuan Anda
            </p>
        </div>

        {{-- Menampilkan pesan session (jika ada) --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Gagal!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Oops! Ada beberapa masalah dengan input Anda:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
            <div class="border-b border-gray-200">
                <nav class="flex flex-wrap -mb-px" aria-label="Tabs">
                    <button type="button" id="tabForm"
                        class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-3 sm:px-5 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none active">
                        <i class="fa-solid fa-file-alt mr-1"></i> Form Pengajuan
                    </button>
                    <button type="button" id="tabStatus"
                        class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-3 sm:px-5 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none">
                        <i class="fa-solid fa-tasks mr-1"></i> Status Pengajuan
                    </button>
                </nav>
            </div>

            <div class="p-0">
                {{-- Form Pengajuan --}}
                <div id="formPengajuan" class="tab-content p-5">
                    {{-- Konten form pengajuan akan dimuat di sini oleh controller atau diisi manual --}}
                    @include('dashboard.mahasiswa.partials.form-pengajuan') {{-- Contoh jika form ada di partial --}}
                </div>

                {{-- Status Pengajuan --}}
                <div id="statusPengajuan" class="tab-content p-5 hidden">
                    {{-- Konten status pengajuan akan dimuat di sini --}}
                    @include('dashboard.mahasiswa.partials.status-pengajuan') {{-- Contoh jika status ada di partial --}}
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabForm = document.getElementById('tabForm');
            const tabStatus = document.getElementById('tabStatus');
            const formPengajuanContent = document.getElementById('formPengajuan');
            const statusPengajuanContent = document.getElementById('statusPengajuan');

            function switchTab(activeTab, activeContent, inactiveTab, inactiveContent) {
                activeTab.classList.add('hs-tab-active:font-semibold', 'hs-tab-active:border-blue-600', 'hs-tab-active:text-blue-600', 'active');
                activeTab.classList.remove('text-gray-500', 'hover:text-blue-600', 'border-transparent');
                activeContent.classList.remove('hidden');

                inactiveTab.classList.remove('hs-tab-active:font-semibold', 'hs-tab-active:border-blue-600', 'hs-tab-active:text-blue-600', 'active');
                inactiveTab.classList.add('text-gray-500', 'hover:text-blue-600', 'border-transparent');
                inactiveContent.classList.add('hidden');
            }

            if (tabForm) {
                tabForm.addEventListener('click', function () {
                    switchTab(tabForm, formPengajuanContent, tabStatus, statusPengajuanContent);
                });
            }

            if (tabStatus) {
                tabStatus.addEventListener('click', function () {
                    switchTab(tabStatus, statusPengajuanContent, tabForm, formPengajuanContent);
                });
            }

            // Default tab (jika diperlukan, bisa diatur berdasarkan URL hash atau session)
            // switchTab(tabForm, formPengajuanContent, tabStatus, statusPengajuanContent);
        });
    </script>
@endsection
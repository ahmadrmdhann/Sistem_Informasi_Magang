@extends('layouts.dashboard')

@section('title')
    <title>Umpan Balik Magang</title>
@endsection

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Umpan Balik Pengalaman Magang</h1>
            <p class="text-gray-600 mt-1">Bagikan dan lihat riwayat umpan balik pengalaman magang Anda.</p>
        </div>

        <!-- Style untuk rating button -->
        <style>
            /* Style untuk label rating aktif */
            .rating-label input:checked+.rating-button {
                background-color: #2563eb;
                /* blue-600 */
                color: white;
                border-color: #2563eb;
                /* blue-600 */
                box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.3);
            }

            /* Efek hover pada label rating */
            .rating-button:hover {
                background-color: #dbeafe;
                /* blue-100 */
                border-color: #93c5fd;
                /* blue-300 */
            }

            /* Animasi transisi */
            .rating-button {
                transition: all 0.2s ease-in-out;
            }
        </style>        {{-- Success notification --}}
        @if(session('success'))
            <x-notification 
                type="success" 
                :message="session('success')" 
                :timeout="5000" 
                id="success-alert-popup" 
            />
        @endif
        
        {{-- Warning notification --}}
        @if(session('warning'))
            <x-notification 
                type="warning" 
                :message="session('warning')" 
                :timeout="7000" 
                id="warning-alert-popup" 
            />
        @endif

        {{-- Error notification --}}
        @if(session('error'))
            <x-notification 
                type="error" 
                :message="session('error')" 
                :timeout="10000" 
                id="error-alert-popup" 
            />
        @endif

        {{-- Validation errors notification --}}
        @if ($errors->any())
            <x-notification 
                type="error" 
                :timeout="10000" 
                id="validation-alert-popup"
            >
                <p class="text-sm font-medium">Oops! Ada beberapa masalah dengan input Anda:</p>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-notification>
        @endif

        <!-- Tabs -->
        <div class="mb-6 border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button type="button" id="tabFormFeedback"
                    class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none active">
                    <i class="fa-solid fa-pen-to-square mr-1"></i> Berikan Umpan Balik
                </button>
                <button type="button" id="tabRiwayatFeedback"
                    class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-x-2 border-b-2 border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none">
                    <i class="fa-solid fa-history mr-1"></i> Riwayat Umpan Balik
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div>
            <div id="formFeedbackContent" role="tabpanel">
                {{-- Display Student Information --}}
                <div class="mb-6 p-4 bg-slate-50 border border-slate-200 rounded-lg shadow">
                    <h3 class="text-xl font-semibold text-gray-700 mb-3">Informasi Anda</h3>
                    @if($mahasiswa && $mahasiswa->user && $mahasiswa->prodi)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                            <div>
                                <span class="font-medium text-gray-600">Nama Lengkap:</span>
                                <span class="text-gray-800">{{ $mahasiswa->user->nama }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">NIM:</span>
                                <span class="text-gray-800">{{ $mahasiswa->nim }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">Program Studi:</span>
                                <span class="text-gray-800">{{ $mahasiswa->prodi->prodi_nama }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">Email:</span>
                                <span class="text-gray-800">{{ $mahasiswa->user->email }}</span>
                            </div>
                        </div>
                    @else
                        <div class="text-sm text-gray-600">
                            <p>Informasi detail mahasiswa (Nama, NIM, Program Studi, Email) tidak dapat ditampilkan karena profil belum lengkap.</p>
                            <p>Anda tetap dapat mengisi dan mengirimkan umpan balik.</p>
                        </div>
                    @endif
                </div>

                <form action="{{ route('feedback.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <hr class="my-8 border-gray-300">

                    <h3 class="text-lg font-semibold text-gray-700 mb-1">Penilaian Kuantitatif</h3>
                    <p class="text-sm text-gray-500 mb-6">Berikan penilaian untuk aspek-aspek berikut:</p>

                    <!-- Skala Rating Legend dengan tampilan yang lebih jelas -->
                    <div
                        class="bg-blue-50 p-4 rounded-lg mb-6 flex items-center justify-between border border-blue-100">
                        <div class="flex items-center">
                            <span
                                class="flex justify-center items-center w-8 h-8 rounded-full bg-red-100 text-red-700 font-semibold mr-2">1</span>
                            <span class="text-sm text-gray-700 font-medium">Paling Rendah</span>
                        </div>
                        <div class="flex-grow border-t border-gray-300 mx-4 hidden md:block"></div>
                        <!-- Garis pemisah (hanya di desktop) -->
                        <div class="flex items-center">
                            <span
                                class="flex justify-center items-center w-8 h-8 rounded-full bg-green-100 text-green-700 font-semibold mr-2">10</span>
                            <span class="text-sm text-gray-700 font-medium">Paling Tinggi</span>
                        </div>
                    </div>

                    @php
                        $penilaianAspek = [
                            ['name' => 'skor_kesesuaian_tugas', 'label' => 'Kesesuaian tugas dengan bidang studi/minat.'],
                            ['name' => 'skor_kualitas_bimbingan', 'label' => 'Kualitas bimbingan/mentorship dari penyelia.'],
                            ['name' => 'skor_beban_kerja', 'label' => 'Beban kerja.'],
                            ['name' => 'skor_suasana_kerja', 'label' => 'Suasana dan lingkungan kerja.'],
                            ['name' => 'skor_pengembangan_hard_skills', 'label' => 'Kontribusi magang terhadap pengembangan hard skills.'],
                            ['name' => 'skor_pengembangan_soft_skills', 'label' => 'Kontribusi magang terhadap pengembangan soft skills.'],
                        ];
                    @endphp

                    <div class="space-y-6 mb-8">
                        @foreach ($penilaianAspek as $aspek)
                            <div>
                                <label for="{{ $aspek['name'] }}"
                                    class="block text-sm font-medium text-gray-700 mb-2">{{ $aspek['label'] }}</label>
                                <div class="flex flex-wrap gap-2 items-center">
                                    @for ($i = 1; $i <= 10; $i++)
                                        <label class="rating-label cursor-pointer relative">
                                            <input type="radio" name="{{ $aspek['name'] }}" value="{{ $i }}" class="sr-only" {{ old($aspek['name']) == $i ? 'checked' : '' }} required>
                                            <div class="rating-button w-10 h-10 flex items-center justify-center border border-gray-300 rounded-md text-sm font-medium text-gray-700 transition-all duration-150 
                                                    hover:bg-blue-100 hover:border-blue-300">
                                                {{ $i }}
                                            </div>
                                        </label>
                                    @endfor
                                </div>
                                @error($aspek['name'])
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    </div>

                    <hr class="my-8 border-gray-300">

                    <h3 class="text-lg font-semibold text-gray-700 mb-1">Ulasan Kualitatif</h3>
                    <p class="text-sm text-gray-500 mb-6">Berikan deskripsi naratif mengenai pengalaman Anda.</p>

                    <div class="mb-6">
                        <label for="pelajaran_terbaik" class="block text-sm font-medium text-gray-700 mb-1">Apa yang
                            paling kamu pelajari selama magang?</label>
                        <textarea id="pelajaran_terbaik" name="pelajaran_terbaik" rows="5"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400"
                            placeholder="Contoh: Saya belajar banyak tentang manajemen proyek dan bekerja dalam tim..."
                            required>{{ old('pelajaran_terbaik') }}</textarea>
                        @error('pelajaran_terbaik')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label for="kritik_saran_perusahaan"
                            class="block text-sm font-medium text-gray-700 mb-1">Masukan atau kritik terhadap perusahaan
                            tempat magang</label>
                        <textarea id="kritik_saran_perusahaan" name="kritik_saran_perusahaan" rows="5"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400"
                            placeholder="Contoh: Perusahaan dapat meningkatkan proses onboarding untuk peserta magang baru..."
                            required>{{ old('kritik_saran_perusahaan') }}</textarea>
                        @error('kritik_saran_perusahaan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3 mt-10">
                        <a href="{{ route('dashboard') }}"
                            class="py-2.5 px-6 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-300 bg-white text-gray-700 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                            Batal
                        </a>
                        <button type="submit"
                            class="py-2.5 px-6 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            <i class="fa-solid fa-paper-plane mr-1"></i> Kirim Umpan Balik
                        </button>
                    </div>
                </form>
            </div>

            <div id="riwayatFeedbackContent" role="tabpanel" class="hidden">
                <div class="bg-white p-6 sm:p-8 rounded-xl shadow-lg border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-700 mb-6">Riwayat Umpan Balik Anda</h2>
                    @if($riwayatFeedback && $riwayatFeedback->count() > 0)
                        <div class="space-y-6">
                            @foreach($riwayatFeedback as $feedback)
                                <div class="border border-gray-200 rounded-lg p-5 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-3">
                                        <h3 class="text-md font-semibold text-blue-600">Umpan Balik pada
                                            {{ \Carbon\Carbon::parse($feedback->tanggal)->translatedFormat('d F Y, H:i') }}</h3>
                                        <span class="text-xs text-gray-500">Evaluator: {{ ucfirst($feedback->evaluator) }}</span>
                                    </div>

                                    <div class="mb-4">
                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Pelajaran Terbaik:</h4>
                                        <p class="text-sm text-gray-600 leading-relaxed">
                                            {{ $feedback->pelajaran_terbaik ?? 'Tidak ada data.' }}</p>
                                    </div>

                                    <div class="mb-4">
                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Kritik & Saran untuk Perusahaan:</h4>
                                        <p class="text-sm text-gray-600 leading-relaxed">
                                            {{ $feedback->kritik_saran_perusahaan ?? 'Tidak ada data.' }}</p>
                                    </div>

                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Detail Penilaian (Skala 1-10):</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-sm">
                                        @foreach ($penilaianAspek as $aspek)
                                            @if(isset($feedback->{$aspek['name']}))
                                                <div class="flex justify-between items-center py-1 border-b border-gray-100">
                                                    <span class="text-gray-600">{{ rtrim($aspek['label'], '.') }}:</span>
                                                    <span class="text-gray-800 font-semibold">{{ $feedback->{$aspek['name']} }}/10</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- Pagination Links --}}
                        @if ($riwayatFeedback->hasPages())
                            <div class="mt-8">
                                {{ $riwayatFeedback->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-10">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                aria-hidden="true">
                                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum Ada Riwayat Umpan Balik</h3>
                            <p class="mt-1 text-sm text-gray-500">Anda belum pernah memberikan umpan balik sebelumnya.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabFormFeedback = document.getElementById('tabFormFeedback');
            const tabRiwayatFeedback = document.getElementById('tabRiwayatFeedback');
            const formFeedbackContent = document.getElementById('formFeedbackContent');
            const riwayatFeedbackContent = document.getElementById('riwayatFeedbackContent');

            // Function to switch tabs
            function switchTab(activeTab, activeContent, inactiveTab, inactiveContent) {
                activeTab.classList.add('hs-tab-active:font-semibold', 'hs-tab-active:border-blue-600', 'hs-tab-active:text-blue-600', 'active');
                activeTab.classList.remove('text-gray-500', 'hover:text-blue-600');
                activeContent.classList.remove('hidden');

                inactiveTab.classList.remove('hs-tab-active:font-semibold', 'hs-tab-active:border-blue-600', 'hs-tab-active:text-blue-600', 'active');
                inactiveTab.classList.add('text-gray-500', 'hover:text-blue-600');
                inactiveContent.classList.add('hidden');
            }

            // Event listeners for tabs
            tabFormFeedback.addEventListener('click', function () {
                switchTab(tabFormFeedback, formFeedbackContent, tabRiwayatFeedback, riwayatFeedbackContent);
            });

            tabRiwayatFeedback.addEventListener('click', function () {
                switchTab(tabRiwayatFeedback, riwayatFeedbackContent, tabFormFeedback, formFeedbackContent);
            });

            // Check for a URL hash to activate a specific tab
            if (window.location.hash === '#riwayat') {
                switchTab(tabRiwayatFeedback, riwayatFeedbackContent, tabFormFeedback, formFeedbackContent);
            } else {
                // Default to the first tab if no hash or if hash is not for riwayat
                switchTab(tabFormFeedback, formFeedbackContent, tabRiwayatFeedback, riwayatFeedbackContent);
            }

            // If form submission was successful and redirected back, switch to history tab
            @if(session('success'))
                // Ensure the riwayat tab is active to show the newly submitted feedback
                switchTab(tabRiwayatFeedback, riwayatFeedbackContent, tabFormFeedback, formFeedbackContent);
                // Optionally, scroll to the top of the history or the new feedback entry
                riwayatFeedbackContent.scrollIntoView({ behavior: 'smooth' });
            @endif            // Notification auto-dismiss is now handled by the component
        });
    </script>

@endsection
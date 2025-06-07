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

        @if(session('warning'))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Perhatian!</strong>
                <span class="block sm:inline">{{ session('warning') }}</span>
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
                                <span class="text-gray-800">{{ $mahasiswa->prodi->nama_prodi }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">Email:</span>
                                <span class="text-gray-800">{{ $mahasiswa->user->email }}</span>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-yellow-700 bg-yellow-100 border border-yellow-300 p-3 rounded-md">
                            Informasi mahasiswa tidak lengkap. Harap lengkapi profil Anda melalui halaman profil untuk pengalaman terbaik.
                        </p>
                    @endif
                </div>

                {{-- Feedback Form --}}
                <form action="{{ route('feedback.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded-lg shadow-md">
                    @csrf

                    {{-- Skor Kesesuaian Tugas --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">1. Bagaimana kesesuaian tugas yang diberikan dengan bidang dan minat Anda? <span class="text-red-500">*</span></label>
                        <div class="flex flex-wrap gap-2 items-center">
                            <span class="text-xs text-gray-500 mr-2">1 = Paling Rendah</span>
                            @for ($i = 1; $i <= 10; $i++)
                                <label class="rating-label cursor-pointer">
                                    <input type="radio" name="skor_kesesuaian_tugas" value="{{ $i }}" class="sr-only" {{ old('skor_kesesuaian_tugas') == $i ? 'checked' : '' }} required>
                                    <span class="rating-button w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-blue-50 transition-colors duration-150">{{ $i }}</span>
                                </label>
                            @endfor
                            <span class="text-xs text-gray-500 ml-2">10 = Paling Tinggi</span>
                        </div>
                        @error('skor_kesesuaian_tugas') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Skor Kualitas Bimbingan --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">2. Bagaimana kualitas bimbingan yang Anda terima dari mentor/pembimbing lapangan? <span class="text-red-500">*</span></label>
                        <div class="flex flex-wrap gap-2 items-center">
                            <span class="text-xs text-gray-500 mr-2">1 = Paling Rendah</span>
                            @for ($i = 1; $i <= 10; $i++)
                                <label class="rating-label cursor-pointer">
                                    <input type="radio" name="skor_kualitas_bimbingan" value="{{ $i }}" class="sr-only" {{ old('skor_kualitas_bimbingan') == $i ? 'checked' : '' }} required>
                                    <span class="rating-button w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-blue-50 transition-colors duration-150">{{ $i }}</span>
                                </label>
                            @endfor
                            <span class="text-xs text-gray-500 ml-2">10 = Paling Tinggi</span>
                        </div>
                        @error('skor_kualitas_bimbingan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Skor Beban Kerja --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">3. Bagaimana Anda menilai beban kerja selama magang? <span class="text-red-500">*</span></label>
                        <div class="flex flex-wrap gap-2 items-center">
                            <span class="text-xs text-gray-500 mr-2">1 = Paling Rendah</span>
                            @for ($i = 1; $i <= 10; $i++)
                                <label class="rating-label cursor-pointer">
                                    <input type="radio" name="skor_beban_kerja" value="{{ $i }}" class="sr-only" {{ old('skor_beban_kerja') == $i ? 'checked' : '' }} required>
                                    <span class="rating-button w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-blue-50 transition-colors duration-150">{{ $i }}</span>
                                </label>
                            @endfor
                            <span class="text-xs text-gray-500 ml-2">10 = Paling Tinggi</span>
                        </div>
                        @error('skor_beban_kerja') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Skor Suasana Kerja --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">4. Bagaimana suasana dan lingkungan kerja di tempat magang? <span class="text-red-500">*</span></label>
                        <div class="flex flex-wrap gap-2 items-center">
                            <span class="text-xs text-gray-500 mr-2">1 = Paling Rendah</span>
                            @for ($i = 1; $i <= 10; $i++)
                                <label class="rating-label cursor-pointer">
                                    <input type="radio" name="skor_suasana_kerja" value="{{ $i }}" class="sr-only" {{ old('skor_suasana_kerja') == $i ? 'checked' : '' }} required>
                                    <span class="rating-button w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-blue-50 transition-colors duration-150">{{ $i }}</span>
                                </label>
                            @endfor
                            <span class="text-xs text-gray-500 ml-2">10 = Paling Tinggi</span>
                        </div>
                        @error('skor_suasana_kerja') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Skor Pengembangan Hard Skills --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">5. Seberapa besar kontribusi magang ini terhadap pengembangan hard skills Anda? <span class="text-red-500">*</span></label>
                        <div class="flex flex-wrap gap-2 items-center">
                            <span class="text-xs text-gray-500 mr-2">1 = Paling Rendah</span>
                            @for ($i = 1; $i <= 10; $i++)
                                <label class="rating-label cursor-pointer">
                                    <input type="radio" name="skor_pengembangan_hard_skills" value="{{ $i }}" class="sr-only" {{ old('skor_pengembangan_hard_skills') == $i ? 'checked' : '' }} required>
                                    <span class="rating-button w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-blue-50 transition-colors duration-150">{{ $i }}</span>
                                </label>
                            @endfor
                            <span class="text-xs text-gray-500 ml-2">10 = Paling Tinggi</span>
                        </div>
                        @error('skor_pengembangan_hard_skills') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Skor Pengembangan Soft Skills --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">6. Seberapa besar kontribusi magang ini terhadap pengembangan soft skills Anda (misal: komunikasi, kerjasama tim)? <span class="text-red-500">*</span></label>
                        <div class="flex flex-wrap gap-2 items-center">
                            <span class="text-xs text-gray-500 mr-2">1 = Paling Rendah</span>
                            @for ($i = 1; $i <= 10; $i++)
                                <label class="rating-label cursor-pointer">
                                    <input type="radio" name="skor_pengembangan_soft_skills" value="{{ $i }}" class="sr-only" {{ old('skor_pengembangan_soft_skills') == $i ? 'checked' : '' }} required>
                                    <span class="rating-button w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-blue-50 transition-colors duration-150">{{ $i }}</span>
                                </label>
                            @endfor
                            <span class="text-xs text-gray-500 ml-2">10 = Paling Tinggi</span>
                        </div>
                        @error('skor_pengembangan_soft_skills') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Pelajaran Terbaik --}}
                    <div class="mb-4">
                        <label for="pelajaran_terbaik" class="block text-sm font-medium text-gray-700 mb-1">7. Apa yang paling kamu pelajari selama periode magang ini? (Hal baru, pengalaman berkesan, dll.) <span class="text-red-500">*</span></label>
                        <textarea name="pelajaran_terbaik" id="pelajaran_terbaik" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('pelajaran_terbaik') border-red-500 @enderror" placeholder="Ceritakan pelajaran atau pengalaman terbaik Anda..." required>{{ old('pelajaran_terbaik') }}</textarea>
                        @error('pelajaran_terbaik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kritik dan Saran --}}
                    <div class="mb-4">
                        <label for="kritik_saran_perusahaan" class="block text-sm font-medium text-gray-700 mb-1">8. Masukan atau kritik membangun untuk perusahaan/tempat magang? <span class="text-red-500">*</span></label>
                        <textarea name="kritik_saran_perusahaan" id="kritik_saran_perusahaan" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('kritik_saran_perusahaan') border-red-500 @enderror" placeholder="Sampaikan kritik atau saran Anda..." required>{{ old('kritik_saran_perusahaan') }}</textarea>
                        @error('kritik_saran_perusahaan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fa-solid fa-paper-plane mr-2"></i> Kirim Umpan Balik
                        </button>
                    </div>
                </form>
            </div>

            <div id="riwayatFeedbackContent" role="tabpanel" class="hidden">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4">Riwayat Umpan Balik Anda</h3>
                    @if($riwayatFeedback && $riwayatFeedback->count() > 0)
                        <div class="space-y-6">
                            @foreach($riwayatFeedback as $feedback)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-shadow duration-200">
                                    <div class="flex justify-between items-start mb-2">
                                        <p class="text-sm text-gray-500">
                                            Dikirim pada: <span class="font-medium text-gray-700">{{ $feedback->tanggal->translatedFormat('l, d F Y H:i') }}</span> ({{ $feedback->tanggal->diffForHumans() }})
                                        </p>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3 text-sm mb-3">
                                        <div><span class="font-medium text-gray-600">Kesesuaian Tugas:</span> <span class="text-gray-800">{{ $feedback->skor_kesesuaian_tugas }}/10</span></div>
                                        <div><span class="font-medium text-gray-600">Kualitas Bimbingan:</span> <span class="text-gray-800">{{ $feedback->skor_kualitas_bimbingan }}/10</span></div>
                                        <div><span class="font-medium text-gray-600">Beban Kerja:</span> <span class="text-gray-800">{{ $feedback->skor_beban_kerja }}/10</span></div>
                                        <div><span class="font-medium text-gray-600">Suasana Kerja:</span> <span class="text-gray-800">{{ $feedback->skor_suasana_kerja }}/10</span></div>
                                        <div><span class="font-medium text-gray-600">Pengembangan Hard Skills:</span> <span class="text-gray-800">{{ $feedback->skor_pengembangan_hard_skills }}/10</span></div>
                                        <div><span class="font-medium text-gray-600">Pengembangan Soft Skills:</span> <span class="text-gray-800">{{ $feedback->skor_pengembangan_soft_skills }}/10</span></div>
                                    </div>

                                    @if($feedback->pelajaran_terbaik)
                                        <div class="mb-2">
                                            <p class="text-sm font-medium text-gray-600 mb-1">Pelajaran Terbaik:</p>
                                            <p class="text-sm text-gray-800 bg-gray-50 p-2 rounded whitespace-pre-wrap">{{ $feedback->pelajaran_terbaik }}</p>
                                        </div>
                                    @endif

                                    @if($feedback->kritik_saran_perusahaan)
                                        <div>
                                            <p class="text-sm font-medium text-gray-600 mb-1">Kritik/Saran untuk Perusahaan:</p>
                                            <p class="text-sm text-gray-800 bg-gray-50 p-2 rounded whitespace-pre-wrap">{{ $feedback->kritik_saran_perusahaan }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        
                        {{-- Pagination Links --}}
                        @if ($riwayatFeedback->hasPages())
                            <div class="mt-6">
                                {{ $riwayatFeedback->links() }} 
                            </div>
                        @endif
                    @else
                        <p class="text-sm text-gray-500">Anda belum pernah mengirimkan umpan balik.</p>
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

            function switchTab(activeTab, activeContent, inactiveTab, inactiveContent) {
                activeTab.classList.add('hs-tab-active:font-semibold', 'hs-tab-active:border-blue-600', 'hs-tab-active:text-blue-600', 'active');
                activeTab.classList.remove('text-gray-500', 'hover:text-blue-600', 'border-transparent');
                activeContent.classList.remove('hidden');

                inactiveTab.classList.remove('hs-tab-active:font-semibold', 'hs-tab-active:border-blue-600', 'hs-tab-active:text-blue-600', 'active');
                inactiveTab.classList.add('text-gray-500', 'hover:text-blue-600', 'border-transparent');
                inactiveContent.classList.add('hidden');
            }

            tabFormFeedback.addEventListener('click', function () {
                switchTab(tabFormFeedback, formFeedbackContent, tabRiwayatFeedback, riwayatFeedbackContent);
                window.location.hash = ''; // Hapus hash dari URL
            });

            tabRiwayatFeedback.addEventListener('click', function () {
                switchTab(tabRiwayatFeedback, riwayatFeedbackContent, tabFormFeedback, formFeedbackContent);
                window.location.hash = 'riwayat'; // Tambah hash #riwayat ke URL
            });

            // Check if URL has #riwayat hash and switch to history tab
            if (window.location.hash === '#riwayat') {
                switchTab(tabRiwayatFeedback, riwayatFeedbackContent, tabFormFeedback, formFeedbackContent);
            }

            // Style untuk rating button (jika diperlukan, bisa dipindah ke file CSS terpisah)
            const style = document.createElement('style');
            style.textContent = `
                .rating-label input:checked + .rating-button {
                    background-color: #3B82F6; /* bg-blue-500 */
                    color: white;
                    border-color: #2563EB; /* border-blue-600 */
                }
                .rating-button:hover {
                    background-color: #EFF6FF; /* bg-blue-50 */
                }
                .rating-button {
                    transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out, border-color 0.2s ease-in-out;
                }
            `;
            document.head.appendChild(style);
        });
    </script>

@endsection
<?php

namespace App\Http\Controllers;

use App\Models\KeahlianModel;
use App\Models\MahasiswaModel;
use App\Models\ProdiModel;
use App\Models\KotaKabupatenModel;
use App\Models\PengajuanMagangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MahasiswaController extends Controller
{
    public function index()
    {
        try {
            $user = auth()->user();
            $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();
            $totalPengajuan = PengajuanMagangModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->count();
            $pengajuanDiterima = PengajuanMagangModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->where('status', 'diterima')->count();
            $pengajuanDiajukan = PengajuanMagangModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->where('status', 'diajukan')->count();
            $pengajuanDitolak = PengajuanMagangModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->where('status', 'ditolak')->count();
            $riwayatPengajuan = PengajuanMagangModel::with(['lowongan.partner'])
                ->where('mahasiswa_id', $mahasiswa->mahasiswa_id)
                ->orderByDesc('created_at')
                ->take(10)
                ->get();
            $totalLowongan = \App\Models\LowonganModel::where('tanggal_akhir', '>=', now())->count();
            $popularLowongan = \App\Models\LowonganModel::with('partner')
                ->withCount('pengajuanMagang')
                ->orderByDesc('pengajuan_magang_count')
                ->take(5)->get()
                ->map(function($l) {
                    $l->total_pendaftar = $l->pengajuan_magang_count;
                    return $l;
                });

            // Rekomendasi lowongan menggunakan sistem rekomendasi MOORA & ELECTRE
            $rekomendasiLowongan = collect();
            
            if ($mahasiswa && $mahasiswa->lokasi_preferensi && $mahasiswa->lokasiPreferensi) {
                // Load lowongan with all necessary relationships
                $lowongan = \App\Models\LowonganModel::with([
                    'kabupaten',
                    'keahlian', 
                    'partner',
                    'periode'
                ])->where('tanggal_akhir', '>=', now())->get();
                
                if (!$lowongan->isEmpty()) {
                    // Use recommendation system from RekomendasiController
                    $recommendations = $this->getRecommendations($mahasiswa, $lowongan);
                    
                    // Extract lowongan objects from recommendations for backward compatibility
                    $rekomendasiLowongan = collect($recommendations)->map(function($rec) {
                        return $rec['lowongan'];
                    })->take(3);
                }
            } else {
                // Fallback: simple recommendation based on skills/interests
                if ($mahasiswa && ($mahasiswa->minat_id || $mahasiswa->keahlian_id)) {
                    $rekomendasiLowongan = \App\Models\LowonganModel::with(['partner', 'kabupaten', 'keahlian'])
                        ->where(function($q) use ($mahasiswa) {
                            if ($mahasiswa->minat_id) {
                                $q->where('keahlian_id', $mahasiswa->minat_id);
                            }
                            if ($mahasiswa->keahlian_id) {
                                $q->orWhere('keahlian_id', $mahasiswa->keahlian_id);
                            }
                        })
                        ->where('tanggal_akhir', '>=', now())
                        ->orderByDesc('created_at')
                        ->take(3)
                        ->get();
                }
            }

            // Statistik Review Kegiatan Mahasiswa
            $reviewKegiatanStats = [
                'total' => \App\Models\ActivityLogModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->count(),
                'pending' => \App\Models\ActivityLogModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->where('status', 'pending')->count(),
                'approved' => \App\Models\ActivityLogModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->where('status', 'approved')->count(),
                'needs_revision' => \App\Models\ActivityLogModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->where('status', 'needs_revision')->count(),
                'rejected' => \App\Models\ActivityLogModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->where('status', 'rejected')->count(),
            ];

            return view('dashboard.mahasiswa.index', compact(
                'totalPengajuan', 'pengajuanDiterima', 'pengajuanDiajukan', 'pengajuanDitolak',
                'riwayatPengajuan', 'totalLowongan', 'popularLowongan', 'rekomendasiLowongan',
                'reviewKegiatanStats'
            ));
        } catch (\Exception $e) {
            return view('dashboard.mahasiswa.index', [
                'error' => $e->getMessage(),
                'totalPengajuan' => 0,
                'pengajuanDiterima' => 0,
                'pengajuanDiajukan' => 0,
                'pengajuanDitolak' => 0,
                'riwayatPengajuan' => collect([]),
                'totalLowongan' => 0,
                'popularLowongan' => collect([]),
                'rekomendasiLowongan' => collect([]),
                'reviewKegiatanStats' => [
                    'total' => 0,
                    'pending' => 0,
                    'approved' => 0,
                    'needs_revision' => 0,
                    'rejected' => 0,
                ]
            ]);
        }
    }

    public function profile()
    {
        $mahasiswa = MahasiswaModel::where('user_id', Auth::id())->firstOrFail();
        $prodis = ProdiModel::all();
        $keahlian = KeahlianModel::all();
        $kotaKabupaten = KotaKabupatenModel::orderBy('nama', 'asc')->get();
        return view('dashboard.mahasiswa.profile.index', compact('mahasiswa', 'prodis', 'keahlian', 'kotaKabupaten'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->firstOrFail();

        $request->validate([
            'username' => 'required|string|max:50|unique:m_user,username,' . $user->user_id . ',user_id',
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:m_user,email,' . $user->user_id . ',user_id',
            'nim' => 'required|string|max:20|unique:m_mahasiswa,nim,' . $mahasiswa->mahasiswa_id . ',mahasiswa_id',
            'prodi_id' => 'required|exists:m_prodi,prodi_id',
            'keahlian_id' => 'nullable|exists:m_keahlian,keahlian_id',
            'minat_id' => 'nullable|exists:m_keahlian,keahlian_id',
            'no_telepon' => 'nullable|string|max:15',
            'tentang_saya' => 'nullable|string|max:1000',
            'lokasi_preferensi' => 'nullable|exists:m_kota_kabupaten,kabupaten_id',
            'cv_file' => 'nullable|file|mimes:pdf|max:2048',
            'sertifikat_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah digunakan.',
            'prodi_id.required' => 'Jurusan wajib dipilih.',
            'cv_file.mimes' => 'File CV harus berformat PDF.',
            'cv_file.max' => 'Ukuran file CV maksimal 2MB.',
            'sertifikat_file.mimes' => 'File sertifikat harus berformat PDF, JPG, JPEG, atau PNG.',
            'sertifikat_file.max' => 'Ukuran file sertifikat maksimal 5MB.',
            'lokasi_preferensi.exists' => 'Lokasi preferensi yang dipilih tidak valid.',
        ]);

        try {
            DB::beginTransaction();

            // Handle CV file upload
            if ($request->hasFile('cv_file')) {
                // Create CV directory if it doesn't exist
                $cvUploadPath = public_path('files/cv');
                if (!File::exists($cvUploadPath)) {
                    File::makeDirectory($cvUploadPath, 0755, true);
                }

                // Delete old CV file if exists
                if ($mahasiswa->cv_file) {
                    $oldCvPath = public_path($mahasiswa->cv_file);
                    if (File::exists($oldCvPath)) {
                        File::delete($oldCvPath);
                    }
                }

                $cvFile = $request->file('cv_file');
                $cvFileName = 'cv_' . $user->user_id . '_' . time() . '.pdf';
                $cvFile->move($cvUploadPath, $cvFileName);

                // Save relative path to database
                $mahasiswa->cv_file = 'files/cv/' . $cvFileName;
            }

            // Handle Certificate file upload
            if ($request->hasFile('sertifikat_file')) {
                // Create certificates directory if it doesn't exist
                $certUploadPath = public_path('files/certificates');
                if (!File::exists($certUploadPath)) {
                    File::makeDirectory($certUploadPath, 0755, true);
                }

                // Delete old certificate file if exists
                if ($mahasiswa->sertifikat_file) {
                    $oldCertPath = public_path($mahasiswa->sertifikat_file);
                    if (File::exists($oldCertPath)) {
                        File::delete($oldCertPath);
                    }
                }

                $certFile = $request->file('sertifikat_file');
                $certExtension = $certFile->getClientOriginalExtension();
                $certFileName = 'cert_' . $user->user_id . '_' . time() . '.' . $certExtension;
                $certFile->move($certUploadPath, $certFileName);

                // Save relative path to database
                $mahasiswa->sertifikat_file = 'files/certificates/' . $certFileName;
            }

            // Update tabel users
            $user->username = $request->username;
            $user->nama = $request->nama;
            $user->email = $request->email;
            $user->save();

            // Update tabel mahasiswa
            $mahasiswa->nim = $request->nim;
            $mahasiswa->prodi_id = $request->prodi_id;
            $mahasiswa->keahlian_id = $request->keahlian_id;
            $mahasiswa->minat_id = $request->minat_id;
            $mahasiswa->no_telepon = $request->no_telepon;
            $mahasiswa->tentang_saya = $request->tentang_saya;
            $mahasiswa->lokasi_preferensi = $request->lokasi_preferensi;
            $mahasiswa->save();

            DB::commit();

            return redirect()->route('mahasiswa.profile')->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui profil: ' . $e->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak cocok.']);
        }

        try {
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('mahasiswa.profile')->with('success', 'Password berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui password.');
        }
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'foto_profil.required' => 'Foto profil wajib dipilih.',
            'foto_profil.image' => 'File harus berupa gambar.',
            'foto_profil.mimes' => 'Format gambar harus JPEG, PNG, atau JPG.',
            'foto_profil.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        try {
            $user = Auth::user();
            $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->firstOrFail();

            // Create directory if it doesn't exist
            $uploadPath = public_path('images/profile');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Delete old photo if exists
            if ($mahasiswa->foto_profil) {
                $oldPhotoPath = public_path($mahasiswa->foto_profil);
                if (File::exists($oldPhotoPath)) {
                    File::delete($oldPhotoPath);
                }
            }

            $photo = $request->file('foto_profil');
            $photoExtension = $photo->getClientOriginalExtension();
            $photoName = 'profile_' . $user->user_id . '_' . time() . '.' . $photoExtension;

            // Move file to public directory
            $photo->move($uploadPath, $photoName);

            // Save relative path to database (for use with asset() helper)
            $photoPath = 'images/profile/' . $photoName;
            $mahasiswa->foto_profil = $photoPath;
            $mahasiswa->save();

            return redirect()->route('mahasiswa.profile')->with('success', 'Foto profil berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui foto profil: ' . $e->getMessage());
        }
    }
    
    /**
     * Get recommendations using MOORA and ELECTRE methods
     */
    private function getRecommendations($mahasiswa, $lowongan)
    {
        try {
            $mooraResults = $this->calculateMOORA($mahasiswa, $lowongan);
            $electreResults = $this->calculateELECTRE($mahasiswa, $lowongan);
            return $this->combineResults($mooraResults, $electreResults);
        } catch (\Exception $e) {
            return [];
        }
    }

    private function calculateMOORA($mahasiswa, $lowongan)
    {
        try {
            $alternatives = [];
            $criteria = [];

            foreach ($lowongan as $job) {
                $distance = $this->calculateDistance($mahasiswa, $job);
                $skillMatch = $this->calculateSkillMatch($mahasiswa, $job);
                $interestMatch = $this->calculateInterestMatch($mahasiswa, $job);

                $alternatives[$job->lowongan_id] = [
                    'lowongan' => $job,
                    'distance' => $distance,
                    'skill_match' => $skillMatch,
                    'interest_match' => $interestMatch
                ];

                $criteria['distance'][] = $distance;
                $criteria['skill_match'][] = $skillMatch;
                $criteria['interest_match'][] = $interestMatch;
            }

            if (empty($alternatives)) {
                return [];
            }

            $normalizedMatrix = $this->normalizeMatrix($criteria);

            $weights = [
                'distance' => 0.4,
                'skill_match' => 0.35,
                'interest_match' => 0.25
            ];

            $scores = [];
            $i = 0;
            foreach ($alternatives as $id => $alt) {
                $score = 0;
                $score -= $weights['distance'] * $normalizedMatrix['distance'][$i];
                $score += $weights['skill_match'] * $normalizedMatrix['skill_match'][$i];
                $score += $weights['interest_match'] * $normalizedMatrix['interest_match'][$i];

                $scores[$id] = [
                    'lowongan' => $alt['lowongan'],
                    'score' => $score,
                    'criteria' => [
                        'distance' => $alt['distance'],
                        'skill_match' => $alt['skill_match'],
                        'interest_match' => $alt['interest_match']
                    ]
                ];
                $i++;
            }

            uasort($scores, function ($a, $b) {
                return $b['score'] <=> $a['score'];
            });

            return array_slice($scores, 0, 3, true);
        } catch (\Exception $e) {
            return [];
        }
    }

    private function calculateELECTRE($mahasiswa, $lowongan)
    {
        try {
            $alternatives = [];

            foreach ($lowongan as $job) {
                $distance = $this->calculateDistance($mahasiswa, $job);
                $skillMatch = $this->calculateSkillMatch($mahasiswa, $job);
                $interestMatch = $this->calculateInterestMatch($mahasiswa, $job);

                $alternatives[$job->lowongan_id] = [
                    'lowongan' => $job,
                    'criteria' => [
                        'distance' => $distance,
                        'skill_match' => $skillMatch,
                        'interest_match' => $interestMatch
                    ]
                ];
            }

            if (empty($alternatives) || count($alternatives) < 2) {
                return [];
            }

            $weights = [
                'distance' => 0.4,
                'skill_match' => 0.35,
                'interest_match' => 0.25
            ];

            $concordanceMatrix = $this->calculateConcordanceMatrix($alternatives, $weights);
            $discordanceMatrix = $this->calculateDiscordanceMatrix($alternatives);
            $dominanceMatrix = $this->calculateDominanceMatrix($concordanceMatrix, $discordanceMatrix);
            $scores = $this->calculateElectreScores($alternatives, $dominanceMatrix);

            return array_slice($scores, 0, 3, true);
        } catch (\Exception $e) {
            return [];
        }
    }

    private function calculateDistance($mahasiswa, $lowongan)
    {
        try {
            if (
                !$mahasiswa->lokasiPreferensi ||
                !$lowongan->kabupaten ||
                is_null($mahasiswa->lokasiPreferensi->lat) ||
                is_null($mahasiswa->lokasiPreferensi->lng) ||
                is_null($lowongan->kabupaten->lat) ||
                is_null($lowongan->kabupaten->lng)
            ) {
                return 200; // Maximum penalty if location data is missing
            }

            $fromLat = (float) $mahasiswa->lokasiPreferensi->lat;
            $fromLng = (float) $mahasiswa->lokasiPreferensi->lng;
            $toLat = (float) $lowongan->kabupaten->lat;
            $toLng = (float) $lowongan->kabupaten->lng;

            // Validate coordinates
            if (
                !is_numeric($fromLat) || !is_numeric($fromLng) ||
                !is_numeric($toLat) || !is_numeric($toLng) ||
                abs($fromLat) > 90 || abs($toLat) > 90 ||
                abs($fromLng) > 180 || abs($toLng) > 180
            ) {
                return 200; // Invalid coordinates
            }

            return $this->haversineDistance($fromLat, $fromLng, $toLat, $toLng);
        } catch (\Exception $e) {
            return 200; // Return maximum penalty on error
        }
    }

    private function haversineDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371; // Earth radius in kilometers

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) * sin($dLng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c, 2);
    }

    private function calculateSkillMatch($mahasiswa, $lowongan)
    {
        try {
            if (is_null($mahasiswa->keahlian_id) || is_null($lowongan->keahlian_id)) {
                return 0;
            }

            // Direct match
            if ($mahasiswa->keahlian_id == $lowongan->keahlian_id) {
                return 100;
            }

            // Partial match based on skill similarity
            return 30; // Base compatibility score
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function calculateInterestMatch($mahasiswa, $lowongan)
    {
        try {
            if (is_null($mahasiswa->minat_id) || is_null($lowongan->keahlian_id)) {
                return 0;
            }

            // Direct match between interest and job skill requirement
            if ($mahasiswa->minat_id == $lowongan->keahlian_id) {
                return 100;
            }

            // Partial match
            return 20;
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function normalizeMatrix($criteria)
    {
        $normalized = [];

        foreach ($criteria as $criterionName => $values) {
            $sumOfSquares = array_sum(array_map(function ($x) {
                return $x * $x;
            }, $values));
            $sqrt = sqrt($sumOfSquares);

            $normalized[$criterionName] = array_map(function ($x) use ($sqrt) {
                return $sqrt > 0 ? $x / $sqrt : 0;
            }, $values);
        }

        return $normalized;
    }

    private function calculateConcordanceMatrix($alternatives, $weights)
    {
        $altIds = array_keys($alternatives);
        $matrix = [];

        foreach ($altIds as $i) {
            foreach ($altIds as $j) {
                if ($i != $j) {
                    $concordance = 0;
                    $alt_i = $alternatives[$i]['criteria'];
                    $alt_j = $alternatives[$j]['criteria'];

                    // Distance: lower is better
                    if ($alt_i['distance'] <= $alt_j['distance']) {
                        $concordance += $weights['distance'];
                    }

                    // Skill match: higher is better
                    if ($alt_i['skill_match'] >= $alt_j['skill_match']) {
                        $concordance += $weights['skill_match'];
                    }

                    // Interest match: higher is better
                    if ($alt_i['interest_match'] >= $alt_j['interest_match']) {
                        $concordance += $weights['interest_match'];
                    }

                    $matrix[$i][$j] = $concordance;
                }
            }
        }

        return $matrix;
    }

    private function calculateDiscordanceMatrix($alternatives)
    {
        $altIds = array_keys($alternatives);
        $matrix = [];

        // Find max ranges for normalization
        $maxRanges = [
            'distance' => 100,
            'skill_match' => 100,
            'interest_match' => 100
        ];

        foreach ($altIds as $i) {
            foreach ($altIds as $j) {
                if ($i != $j) {
                    $alt_i = $alternatives[$i]['criteria'];
                    $alt_j = $alternatives[$j]['criteria'];

                    $maxDiff = 0;

                    // Distance: lower is better, so we check if j is much better than i
                    if ($alt_j['distance'] < $alt_i['distance']) {
                        $diff = abs($alt_i['distance'] - $alt_j['distance']) / max($maxRanges['distance'], $alt_i['distance']);
                        $maxDiff = max($maxDiff, $diff);
                    }

                    // Skill match: higher is better
                    if ($alt_j['skill_match'] > $alt_i['skill_match']) {
                        $diff = abs($alt_i['skill_match'] - $alt_j['skill_match']) / $maxRanges['skill_match'];
                        $maxDiff = max($maxDiff, $diff);
                    }

                    // Interest match: higher is better
                    if ($alt_j['interest_match'] > $alt_i['interest_match']) {
                        $diff = abs($alt_i['interest_match'] - $alt_j['interest_match']) / $maxRanges['interest_match'];
                        $maxDiff = max($maxDiff, $diff);
                    }

                    $matrix[$i][$j] = min($maxDiff, 1);
                }
            }
        }

        return $matrix;
    }

    private function calculateDominanceMatrix($concordanceMatrix, $discordanceMatrix)
    {
        $dominanceMatrix = [];
        $concordanceThreshold = 0.6;
        $discordanceThreshold = 0.3;

        foreach ($concordanceMatrix as $i => $row) {
            foreach ($row as $j => $concordance) {
                $discordance = $discordanceMatrix[$i][$j] ?? 0;

                $dominanceMatrix[$i][$j] = ($concordance >= $concordanceThreshold &&
                    $discordance <= $discordanceThreshold) ? 1 : 0;
            }
        }

        return $dominanceMatrix;
    }

    private function calculateElectreScores($alternatives, $dominanceMatrix)
    {
        $scores = [];

        foreach ($alternatives as $id => $alt) {
            $dominanceScore = 0;
            $dominatedScore = 0;

            if (isset($dominanceMatrix[$id])) {
                $dominanceScore = array_sum($dominanceMatrix[$id]);
            }

            foreach ($dominanceMatrix as $otherId => $row) {
                if (isset($row[$id])) {
                    $dominatedScore += $row[$id];
                }
            }

            $finalScore = $dominanceScore - $dominatedScore;

            $scores[$id] = [
                'lowongan' => $alt['lowongan'],
                'score' => $finalScore,
                'criteria' => $alt['criteria']
            ];
        }

        // Sort by score (descending)
        uasort($scores, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        return $scores;
    }

    private function combineResults($mooraResults, $electreResults)
    {
        try {
            if (empty($mooraResults) && empty($electreResults)) {
                return [];
            }

            $combined = [];

            // If we only have MOORA results
            if (!empty($mooraResults) && empty($electreResults)) {
                $rank = 1;
                foreach ($mooraResults as $result) {
                    $combined[] = [
                        'lowongan' => $result['lowongan'],
                        'moora_score' => $result['score'],
                        'electre_score' => 0,
                        'moora_rank' => $rank,
                        'electre_rank' => $rank,
                        'average_rank' => $rank,
                        'criteria' => $result['criteria']
                    ];
                    $rank++;
                }
                return array_slice($combined, 0, 3);
            }

            // If we only have ELECTRE results
            if (empty($mooraResults) && !empty($electreResults)) {
                $rank = 1;
                foreach ($electreResults as $result) {
                    $combined[] = [
                        'lowongan' => $result['lowongan'],
                        'moora_score' => 0,
                        'electre_score' => $result['score'],
                        'moora_rank' => $rank,
                        'electre_rank' => $rank,
                        'average_rank' => $rank,
                        'criteria' => $result['criteria']
                    ];
                    $rank++;
                }
                return array_slice($combined, 0, 3);
            }

            // Combine both results
            $mooraRanks = array_keys($mooraResults);
            $electreRanks = array_keys($electreResults);

            foreach ($mooraRanks as $mooraIndex => $lowonganId) {
                $electreIndex = array_search($lowonganId, $electreRanks);

                if ($electreIndex === false) {
                    $electreIndex = count($electreRanks);
                    $electreRank = count($electreRanks) + 1;
                } else {
                    $electreRank = $electreIndex + 1;
                }

                $mooraRank = $mooraIndex + 1;
                $averageRank = ($mooraIndex + $electreIndex) / 2;

                $combined[] = [
                    'lowongan' => $mooraResults[$lowonganId]['lowongan'],
                    'moora_score' => $mooraResults[$lowonganId]['score'],
                    'electre_score' => isset($electreResults[$lowonganId]) ? $electreResults[$lowonganId]['score'] : 0,
                    'moora_rank' => $mooraRank,
                    'electre_rank' => $electreRank,
                    'average_rank' => $averageRank,
                    'criteria' => $mooraResults[$lowonganId]['criteria']
                ];
            }

            // Sort by average rank (ascending - lower is better)
            usort($combined, function ($a, $b) {
                return $a['average_rank'] <=> $b['average_rank'];
            });

            return array_slice($combined, 0, 3);
        } catch (\Exception $e) {
            return [];
        }
    }
}

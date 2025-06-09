<?php

namespace App\Http\Controllers;

use App\Models\LowonganModel;
use App\Models\MahasiswaModel;
use App\Models\LokasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RekomendasiController extends Controller
{
    private $openRouteApiKey = '5b3ce3597851110001cf6248b6f616eca1fc41378f4871396d1dbd63';

    public function index()
    {
        try {
            $mahasiswa = MahasiswaModel::with(['lokasiPreferensi', 'keahlian', 'minat'])
                ->where('user_id', Auth::id())
                ->first();

            if (!$mahasiswa) {
                return view('dashboard.mahasiswa.rekomendasi.index', [
                    'mahasiswa' => null,
                    'recommendations' => [],
                    'mooraResults' => [],
                    'electreResults' => [],
                    'message' => 'Data mahasiswa tidak ditemukan. Silakan lengkapi profil Anda terlebih dahulu.'
                ]);
            }

            $lowongan = LowonganModel::with(['lokasi', 'keahlian', 'partner'])
                ->get();

            if ($lowongan->isEmpty()) {
                return view('dashboard.mahasiswa.rekomendasi.index', [
                    'mahasiswa' => $mahasiswa,
                    'recommendations' => [],
                    'mooraResults' => [],
                    'electreResults' => [],
                    'message' => 'Belum ada lowongan magang yang tersedia.'
                ]);
            }

            // Check if student has location preference
            if (!$mahasiswa->lokasi_preferensi || !$mahasiswa->lokasiPreferensi) {
                return view('dashboard.mahasiswa.rekomendasi.index', [
                    'mahasiswa' => $mahasiswa,
                    'recommendations' => [],
                    'mooraResults' => [],
                    'electreResults' => [],
                    'message' => 'Silakan lengkapi lokasi preferensi di profil Anda untuk mendapatkan rekomendasi yang akurat.'
                ]);
            }

            // Calculate recommendations using both methods
            $mooraResults = $this->calculateMOORA($mahasiswa, $lowongan);
            $electreResults = $this->calculateELECTRE($mahasiswa, $lowongan);

            // Combine results
            $recommendations = $this->combineResults($mooraResults, $electreResults);

            return view('dashboard.mahasiswa.rekomendasi.index', compact(
                'mahasiswa',
                'recommendations',
                'mooraResults',
                'electreResults'
            ));

        } catch (\Exception $e) {
            Log::error('Error in recommendation system: ' . $e->getMessage());

            return view('dashboard.mahasiswa.rekomendasi.index', [
                'mahasiswa' => null,
                'recommendations' => [],
                'mooraResults' => [],
                'electreResults' => [],
                'message' => 'Terjadi kesalahan dalam sistem rekomendasi. Silakan coba lagi nanti.'
            ]);
        }
    }

    private function calculateMOORA($mahasiswa, $lowongan)
    {
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

        // Normalize matrix
        $normalizedMatrix = $this->normalizeMatrix($criteria);

        // Apply weights (distance: lower is better, others: higher is better)
        $weights = [
            'distance' => 0.4,      // 40% weight, minimize
            'skill_match' => 0.35,  // 35% weight, maximize
            'interest_match' => 0.25 // 25% weight, maximize
        ];

        $scores = [];
        $i = 0;
        foreach ($alternatives as $id => $alt) {
            $score = 0;
            // Distance (minimize - subtract)
            $score -= $weights['distance'] * $normalizedMatrix['distance'][$i];
            // Skill match (maximize - add)
            $score += $weights['skill_match'] * $normalizedMatrix['skill_match'][$i];
            // Interest match (maximize - add)
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

        // Sort by score (descending)
        uasort($scores, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        // Limit to top 3 results for MOORA
        return array_slice($scores, 0, 3, true);
    }

    private function calculateELECTRE($mahasiswa, $lowongan)
    {
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

        // ELECTRE IV implementation
        $weights = [
            'distance' => 0.4,
            'skill_match' => 0.35,
            'interest_match' => 0.25
        ];

        $concordanceMatrix = $this->calculateConcordanceMatrix($alternatives, $weights);
        $discordanceMatrix = $this->calculateDiscordanceMatrix($alternatives);

        // Calculate dominance matrix
        $dominanceMatrix = $this->calculateDominanceMatrix($concordanceMatrix, $discordanceMatrix);

        // Calculate final scores based on dominance
        $scores = $this->calculateElectreScores($alternatives, $dominanceMatrix);

        // Limit to top 3 results for ELECTRE
        return array_slice($scores, 0, 3, true);
    }

    private function calculateDistance($mahasiswa, $lowongan)
    {
        // Check if both location objects exist and have lat/lng properties
        if (!$mahasiswa->lokasiPreferensi || 
            !$lowongan->lokasi || 
            !isset($mahasiswa->lokasiPreferensi->lat) || 
            !isset($mahasiswa->lokasiPreferensi->lng) ||
            !isset($lowongan->lokasi->lat) || 
            !isset($lowongan->lokasi->lng)) {
            
            Log::warning("Missing location data for distance calculation", [
                'mahasiswa_lokasi_preferensi' => $mahasiswa->lokasi_preferensi,
                'mahasiswa_has_lokasi' => $mahasiswa->lokasiPreferensi ? 'yes' : 'no',
                'lowongan_kabupaten_id' => $lowongan->kabupaten_id,
                'lowongan_has_lokasi' => $lowongan->lokasi ? 'yes' : 'no',
                'mahasiswa_lat' => $mahasiswa->lokasiPreferensi->lat ?? 'null',
                'mahasiswa_lng' => $mahasiswa->lokasiPreferensi->lng ?? 'null',
                'lowongan_lat' => $lowongan->lokasi->lat ?? 'null',
                'lowongan_lng' => $lowongan->lokasi->lng ?? 'null',
            ]);
            
            return 200; // Maximum penalty if location data is missing
        }

        $fromLat = $mahasiswa->lokasiPreferensi->lat;
        $fromLng = $mahasiswa->lokasiPreferensi->lng;
        $toLat = $lowongan->lokasi->lat;
        $toLng = $lowongan->lokasi->lng;

        // Validate coordinates
        if (!is_numeric($fromLat) || !is_numeric($fromLng) ||
            !is_numeric($toLat) || !is_numeric($toLng) ||
            abs($fromLat) > 90 || abs($toLat) > 90 ||
            abs($fromLng) > 180 || abs($toLng) > 180) {
            
            Log::warning("Invalid coordinates", [
                'fromLat' => $fromLat,
                'fromLng' => $fromLng,
                'toLat' => $toLat,
                'toLng' => $toLng
            ]);
            
            return 200; // Invalid coordinates
        }

        try {
            // Use OpenRouteService API to get actual distance
            $response = Http::timeout(10)->get("https://api.openrouteservice.org/v2/directions/driving-car", [
                'api_key' => $this->openRouteApiKey,
                'start' => "{$fromLng},{$fromLat}",
                'end' => "{$toLng},{$toLat}"
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['features'][0]['properties']['segments'][0]['distance'])) {
                    $distanceKm = $data['features'][0]['properties']['segments'][0]['distance'] / 1000;
                    return round($distanceKm, 2);
                }
            } else {
                Log::warning("OpenRouteService API failed: " . $response->body());
            }
        } catch (\Exception $e) {
            Log::error("Route API error: " . $e->getMessage());
        }

        // Fallback to Haversine formula if API fails
        return $this->haversineDistance($fromLat, $fromLng, $toLat, $toLng);
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
        if (!$mahasiswa->keahlian_id || !$lowongan->keahlian_id) {
            return 0;
        }

        // Direct match
        if ($mahasiswa->keahlian_id == $lowongan->keahlian_id) {
            return 100;
        }

        // Partial match based on skill similarity
        return 30; // Base compatibility score
    }

    private function calculateInterestMatch($mahasiswa, $lowongan)
    {
        if (!$mahasiswa->minat_id || !$lowongan->keahlian_id) {
            return 0;
        }

        // Direct match
        if ($mahasiswa->minat_id == $lowongan->keahlian_id) {
            return 100;
        }

        // Partial match
        return 20;
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
        $combined = [];
        $mooraRanks = array_keys($mooraResults);
        $electreRanks = array_keys($electreResults);

        foreach ($mooraRanks as $rank => $id) {
            $electreRank = array_search($id, $electreRanks);
            $averageRank = ($rank + $electreRank) / 2;

            $combined[$id] = [
                'lowongan' => $mooraResults[$id]['lowongan'],
                'moora_score' => $mooraResults[$id]['score'],
                'electre_score' => $electreResults[$id]['score'],
                'moora_rank' => $rank + 1,
                'electre_rank' => $electreRank + 1,
                'average_rank' => $averageRank,
                'criteria' => $mooraResults[$id]['criteria']
            ];
        }

        // Sort by average rank
        uasort($combined, function ($a, $b) {
            return $a['average_rank'] <=> $b['average_rank'];
        });

        // Limit to top 3 recommendations
        return array_slice($combined, 0, 3, true);
    }
}

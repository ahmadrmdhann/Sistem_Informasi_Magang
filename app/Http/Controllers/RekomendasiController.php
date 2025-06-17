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
            // Get mahasiswa data with all necessary relationships
            $mahasiswa = MahasiswaModel::with([
                'lokasiPreferensi',
                'keahlian',
                'minat',
                'user',
                'prodi'
            ])->where('user_id', Auth::id())->first();

            if (!$mahasiswa) {
                return view('dashboard.mahasiswa.rekomendasi.index', [
                    'mahasiswa' => null,
                    'recommendations' => [],
                    'mooraResults' => [],
                    'electreResults' => [],
                    'message' => 'Data mahasiswa tidak ditemukan. Silakan lengkapi profil Anda terlebih dahulu.'
                ]);
            }

            // Load lowongan with all necessary relationships
            $lowongan = LowonganModel::with([
                'kabupaten',
                'keahlian',
                'partner',
                'periode'
            ])->get();

            if ($lowongan->isEmpty()) {
                return view('dashboard.mahasiswa.rekomendasi.index', [
                    'mahasiswa' => $mahasiswa,
                    'recommendations' => [],
                    'mooraResults' => [],
                    'electreResults' => [],
                    'message' => 'Belum ada lowongan magang yang tersedia.'
                ]);
            }

            // Check mahasiswa profile completeness
            if (!$mahasiswa->lokasi_preferensi || !$mahasiswa->lokasiPreferensi) {
                return view('dashboard.mahasiswa.rekomendasi.index', [
                    'mahasiswa' => $mahasiswa,
                    'recommendations' => [],
                    'mooraResults' => [],
                    'electreResults' => [],
                    'message' => 'Silakan lengkapi lokasi preferensi di profil Anda untuk mendapatkan rekomendasi yang akurat.'
                ]);
            }

            $mooraResults = $this->calculateMOORA($mahasiswa, $lowongan);
            $electreResults = $this->calculateELECTRE($mahasiswa, $lowongan);
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
            throw $e;
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
            throw $e;
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

            // Try to get distance from OpenRoute Services API
            $apiDistance = $this->getDistanceFromAPI($fromLng, $fromLat, $toLng, $toLat);
            
            // If API fails, fallback to Haversine calculation
            if ($apiDistance === null) {
                Log::warning('OpenRoute API failed, using Haversine calculation as fallback');
                return $this->haversineDistance($fromLat, $fromLng, $toLat, $toLng);
            }

            return $apiDistance;
        } catch (\Exception $e) {
            Log::error('Error calculating distance: ' . $e->getMessage());
            return 200; // Return maximum penalty on error
        }
    }

    private function getDistanceFromAPI($fromLng, $fromLat, $toLng, $toLat)
    {
        try {
            $response = Http::timeout(10)->get('https://api.openrouteservice.org/v2/directions/driving-car', [
                'api_key' => $this->openRouteApiKey,
                'start' => $fromLng . ',' . $fromLat,
                'end' => $toLng . ',' . $toLat,
                'format' => 'json'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['features'][0]['properties']['segments'][0]['distance'])) {
                    // Convert meters to kilometers and round to 2 decimal places
                    $distanceInKm = round($data['features'][0]['properties']['segments'][0]['distance'] / 1000, 2);
                    return $distanceInKm;
                }
            }

            // Log API error for debugging
            Log::warning('OpenRoute API response error: ' . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error('OpenRoute API request failed: ' . $e->getMessage());
            return null;
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
                        'electre_rank' => 'N/A',
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
                        'moora_rank' => 'N/A',
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
            throw $e;
        }
    }
}

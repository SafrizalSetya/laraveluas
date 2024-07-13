<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerhitunganController extends Controller
{
    public function saw()
    {
        // Ambil semua alternatif, kriteria, dan penilaian
        $alternatifs = Alternatif::all();
        $kriterias = Kriteria::all();
        $penilaians = Penilaian::all();

        // Langkah 1: Normalisasi Bobot
        $totalBobot = $kriterias->sum('bobot');
        foreach ($kriterias as $kriteria) {
            $kriteria->bobot_normalized = $kriteria->bobot / $totalBobot;
        }

   // Langkah 2: Menghitung Vektor S
    $vektorS = [];
    foreach ($alternatifs as $alternatif) {
    $vektorS[$alternatif->id] = 0;
    foreach ($kriterias as $kriteria) {
        // Ambil penilaian untuk alternatif dan kriteria yang sesuai
        $penilaian = Penilaian::where('alternatif_id', $alternatif->id)
                              ->where('kriteria_id', $kriteria->id)
                              ->first();
        
        // Lakukan pengecekan apakah penilaian ditemukan
        $nilai = $penilaian ? floatval($penilaian->nilai) : 0;
        $bobotNormalized = floatval($kriteria->bobot_normalized);

        // Hitung nilai vektor S sesuai jenis kriteria
        if ($kriteria->jenis_kriteria == 'Cost' && $nilai != 0) {
            $vektorS[$alternatif->id] += $bobotNormalized / $nilai;
        } else {
            $vektorS[$alternatif->id] += $bobotNormalized * $nilai;
        }
    }
}

        // Langkah 3: Perankingan
        arsort($vektorS);

        // Menyimpan ranking ke variabel vektorV untuk ditampilkan di view
        $vektorV = [];
        $rank = 1;
        foreach ($vektorS as $altId => $nilaiS) {
            $vektorV[$altId] = [
                'nilai' => $nilaiS,
                'ranking' => $rank++
            ];
        }

        return view('perhitungan.saw', compact('alternatifs', 'kriterias', 'penilaians', 'vektorV'));
    }
}

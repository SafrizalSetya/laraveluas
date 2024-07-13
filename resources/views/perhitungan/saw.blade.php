@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Perhitungan Simple Additive Weighting (SAW)') }}</h1>

    <!-- Langkah 1: Normalisasi Bobot -->
    <div class="card shadow mb-4">
        <div class="card-header">Normalisasi Bobot</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            @foreach ($kriterias as $kriteria)
                                <th>{{ $kriteria->nama_kriteria }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($kriterias as $kriteria)
                                <td>{{ number_format($kriteria->bobot_normalized, 4) }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Langkah 2: Menghitung Vektor S -->
    <div class="card shadow mb-4">
        <div class="card-header">Menghitung Vektor S</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Alternatif</th>
                            @foreach ($kriterias as $kriteria)
                                <th>{{ $kriteria->nama_kriteria }}</th>
                            @endforeach
                            <th>Vektor S</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $vektorS = [];
                        @endphp
                        @foreach ($alternatifs as $alternatif)
                            <tr>
                                <td>{{ $alternatif->nama_alternatif }}</td>
                                @php
                                    $vektorSAlt = 0;
                                    foreach ($kriterias as $kriteria) {
                                        $penilaian = $penilaians->where('alternatif_id', $alternatif->id)
                                            ->where('kriteria_id', $kriteria->id)
                                            ->first();
                                        $nilai = $penilaian ? floatval($penilaian->nilai) : 0;
                                        $bobotNormalized = floatval($kriteria->bobot_normalized);

                                        if ($nilai != 0) { // Check if $nilai is not zero before division
                                            if ($kriteria->jenis_kriteria == 'Cost') {
                                                $vektorSAlt += $bobotNormalized * (1 / $nilai);
                                            } else {
                                                $vektorSAlt += $bobotNormalized * $nilai;
                                            }
                                        }
                                    }
                                    $vektorS[$alternatif->id] = $vektorSAlt;
                                @endphp
                                @foreach ($kriterias as $kriteria)
                                    @php
                                        $penilaian = $penilaians->where('alternatif_id', $alternatif->id)
                                            ->where('kriteria_id', $kriteria->id)
                                            ->first();
                                        $nilai = $penilaian ? floatval($penilaian->nilai) : 0;
                                    @endphp
                                    <td>{{ $nilai }}</td>
                                @endforeach
                                <td>{{ $vektorSAlt != 0 ? number_format($vektorSAlt, 4) : 'Undefined' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Langkah 3: Menghitung Vektor V -->
    <div class="card shadow mb-4">
        <div class="card-header">Menghitung Vektor V</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Alternatif</th>
                            <th>Vektor V</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalVektorS = array_sum($vektorS);
                            $vektorV = [];
                        @endphp
                        @foreach ($vektorS as $altId => $nilaiS)
                            <tr>
                                <td>{{ $alternatifs->find($altId)->nama_alternatif }}</td>
                                <td>{{ $totalVektorS != 0 ? number_format($nilaiS / $totalVektorS, 4) : 'Undefined' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Langkah 4: Perankingan -->
    <div class="card shadow mb-4">
        <div class="card-header">Peringkat</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Ranking</th>
                            <th>Nama Alternatif</th>
                            <th>Vektor V</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // Sort $vektorS descending based on values
                            arsort($vektorS);
                            $rank = 1;
                        @endphp
                        @foreach ($vektorS as $altId => $nilaiS)
                            <tr>
                                <td>{{ $rank++ }}</td>
                                <td>{{ $alternatifs->find($altId)->nama_alternatif }}</td>
                                <td>{{ $totalVektorS != 0 ? number_format($nilaiS / $totalVektorS, 4) : 'Undefined' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

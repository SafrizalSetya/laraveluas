<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    public function index()
{
    $alternatifs = Alternatif::all();
    $kriterias = Kriteria::all();
    $penilaians = Penilaian::all();


    return view('penilaian.index', compact('alternatifs', 'kriterias', 'penilaians'));
}



    public function create()
    {
        $alternatifs = Alternatif::all();
        $kriterias = Kriteria::all();

        return view('penilaian.create', compact('alternatifs', 'kriterias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alternative_id' => 'required|integer|exists:alternatifs,id',
            'nilai.*' => 'required|numeric',
        ]);
    
        $alternativeId = $request->input('alternative_id');
        $nilaiInput = $request->input('nilai');
        $kriterias = Kriteria::all();
    
        DB::beginTransaction();
        try {
            foreach ($kriterias as $kriteria) {
                $nilai = $nilaiInput[$kriteria->id];
    
                // Pastikan nilai tidak kosong
                if (!is_numeric($nilai)) {
                    throw new \Exception('Nilai untuk kriteria ' . $kriteria->nama . ' harus berupa angka.');
                }
    
                Penilaian::updateOrCreate(
                    ['alternatif_id' => $alternativeId, 'kriteria_id' => $kriteria->id],
                    ['nilai' => $nilai]
                );
            }
            DB::commit();
    
            return redirect()->route('penilaian.index')->with('toast_success', 'Penilaian alternatif diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('toast_error', 'Gagal menyimpan penilaian: ' . $e->getMessage())->withInput();
        }
    }

//     public function edit($id)
//     {
//         $forms = Penilaian::with(['alternatif', 'kriteria'])
//             ->where('alternatif_id', $id)
//             ->get();

//         $alternatifs = Alternatif::find($id);
//         $kriterias = Kriteria::all();

//         return view('penilaian.edit', compact('forms', 'alternatifs', 'kriterias'));
//     }

//     public function update(Request $request)
// {
//     $data = $request->except(['_token', '_method', 'alternative_id']);
//     $alternativeId = $request->input('alternative_id'); // Mengambil alternative_id dari request

//     $alternative = Alternatif::find($alternativeId); // Mencari alternatif berdasarkan alternative_id

//     if (!$alternative) {
//         return redirect()->route('penilaian.index')->with('toast_error', 'Alternatif tidak ditemukan!');
//     }

//     DB::beginTransaction();

//     try {
//         foreach ($data as $kriteriaId => $nilai) {
//             DB::table('penilaians')
//                 ->where('alternatif_id', $alternativeId)
//                 ->where('kriteria_id', $kriteriaId)
//                 ->update(['nilai' => $nilai]);
//         }

//         DB::commit();

//         return redirect()->route('penilaians.index')->with('toast_success', 'Penilaian alternatif ' . $alternative->nama_alternatif . ' diperbarui!');
//     } catch (\Exception $e) {
//         DB::rollback();
//         return redirect()->route('penilaians.index')->with('toast_error', 'Gagal memperbarui penilaian: ' . $e->getMessage());
//     }
// }
public function edit($id)
{
    $forms = Penilaian::with(['alternatif', 'kriteria'])
        ->where('alternatif_id', $id)
        ->get();

    $alternatif = Alternatif::find($id);
    $kriterias = Kriteria::all();

    return view('penilaian.edit', compact('forms', 'alternatif', 'kriterias'));
}

public function update(Request $request, $id)
{
    $data = $request->except(['_token', '_method', 'alternative_id']);
    $alternativeId = $id; // Menggunakan $id dari parameter

    $alternative = Alternatif::find($alternativeId);

    if (!$alternative) {
        return redirect()->route('penilaian.index')->with('toast_error', 'Alternatif tidak ditemukan!');
    }

    DB::beginTransaction();

    try {
        foreach ($data['nilai'] as $kriteriaId => $nilai) {
            DB::table('penilaians')
                ->updateOrInsert(
                    ['alternatif_id' => $alternativeId, 'kriteria_id' => $kriteriaId],
                    ['nilai' => $nilai]
                );
        }

        DB::commit();

        return redirect()->route('penilaian.index')->with('toast_success', 'Penilaian alternatif ' . $alternative->nama_alternatif . ' diperbarui!');
    } catch (\Exception $e) {
        DB::rollback();
        return redirect()->route('penilaian.index')->with('toast_error', 'Gagal memperbarui penilaian: ' . $e->getMessage());
    }
}

}
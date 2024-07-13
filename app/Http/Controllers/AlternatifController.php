<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    public function index()
    {
        $alternatifs = Alternatif::all();
        return view('alternatif.index', compact('alternatifs'));
    }

    public function create()
    {
        return view('alternatif.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_alternatif' => 'required',
            'nama_alternatif' => 'required',
        ]);

        Alternatif::create($request->all());

        // Redirect to index page after creating alternatif
        return redirect()->route('alternatif.index')->with('success', 'Alternatif created successfully.');
    }

    public function show(Alternatif $alternatif)
    {
        return view('alternatif.show', compact('alternatif'));
    }

    public function edit(Alternatif $alternatif)
    {
        return view('alternatif.edit', compact('alternatif'));
    }

    public function update(Request $request, Alternatif $alternatif)
    {
        $request->validate([
            'kode_alternatif' => 'required',
            'nama_alternatif' => 'required',
        ]);

        $alternatif->update($request->all());

        // Redirect to index page after updating alternatif
        return redirect()->route('alternatif.index')->with('success', 'Alternatif updated successfully.');
    }

    public function destroy(Alternatif $alternatif)
    {
        $alternatif->delete();

        // Redirect to index page after deleting alternatif
        return redirect()->route('alternatif.index')->with('success', 'Alternatif deleted successfully.');
    }
}

<?php

namespace App\Modules\Materijalno\Controllers;

use App\Models\Magacin;
use App\Models\Materijal;
use App\Models\StanjeZaliha;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StanjeZalihaController extends Controller
{
    // Display a listing of the stock data
    public function index()
    {
        $stanjeZaliha = StanjeZaliha::with(['material', 'warehouse'])->get();
        return view('materijalno::stanje-zaliha.index', compact('stanjeZaliha'));
    }

    // Show the form for creating a new stock record
    public function create()
    {
        $materijali = Materijal::all();
        $magacini = Magacin::all();
        return view('materijalno::stanje-zaliha.create', compact('materijali', 'magacini'));
    }

    // Store a newly created stock record in storage
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sifra_materijala' => 'required|exists:materijals,sifra_materijala',
            'naziv_materijala' => 'required|string',
            'magacin_id' => 'required|exists:magacini,id',
            'standard' => 'nullable|string',
            'dimenzija' => 'nullable|string',
            'kvalitet' => 'nullable|string',
            'jedinica_mere' => 'nullable|string',
            'konto' => 'nullable|string',
            'pocst_kolicina' => 'nullable|numeric',
            'pocst_vrednost' => 'nullable|numeric',
            'ulaz_kolicina' => 'nullable|numeric',
            'ulaz_vrednost' => 'nullable|numeric',
            'izlaz_kolicina' => 'nullable|numeric',
            'izlaz_vrednost' => 'nullable|numeric',
            'stanje_kolicina' => 'nullable|numeric',
            'stanje_vrednost' => 'nullable|numeric',
            'cena' => 'nullable|numeric',
        ]);

        StanjeZaliha::create($validatedData);
        return redirect()->route('stanje-zaliha.index')->with('message', 'Stock record successfully created.');
    }

    // Show the form for editing an existing stock record
    public function edit($id)
    {
        $stanjeZaliha = StanjeZaliha::findOrFail($id);
        $materijali = Materijal::all();
        $magacini = Magacin::all();
        return view('materijalno::stanje-zaliha.edit', compact('stanjeZaliha', 'materijali', 'magacini'));
    }

    // Update an existing stock record in storage
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'sifra_materijala' => 'required|exists:materijals,sifra_materijala',
            'naziv_materijala' => 'required|string',
            'magacin_id' => 'required|exists:magacini,id',
            'standard' => 'nullable|string',
            'dimenzija' => 'nullable|string',
            'kvalitet' => 'nullable|string',
            'jedinica_mere' => 'nullable|string',
            'konto' => 'nullable|string',
            'pocst_kolicina' => 'nullable|numeric',
            'pocst_vrednost' => 'nullable|numeric',
            'ulaz_kolicina' => 'nullable|numeric',
            'ulaz_vrednost' => 'nullable|numeric',
            'izlaz_kolicina' => 'nullable|numeric',
            'izlaz_vrednost' => 'nullable|numeric',
            'stanje_kolicina' => 'nullable|numeric',
            'stanje_vrednost' => 'nullable|numeric',
            'cena' => 'nullable|numeric',
        ]);

        $stanjeZaliha = StanjeZaliha::findOrFail($id);
        $stanjeZaliha->update($validatedData);

        return redirect()->route('stanje-zaliha.index')->with('message', 'Stock record successfully updated.');
    }

    // Remove the specified stock record from storage
    public function destroy($id)
    {
        $stanjeZaliha = StanjeZaliha::findOrFail($id);
        $stanjeZaliha->delete();

        return redirect()->route('stanje-zaliha.index')->with('message', 'Stock record deleted successfully.');
    }
}

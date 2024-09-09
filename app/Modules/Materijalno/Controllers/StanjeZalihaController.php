<?php

namespace App\Modules\Materijalno\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMaterijalRequest;
use App\Models\Materijal;
use App\Models\StanjeZaliha;
use Illuminate\Http\Request;
use PDF;
use App\Models\Category;

class StanjeZalihaController extends Controller
{
    // Display the list of stock records
    public function index()
    {
        // Get all stock records
        $stanjeZaliha = StanjeZaliha::with('material')->get();  // Assuming material relationship is defined
        return view('stanje-zaliha.index', compact('stanjeZaliha'));
    }

    // Show the create form for a new stock record
    public function create()
    {
        // Get materials for the dropdown
        $materijali = Materijal::all();
        return view('stanje-zaliha.create', compact('materijali'));
    }

    // Store a new stock record
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sifra_materijala' => 'required|exists:materijals,sifra_materijala', // Ensure material exists
            'naziv_materijala' => 'required|string',
            'magacin_id' => 'required|integer',
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
        return redirect()->route('stanje-zaliha.index')->with('message', 'Stock record successfully added.');
    }

    // Show the edit form for an existing stock record
    public function edit($id)
    {
        $stanjeZaliha = StanjeZaliha::findOrFail($id);
        $materijali = Materijal::all();
        return view('stanje-zaliha.edit', compact('stanjeZaliha', 'materijali'));
    }

    // Update an existing stock record
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'sifra_materijala' => 'required|exists:materijals,sifra_materijala',
            'naziv_materijala' => 'required|string',
            'magacin_id' => 'required|integer',
            // other fields...
        ]);

        $stanjeZaliha = StanjeZaliha::findOrFail($id);
        $stanjeZaliha->update($validatedData);

        return redirect()->route('stanje-zaliha.index')->with('message', 'Stock record successfully updated.');
    }
}

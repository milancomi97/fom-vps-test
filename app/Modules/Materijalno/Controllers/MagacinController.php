<?php

namespace App\Modules\Materijalno\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Magacin;
use Illuminate\Http\Request;

class MagacinController extends Controller
{
    public function index()
{
    $magacini = Magacin::all();
    return view('materijalno::magacini.index', compact('magacini'));
}

    public function create()
    {
        return view('materijalno::magacini.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        Magacin::create($validatedData);
        return redirect()->route('magacin.index')->with('message', 'Warehouse created successfully.');
    }

    public function edit($id)
    {
        $magacin = Magacin::findOrFail($id);
        return view('materijalno::magacini.edit', compact('magacin'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $magacin = Magacin::findOrFail($id);
        $magacin->update($validatedData);

        return redirect()->route('magacin.index')->with('message', 'Warehouse updated successfully.');
    }

    public function destroy($id)
    {
        $magacin = Magacin::findOrFail($id);
        $magacin->delete();

        return redirect()->route('magacin.index')->with('message', 'Warehouse deleted successfully.');
    }

    public function show($id)
    {

        $testt='test';

    }
}

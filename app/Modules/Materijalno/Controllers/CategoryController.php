<?php

namespace App\Modules\Materijalno\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMaterijalRequest;
use App\Models\Materijal;
use App\Models\StanjeZaliha;
use Illuminate\Http\Request;
use PDF;
use App\Models\Category;

class CategoryController extends Controller
{

    // Show the category list
    public function index()
    {
        // Fetch all categories to be shown in the table
        $categories = Category::all();

        return view('materijalno::category.index', compact('categories'));
    }


    // Show the create category form
    public function create()
    {
        // Fetch all categories for the parent category dropdown
        $categories = Category::all();
        return view('materijalno::category.create', compact('categories'));
    }

    // Store new category
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id', // parent_id can be null
        ]);

        // Create the new category
        Category::create($validatedData);

        return redirect()->route('category.create')->with('message', 'Category successfully created.');
    }

    // Show the edit category form
    public function edit($id)
    {
        // Fetch the category and all other categories for the parent dropdown
        $category = Category::findOrFail($id);
        $categories = Category::all();

        return view('materijalno::category.edit', compact('category', 'categories'));
    }

    // Update the category
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        // Find the category and update it
        $category = Category::findOrFail($id);
        $category->update($validatedData);

        return redirect()->route('category.edit', $id)->with('message', 'Category successfully updated.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // =========================
    // Return all categories as JSON or HTML partial
    // =========================
    public function fetchCategories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    // =========================
    // Return partial view for header
    // =========================
    public function headerPartial()
    {
        $categories = Category::all();
        return view('partials.categories-header', compact('categories'));
    }

    // =========================
    // Display categories list
    // =========================
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // =========================
    // Show create category form
    // =========================
    public function create()
    {
        return view('categories.create');
    }

    // =========================
    // Store a new category
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name|max:255',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    // =========================
    // Show a single category
    // =========================
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.show', compact('category'));
    }

    // =========================
    // Show edit form
    // =========================
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    // =========================
    // Update category
    // =========================
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    // =========================
    // Delete a category
    // =========================
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}

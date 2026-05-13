<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecipeController extends Controller
{
    public function index(): View
    {
        return view('admin.stub', ['title' => 'Recetas']);
    }

    public function create(): View
    {
        return view('admin.stub', ['title' => 'Nueva receta']);
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.recipes.index');
    }

    public function edit(int $recipe): View
    {
        return view('admin.stub', ['title' => 'Editar receta']);
    }

    public function update(Request $request, int $recipe)
    {
        return redirect()->route('admin.recipes.index');
    }

    public function destroy(int $recipe)
    {
        return redirect()->route('admin.recipes.index');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.stub', ['title' => 'Categorías de productos']);
    }

    public function create(): View
    {
        return view('admin.stub', ['title' => 'Nueva categoría']);
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.categories.index');
    }

    public function edit(int $category): View
    {
        return view('admin.stub', ['title' => 'Editar categoría']);
    }

    public function update(Request $request, int $category)
    {
        return redirect()->route('admin.categories.index');
    }

    public function destroy(int $category)
    {
        return redirect()->route('admin.categories.index');
    }
}

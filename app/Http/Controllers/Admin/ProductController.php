<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('admin.stub', ['title' => 'Productos']);
    }

    public function create(): View
    {
        return view('admin.stub', ['title' => 'Nuevo producto']);
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.products.index');
    }

    public function edit(int $product): View
    {
        return view('admin.stub', ['title' => 'Editar producto']);
    }

    public function update(Request $request, int $product)
    {
        return redirect()->route('admin.products.index');
    }

    public function destroy(int $product)
    {
        return redirect()->route('admin.products.index');
    }
}

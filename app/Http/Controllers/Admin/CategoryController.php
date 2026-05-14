<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryImageStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->withCount('products')
            ->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request, CategoryImageStorage $images): RedirectResponse
    {
        $data = $request->validated();

        $slugInput = isset($data['slug']) ? trim((string) $data['slug']) : '';
        $slugSource = $slugInput !== '' ? $slugInput : $data['name'];
        $data['slug'] = Category::uniqueSlug($slugSource);

        $data['sort_order'] = (int) $data['sort_order'];
        $data['accent_color'] = isset($data['accent_color']) ? trim((string) $data['accent_color']) : null;
        if ($data['accent_color'] === '') {
            $data['accent_color'] = null;
        }

        if ($request->hasFile('image')) {
            $data['image_path'] = $images->store($request->file('image'));
        } else {
            $data['image_path'] = null;
        }

        unset($data['image']);

        Category::create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Categoría creada correctamente.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category, CategoryImageStorage $images): RedirectResponse
    {
        $data = $request->validated();

        $slugInput = isset($data['slug']) ? trim((string) $data['slug']) : '';
        $slugSource = $slugInput !== '' ? $slugInput : $data['name'];
        $data['slug'] = Category::uniqueSlug($slugSource, $category->id);

        $data['sort_order'] = (int) $data['sort_order'];
        $data['accent_color'] = isset($data['accent_color']) ? trim((string) $data['accent_color']) : null;
        if ($data['accent_color'] === '') {
            $data['accent_color'] = null;
        }

        if ($request->boolean('remove_image')) {
            $images->delete($category->image_path);
            $data['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            $images->delete($category->image_path);
            $data['image_path'] = $images->store($request->file('image'));
        }

        unset($data['image'], $data['remove_image']);

        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Categoría actualizada correctamente.');
    }

    public function destroy(Category $category, CategoryImageStorage $images): RedirectResponse
    {
        $images->delete($category->image_path);
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Categoría eliminada.');
    }
}

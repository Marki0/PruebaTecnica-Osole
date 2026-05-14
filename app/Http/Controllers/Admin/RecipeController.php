<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRecipeRequest;
use App\Http\Requests\Admin\UpdateRecipeRequest;
use App\Models\Recipe;
use App\Services\RecipeImageStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RecipeController extends Controller
{
    public function index(): View
    {
        $recipes = Recipe::query()
            ->orderBy('sort_order')
            ->orderByDesc('updated_at')
            ->paginate(20);

        return view('admin.recipes.index', compact('recipes'));
    }

    public function create(): View
    {
        return view('admin.recipes.create');
    }

    public function store(StoreRecipeRequest $request, RecipeImageStorage $storage): RedirectResponse
    {
        $validated = $request->validated();

        $slugInput = trim((string) ($validated['slug'] ?? ''));
        $slugSource = $slugInput !== '' ? $slugInput : $validated['title'];
        $slug = Recipe::uniqueSlug($slugSource);

        $data = [
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'] ?? null,
            'body' => $validated['body'] ?? null,
            'is_published' => $request->boolean('is_published'),
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'image_path' => null,
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $storage->store($request->file('image'));
        }

        Recipe::create($data);

        return redirect()
            ->route('admin.recipes.index')
            ->with('status', 'Receta creada.');
    }

    public function edit(Recipe $recipe): View
    {
        return view('admin.recipes.edit', compact('recipe'));
    }

    public function update(
        UpdateRecipeRequest $request,
        Recipe $recipe,
        RecipeImageStorage $storage
    ): RedirectResponse {
        $validated = $request->validated();

        $slugInput = trim((string) ($validated['slug'] ?? ''));
        $slugSource = $slugInput !== '' ? $slugInput : $validated['title'];
        $slug = Recipe::uniqueSlug($slugSource, $recipe->id);

        $data = [
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'] ?? null,
            'body' => $validated['body'] ?? null,
            'is_published' => $request->boolean('is_published'),
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ];

        if ($request->boolean('remove_image')) {
            $storage->delete($recipe->image_path);
            $data['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            $storage->delete($recipe->image_path);
            $data['image_path'] = $storage->store($request->file('image'));
        }

        unset($data['image'], $data['remove_image']);

        $recipe->update($data);

        return redirect()
            ->route('admin.recipes.index')
            ->with('status', 'Receta actualizada.');
    }

    public function destroy(Recipe $recipe, RecipeImageStorage $storage): RedirectResponse
    {
        $storage->delete($recipe->image_path);
        $recipe->delete();

        return redirect()
            ->route('admin.recipes.index')
            ->with('status', 'Receta eliminada.');
    }
}

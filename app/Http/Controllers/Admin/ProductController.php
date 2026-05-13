<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductImageStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::query()
            ->with(['category', 'primaryImage'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request, ProductImageStorage $storage): RedirectResponse
    {
        $validated = $request->validated();

        $slugInput = trim((string) ($validated['slug'] ?? ''));
        $slugSource = $slugInput !== '' ? $slugInput : $validated['name'];
        $slug = Product::uniqueSlug($slugSource);

        $product = Product::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ]);

        if ($request->hasFile('image')) {
            $path = $storage->store($request->file('image'));
            $product->images()->create([
                'path' => $path,
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }

        $this->appendGallery($product, $request->file('gallery', []), $storage);

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Producto creado correctamente.');
    }

    public function edit(Product $product): View
    {
        $categories = Category::query()->orderBy('name')->get();
        $product->load([
            'primaryImage',
            'images' => function ($q) {
                $q->orderBy('sort_order');
            },
        ]);

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(
        UpdateProductRequest $request,
        Product $product,
        ProductImageStorage $storage
    ): RedirectResponse {
        $validated = $request->validated();

        $slugInput = trim((string) ($validated['slug'] ?? ''));
        $slugSource = $slugInput !== '' ? $slugInput : $validated['name'];
        $slug = Product::uniqueSlug($slugSource, $product->id);

        $product->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ]);

        if ($request->boolean('remove_primary')) {
            $this->deletePrimaryImages($product, $storage);
        }

        if ($request->hasFile('image')) {
            $this->deletePrimaryImages($product, $storage);
            $path = $storage->store($request->file('image'));
            $product->images()->create([
                'path' => $path,
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }

        $this->appendGallery($product, $request->file('gallery', []), $storage);

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product, ProductImageStorage $storage): RedirectResponse
    {
        foreach ($product->images as $image) {
            $storage->delete($image->path);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Producto eliminado.');
    }

    /**
     * @param  array<int, mixed>  $files
     */
    private function appendGallery(Product $product, array $files, ProductImageStorage $storage): void
    {
        $next = (int) ($product->images()->max('sort_order') ?? 0) + 1;

        foreach ($files as $file) {
            if (! $file || ! $file->isValid()) {
                continue;
            }
            $path = $storage->store($file);
            $product->images()->create([
                'path' => $path,
                'is_primary' => false,
                'sort_order' => $next++,
            ]);
        }
    }

    private function deletePrimaryImages(Product $product, ProductImageStorage $storage): void
    {
        $primaries = $product->images()->where('is_primary', true)->get();
        foreach ($primaries as $img) {
            $storage->delete($img->path);
            $img->delete();
        }
    }
}

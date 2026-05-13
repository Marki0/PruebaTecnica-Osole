<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\ProductImageStorage;
use Illuminate\Http\RedirectResponse;

class ProductImageController extends Controller
{
    public function destroy(
        Product $product,
        ProductImage $product_image,
        ProductImageStorage $storage
    ): RedirectResponse {
        if ($product_image->product_id !== $product->id) {
            abort(404);
        }

        $storage->delete($product_image->path);
        $product_image->delete();

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('status', 'Imagen de galería eliminada.');
    }
}

<?php

namespace App\Support;

use App\Models\Banner;
use App\Models\Category;
use App\Models\SiteSection;
use App\Models\Product;
use App\Models\Recipe;

final class Landing
{
    public static function nk(string $file): string
    {
        return url('nikitos/'.rawurlencode($file));
    }

    public static function productImageUrl(Product $p): string
    {
        $img = $p->images->firstWhere('is_primary', true) ?? $p->images->first();
        if ($img && $img->path) {
            return asset('storage/'.$img->path);
        }

        return static::nk('producto.png');
    }

    /**
     * Color de acento: primero el valor en BD, luego el config de líneas (legacy), por último default.
     */
    public static function categoryAccent(Category|string|null $categoryOrSlug): string
    {
        if ($categoryOrSlug instanceof Category) {
            if (! empty($categoryOrSlug->accent_color)) {
                return $categoryOrSlug->accent_color;
            }
            $slug = $categoryOrSlug->slug;
        } else {
            $slug = $categoryOrSlug;
        }

        foreach (config('nikitos_product_lines', []) as $line) {
            if (($line['slug'] ?? null) === $slug) {
                return $line['color'] ?? '#f2a900';
            }
        }

        return '#f2a900';
    }

    /**
     * Imagen de tarjeta de categoría: storage o asset Nikitos según config legacy por slug.
     */
    public static function categoryCardImageUrl(Category $category): string
    {
        if (! empty($category->image_path)) {
            return asset('storage/'.$category->image_path);
        }

        foreach (config('nikitos_product_lines', []) as $line) {
            if (($line['slug'] ?? null) === $category->slug && ! empty($line['nikitos_image'])) {
                return static::nk($line['nikitos_image']);
            }
        }

        return static::nk('producto.png');
    }

    public static function recipeImageUrl(?Recipe $recipe): string
    {
        if ($recipe && ! empty($recipe->image_path)) {
            return asset('storage/'.$recipe->image_path);
        }

        return static::nk('producto.png');
    }

    /**
     * Imagen del hero de sección: banner activo en storage o PNG de respaldo en Nikitos/.
     */
    public static function sectionHeroImageUrl(?Banner $banner, string $placement): string
    {
        if ($banner && $banner->is_active && $banner->image_path) {
            return asset('storage/'.$banner->image_path);
        }

        return match ($placement) {
            Banner::PLACEMENT_SECTION_PRODUCTOS => static::nk('Mask group-2.png'),
            Banner::PLACEMENT_SECTION_DONDE_COMPRAR => static::nk('Banner donde comprar.png'),
            Banner::PLACEMENT_SECTION_NOSOTROS => static::nk('Banner nosotros.png'),
            Banner::PLACEMENT_SECTION_RECETAS => static::nk('Banner productos.png'),
            default => static::nk('producto.png'),
        };
    }

    /**
     * Figura de un bloque Nosotros: prioriza imagen subida a storage; si no, Nikitos por nombre o default.
     */
    public static function nosotrosBlockFigureUrl(?SiteSection $section, int $index): string
    {
        $extra = $section?->extra ?? [];
        if (! empty($extra['image_path'])) {
            return asset('storage/'.$extra['image_path']);
        }

        $nikitos = ! empty($extra['nikitos_image'])
            ? (string) $extra['nikitos_image']
            : NosotrosPage::defaultNikitosImage($index);

        return static::nk($nikitos);
    }
}

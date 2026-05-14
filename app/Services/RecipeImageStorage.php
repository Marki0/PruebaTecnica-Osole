<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

/**
 * Almacena imágenes de recetas optimizadas (JPEG, ancho máx. 1200px) en disco public/recipes/.
 */
class RecipeImageStorage
{
    public function store(UploadedFile $file): string
    {
        $filename = Str::uuid()->toString().'.jpg';
        $path = 'recipes/'.$filename;

        $image = Image::make($file)->orientate();
        $image->resize(1200, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        Storage::disk('public')->put($path, (string) $image->stream('jpg', 85));

        return $path;
    }

    public function delete(?string $relativePath): void
    {
        if (! $relativePath) {
            return;
        }

        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}

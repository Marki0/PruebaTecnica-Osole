<?php

namespace App\Support;

final class RecipeDisplay
{
    /**
     * Separa el cuerpo de la receta en bloques de ingredientes y preparación.
     * Convención (una línea exacta): ===PREPARACION===
     * Todo lo anterior = ingredientes (una línea por ítem; líneas que terminan en ":" se muestran como subtítulo).
     * Todo lo posterior = pasos (una línea por paso; podés usar "Paso 1 — texto" o solo el texto).
     *
     * @return array{ingredients: ?string, steps: ?string}
     */
    public static function splitBody(?string $body): array
    {
        if ($body === null || trim($body) === '') {
            return ['ingredients' => null, 'steps' => null];
        }

        $normalized = str_replace(["\r\n", "\r"], "\n", $body);
        $parts = preg_split('/\R===PREPARACION===\R/', $normalized, 2);

        if (count($parts) === 2) {
            return [
                'ingredients' => trim($parts[0]) !== '' ? trim($parts[0]) : null,
                'steps' => trim($parts[1]) !== '' ? trim($parts[1]) : null,
            ];
        }

        return ['ingredients' => null, 'steps' => trim($normalized)];
    }

    /**
     * @return array<int, string>
     */
    public static function lines(?string $text): array
    {
        if ($text === null || trim($text) === '') {
            return [];
        }

        $lines = preg_split("/\r?\n/", str_replace("\r\n", "\n", $text));

        return array_values(array_filter(array_map('trim', $lines), static fn ($l) => $l !== ''));
    }
}

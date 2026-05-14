<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    public const PLACEMENT_SECTION_PRODUCTOS = 'section_productos';

    public const PLACEMENT_SECTION_DONDE_COMPRAR = 'section_donde_comprar';

    public const PLACEMENT_SECTION_NOSOTROS = 'section_nosotros';

    public const PLACEMENT_SECTION_RECETAS = 'section_recetas';

    protected $fillable = [
        'title',
        'subtitle',
        'image_path',
        'link_url',
        'placement',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Banners de hero por página (una fila por ubicación).
     *
     * @return array<string, string> placement => etiqueta para el panel
     */
    public static function sectionBannersDefinition(): array
    {
        return [
            self::PLACEMENT_SECTION_PRODUCTOS => 'Hero — página Productos',
            self::PLACEMENT_SECTION_DONDE_COMPRAR => 'Hero — página Dónde comprar',
            self::PLACEMENT_SECTION_NOSOTROS => 'Hero — página Nosotros',
            self::PLACEMENT_SECTION_RECETAS => 'Hero — página Recetas',
        ];
    }

    /**
     * @return list<string>
     */
    public static function sectionPlacementKeys(): array
    {
        return array_keys(self::sectionBannersDefinition());
    }

    public function isSectionHero(): bool
    {
        return in_array($this->placement, self::sectionPlacementKeys(), true);
    }
}

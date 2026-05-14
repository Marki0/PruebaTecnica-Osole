<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSection extends Model
{
    use HasFactory;

    /** Claves de los cuatro bloques de texto/imagen de la página Nosotros. */
    public const NOSOTROS_PAGE_BLOCK_KEYS = [
        'nosotros_bloque_1',
        'nosotros_bloque_2',
        'nosotros_bloque_3',
        'nosotros_bloque_4',
    ];

    protected $fillable = [
        'key',
        'title',
        'body',
        'extra',
    ];

    protected $casts = [
        'extra' => 'array',
    ];
}

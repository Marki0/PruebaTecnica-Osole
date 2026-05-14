<?php

/**
 * Home pública: imagen de fondo del hero y separadores.
 *
 * HOME_HERO_BACKGROUND_URL: URL absoluta o ruta bajo public/ (p. ej. nikitos/mi-hero.png).
 * Si está vacío, se busca en orden `hero-fondo.png` y otras en Nikitos/ (vía public/nikitos).
 */
return [
    'hero_background_url' => env('HOME_HERO_BACKGROUND_URL'),

    /**
     * PDF del catálogo bajo public/ (mismo origen = el atributo download funciona bien).
     * Ej.: catalogo-nikitos-2026.pdf
     */
    'catalog_pdf' => env('CATALOG_PDF_PATH', 'catalogo-nikitos-2026.pdf'),

    /** Nombre sugerido al guardar en el dispositivo del visitante. */
    'catalog_download_filename' => env('CATALOG_DOWNLOAD_FILENAME', 'Nikitos-Catalogo-2026.pdf'),
];

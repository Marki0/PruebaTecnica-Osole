<?php

namespace App\Support;

/**
 * Contenido de la página Nosotros: cuatro bloques (texto + imagen Nikitos).
 */
final class NosotrosPage
{
    /**
     * Convierte el cuerpo del textarea en párrafos (separá bloques con una línea en blanco).
     *
     * @return list<string>
     */
    public static function bodyParagraphs(?string $body): array
    {
        if ($body === null) {
            return [];
        }
        $trimmed = trim($body);
        if ($trimmed === '') {
            return [];
        }

        $parts = preg_split('/\R{2,}/u', $trimmed);
        if (! is_array($parts)) {
            return [$trimmed];
        }
        $parts = array_values(array_filter(array_map('trim', $parts), static function ($p) {
            return $p !== '';
        }));

        return $parts !== [] ? $parts : [$trimmed];
    }

    /**
     * Imagen de respaldo por índice de bloque (0–3) si no hay `extra.nikitos_image`.
     */
    public static function defaultNikitosImage(int $index): string
    {
        $files = [
            'Group 3798.png',
            'Mask group-4.png',
            'image 142.jpg',
            'image 181.png',
        ];

        return $files[$index] ?? 'producto.png';
    }

    /**
     * Valores por defecto para el seeder (mismo contenido que el mockup original).
     *
     * @return array<string, array{title: string, body: string, extra: array{nikitos_image: string, image_alt: string}}>
     */
    public static function seedDefaults(): array
    {
        return [
            'nosotros_bloque_1' => [
                'title' => '¿Quiénes somos?',
                'body' => "Nikitos se encuentra presente en el mercado local desde hace 40 años.\n\nActualmente cuenta con un amplio portfolio de snacks, tales como Pizzitos, Palitos salados, Maikitos de Queso, Papas Fritas, Cereales, Pochoclos Acaramelados, Bolitas/Aritos dulces, y Jugos para Congelar. El objetivo es llegar a los consumidores con ingredientes naturales y más saludables, contando con presencia de venta en todo el país y calidad de atención de excelencia.\n\nTrabajamos junto a nuestros colaboradores enérgicamente en la producción y desarrollo de nuevos productos creados específicamente para satisfacer los gustos y tendencias de los consumidores, para llegar a ser la compañía local de alimentos y bebidas, que sobresale por su calidad y precios bajos.",
                'extra' => [
                    'nikitos_image' => 'Group 3798.png',
                    'image_alt' => 'Instalaciones y producción Nikitos',
                ],
            ],
            'nosotros_bloque_2' => [
                'title' => 'Nuestra planta modelo',
                'body' => 'Con una vocación de reinversión permanente en tecnología de punta y de mejora continua en los procesos productivos, trabajamos para superar nuestros propios estándares de productividad, con operaciones industriales que se desarrollan bajo un Sistema de Gestión Integral (SGI) diseñado por y para Nikitos, que contempla las características propias de la empresa y las bases de las distintas herramientas para la gestión implementadas en el mercado. Contamos con una Planta Industrial de 5500m2, en Buenos Aires, Argentina y otra en Montevideo, Uruguay.',
                'extra' => [
                    'nikitos_image' => 'Mask group-4.png',
                    'image_alt' => 'Línea de producción de snacks',
                ],
            ],
            'nosotros_bloque_3' => [
                'title' => 'El equipo',
                'body' => 'La integración sinérgica y creativa de los recursos y valores humanos representa el más importante capital en Nikitos. Nuestra filosofía corporativa es mantener un crecimiento sustentable al invertir en un futuro más saludable para la gente y para nuestro planeta.',
                'extra' => [
                    'nikitos_image' => 'image 142.jpg',
                    'image_alt' => 'Equipo Nikitos en planta',
                ],
            ],
            'nosotros_bloque_4' => [
                'title' => 'Nuestra flota',
                'body' => 'Nuestro departamento de logística se especializa en realizar la distribución nacional de nuestros productos, contando con una Flota de Camiones, adecuados para su entrega en todo el territorio argentino.',
                'extra' => [
                    'nikitos_image' => 'image 181.png',
                    'image_alt' => 'Distribución y logística Nikitos',
                ],
            ],
        ];
    }
}

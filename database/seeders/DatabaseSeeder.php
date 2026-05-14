<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Recipe;
use App\Models\SiteSection;
use App\Models\User;
use App\Support\NosotrosPage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Copia un archivo desde Nikitos/ hacia storage/app/public si existe.
     */
    protected function copyNikitosToStorage(string $sourceName, string $destPath): bool
    {
        $src = base_path('Nikitos/'.$sourceName);
        if (! is_readable($src)) {
            return false;
        }

        Storage::disk('public')->put($destPath, file_get_contents($src));

        return true;
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@nikitos.test'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        SiteSection::query()->updateOrCreate(
            ['key' => 'home_snacks'],
            [
                'title' => 'Nikitos Snacks',
                'body' => 'Nikitos se encuentra presente en el mercado local desde hace casi 40 años.',
            ]
        );

        SiteSection::query()->updateOrCreate(
            ['key' => 'nosotros'],
            [
                'title' => 'Nosotros',
                'body' => 'Somos una empresa argentina dedicada a elaborar snacks con los más altos estándares de calidad. Ofrecemos una amplia variedad de productos: papas fritas, palitos, galletitas dulces, líneas escolares y formatos familiares, pensados para acompañar cada momento del día.',
            ]
        );

        SiteSection::query()->updateOrCreate(
            ['key' => 'contacto_page'],
            [
                'title' => 'Contacto',
                'body' => 'Escribinos y te respondemos a la brevedad.',
            ]
        );

        SiteSection::query()->updateOrCreate(
            ['key' => 'recetas_page'],
            [
                'title' => 'Recetas',
                'body' => 'Ideas para disfrutar nuestros snacks en casa.',
            ]
        );

        foreach (NosotrosPage::seedDefaults() as $key => $row) {
            SiteSection::query()->updateOrCreate(
                ['key' => $key],
                [
                    'title' => $row['title'],
                    'body' => $row['body'],
                    'extra' => $row['extra'],
                ]
            );
        }

        $nikitos = base_path('Nikitos');
        if (! is_dir($nikitos)) {
            return;
        }

        $sectionHeroes = [
            [Banner::PLACEMENT_SECTION_PRODUCTOS, 'Mask group-2.png', 'banners/section-productos.png'],
            [Banner::PLACEMENT_SECTION_DONDE_COMPRAR, 'Banner donde comprar.png', 'banners/section-donde-comprar.png'],
            [Banner::PLACEMENT_SECTION_NOSOTROS, 'Banner nosotros.png', 'banners/section-nosotros.png'],
            [Banner::PLACEMENT_SECTION_RECETAS, 'Banner productos.png', 'banners/section-recetas.png'],
        ];

        foreach ($sectionHeroes as [$placement, $src, $dest]) {
            $imagePath = null;
            if ($this->copyNikitosToStorage($src, $dest)) {
                $imagePath = $dest;
            }

            Banner::query()->updateOrCreate(
                ['placement' => $placement],
                [
                    'title' => null,
                    'subtitle' => null,
                    'link_url' => null,
                    'image_path' => $imagePath,
                    'sort_order' => 0,
                    'is_active' => true,
                ]
            );
        }

        $lines = config('nikitos_product_lines', []);
        $categoryBySlug = [];

        foreach ($lines as $order => $line) {
            $slug = $line['slug'];
            $dest = 'categories/seed-line-'.$slug.'.png';
            $srcName = $line['nikitos_image'] ?? null;

            $cat = Category::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $line['name'],
                    'description' => 'Línea '.$line['name'].'.',
                    'sort_order' => $order,
                    'accent_color' => $line['color'] ?? null,
                ]
            );

            if ($srcName && $this->copyNikitosToStorage($srcName, $dest)) {
                $cat->update(['image_path' => $dest]);
            }

            $categoryBySlug[$slug] = $cat->fresh();
        }

        $catTradicional = $categoryBySlug['tradicional-escolar'] ?? null;
        $catJuvenil = $categoryBySlug['juvenil-metalizada'] ?? null;
        $catMax = $categoryBySlug['linea-max'] ?? null;
        $catPremium120 = $categoryBySlug['premium-max-120g'] ?? null;

        $rows = [];
        if ($catTradicional) {
            $rows[] = [$catTradicional, 'Bolitas dulces 40 g', 'bolitas-dulces-40g', 'Bolitas dulces 40g.png', true, 0];
            $rows[] = [$catTradicional, 'Cereal de maíz 12 g', 'cereal-de-maiz-12g', 'Cereal de maiz 12g.png', false, 1];
        }
        if ($catJuvenil) {
            $rows[] = [$catJuvenil, 'Pizzitos jamón y queso 80 g', 'pizzitos-jamon-queso-80g', 'Pizzitos J y Q 80g.png', true, 0];
            $rows[] = [$catJuvenil, 'Maikitos de queso 80 g', 'maikitos-queso-80g', 'Maikitos de queso 80g.png', false, 1];
        }
        if ($catMax) {
            $rows[] = [$catMax, 'Papas fritas clásicas 30 g', 'papas-fritas-clasicas-30g', 'Papas F. c clasico 30g.png', true, 0];
            $rows[] = [$catMax, 'Papas fritas jamón serrano 65 g', 'papas-fritas-jamon-serrano-65g', 'Papas F. c jamon serr 65g.png', false, 1];
        }
        if ($catPremium120) {
            $rows[] = [$catPremium120, 'Palitos salados 80 g', 'palitos-salados-80g', 'Palitos salados 80g.png', true, 0];
            $rows[] = [$catPremium120, 'Nachos clásicos 200 g', 'nachos-clasicos-200g', 'Nachos clasicos 200g.png', false, 1];
        }

        foreach ($rows as $index => $row) {
            /** @var \App\Models\Category $cat */
            [$cat, $name, $slug, $file, $featured, $sortInCat] = $row;
            $dest = 'products/seed-'.$slug.'.png';
            if (! $this->copyNikitosToStorage($file, $dest)) {
                continue;
            }

            $product = Product::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $cat->id,
                    'name' => $name,
                    'description' => 'Producto Nikitos de la línea '.$cat->name.'.',
                    'is_featured' => $featured,
                    'sort_order' => $sortInCat + $index * 2,
                ]
            );

            ProductImage::query()->where('product_id', $product->id)->delete();
            ProductImage::query()->create([
                'product_id' => $product->id,
                'path' => $dest,
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }

        $recipeSeeds = [
            [
                'title' => 'Nachos de tacos en sartén',
                'slug' => 'nachos-de-tacos-en-sarten',
                'excerpt' => 'Rápido y crocante con Nachos Nikitos.',
                'body' => "Calentá una sartén con un poco de aceite.\nAgregá carne picada o vegetales a gusto.\nIncorporá los nachos al final para que no pierdan crocancia.\nServí con queso rallado y salsa.",
                'image' => 'Nachos clasicos 200g.png',
                'dest' => 'recipes/seed-nachos-tacos.png',
                'sort_order' => 0,
            ],
            [
                'title' => 'Barritas mágicas con papas fritas',
                'slug' => 'barritas-magicas-con-papas-fritas',
                'excerpt' => "Tiempo de preparación: 25 minutos\nPorciones: 10 porciones",
                'body' => "Para el chocolate:\n- 200 g de chocolate semiamargo\n- 1 cda de manteca\n\nPara las papas:\n- 3/4 taza de papas fritas Nikitos corte tradicional\n- 1 puñado de maní tostado (opcional)\n\n===PREPARACION===\nPaso 1 — Derretí el chocolate con la manteca a fuego bajo o en baño María.\nPaso 2 — Mezclá hasta que quede homogéneo y retirá del fuego.\nPaso 3 — Volcá el chocolate sobre las papas fritas extendidas en una bandeja con papel.\nPaso 4 — Espolvoreá el maní si lo usás y mezclá suavemente con cuchara.\nPaso 5 — Dejá enfriar a temperatura ambiente hasta que endurezca.\nPaso 6 — Cortá en barritas y serví.",
                'image' => 'Papas F. c ket y bar 65g.png',
                'dest' => 'recipes/seed-barritas.png',
                'sort_order' => 1,
            ],
            [
                'title' => 'Sándwich de pollo empanizado',
                'slug' => 'sandwich-de-pollo-empanizado',
                'excerpt' => "Tiempo de preparación: 35 minutos\nPorciones: 4 porciones",
                'body' => "Ingredientes:\n- 4 panes de hamburguesa\n- 4 filetes de pollo empanizados\n- Lechuga, tomate y mayonesa\n- Pizzitos jamón y queso para acompañar\n\n===PREPARACION===\nPaso 1 — Tostá ligeramente los panes.\nPaso 2 — Cociná las milanesas de pollo hasta que estén doradas.\nPaso 3 — Arma el sándwich con lechuga, tomate y mayonesa.\nPaso 4 — Serví con Pizzitos como snack lateral.",
                'image' => 'Pizzitos J y Q 80g.png',
                'dest' => 'recipes/seed-sandwich-pollo.png',
                'sort_order' => 2,
            ],
        ];

        foreach ($recipeSeeds as $r) {
            $imagePath = null;
            if ($this->copyNikitosToStorage($r['image'], $r['dest'])) {
                $imagePath = $r['dest'];
            }

            Recipe::query()->updateOrCreate(
                ['slug' => $r['slug']],
                [
                    'title' => $r['title'],
                    'excerpt' => $r['excerpt'],
                    'body' => $r['body'],
                    'image_path' => $imagePath,
                    'is_published' => true,
                    'sort_order' => $r['sort_order'],
                ]
            );
        }
    }
}

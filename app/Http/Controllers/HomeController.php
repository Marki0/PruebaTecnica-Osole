<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Recipe;
use App\Models\SiteSection;
use App\Support\NosotrosPage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class HomeController extends Controller
{
    /** @var \Illuminate\Support\Collection<string, Banner>|null */
    protected $sectionBannerCache = null;

    /** Claves de `site_sections` usadas en vistas públicas. */
    private const SITE_SECTION_KEYS = [
        'home_snacks',
        'nosotros',
        'contacto_page',
        'recetas_page',
    ];

    public function index(): View
    {
        $sections = $this->siteSections();
        $nikitosPublicLinked = $this->nikitosPublicLinked();
        $heroBackgroundImage = $this->resolveHeroBackgroundImageUrl();

        return view('home.index', [
            'heroBackgroundImage' => $heroBackgroundImage,
            'sectionSnacks' => $sections->get('home_snacks'),
            'sectionNosotros' => $sections->get('nosotros'),
            'nikitosPublicLinked' => $nikitosPublicLinked,
            'homeLineCategories' => $this->homeLineCategories(),
            'homeRecipes' => $this->homePreviewRecipes(),
            'featuredProducts' => $this->featuredHomeProducts(),
        ]);
    }

    public function productos(): View
    {
        $nikitosPublicLinked = $this->nikitosPublicLinked();
        $catalogCategories = $this->catalogCategoriesOrdered();

        return view('home.productos', [
            'catalogCategories' => $catalogCategories,
            'nikitosPublicLinked' => $nikitosPublicLinked,
            'category' => null,
            'heroBanner' => $this->sectionBanner(Banner::PLACEMENT_SECTION_PRODUCTOS),
        ]);
    }

    public function productosCategory(Category $category): View
    {
        $nikitosPublicLinked = $this->nikitosPublicLinked();
        $catalogCategories = $this->catalogCategoriesOrdered();

        $category->load([
            'products' => static function ($q) {
                $q->orderByDesc('is_featured')
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->with(['images' => static function ($q2) {
                        $q2->orderByDesc('is_primary')->orderBy('sort_order');
                    }]);
            },
        ]);

        return view('home.productos', [
            'catalogCategories' => $catalogCategories,
            'nikitosPublicLinked' => $nikitosPublicLinked,
            'category' => $category,
            'heroBanner' => $this->sectionBanner(Banner::PLACEMENT_SECTION_PRODUCTOS),
        ]);
    }

    public function dondeComprar(): View
    {
        return view('home.donde-comprar', [
            'nikitosPublicLinked' => $this->nikitosPublicLinked(),
            'dondeDistribuidores' => $this->dondeComprarDistribuidoresDemo(),
            'heroBanner' => $this->sectionBanner(Banner::PLACEMENT_SECTION_DONDE_COMPRAR),
        ]);
    }

    public function recetas(): View
    {
        $sections = $this->siteSections();
        $recipes = Recipe::query()
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->orderByDesc('updated_at')
            ->get();

        return view('home.recetas', [
            'sectionRecetas' => $sections->get('recetas_page'),
            'recipes' => $recipes,
            'nikitosPublicLinked' => $this->nikitosPublicLinked(),
            'heroBanner' => $this->sectionBanner(Banner::PLACEMENT_SECTION_RECETAS),
        ]);
    }

    public function recipeShow(Recipe $recipe): View
    {
        if (! $recipe->is_published) {
            abort(404);
        }

        return view('home.receta', [
            'recipe' => $recipe,
            'nikitosPublicLinked' => $this->nikitosPublicLinked(),
        ]);
    }

    public function nosotros(): View
    {
        $keys = SiteSection::NOSOTROS_PAGE_BLOCK_KEYS;
        $byKey = SiteSection::query()
            ->whereIn('key', $keys)
            ->get()
            ->keyBy('key');

        $nosotrosBlocks = collect($keys)->map(static function (string $key) use ($byKey) {
            return $byKey->get($key);
        });

        return view('home.nosotros', [
            'nikitosPublicLinked' => $this->nikitosPublicLinked(),
            'heroBanner' => $this->sectionBanner(Banner::PLACEMENT_SECTION_NOSOTROS),
            'nosotrosBlocks' => $nosotrosBlocks,
        ]);
    }

    public function contacto(): View
    {
        $sections = $this->siteSections();

        return view('home.contacto', [
            'sectionContacto' => $sections->get('contacto_page'),
        ]);
    }

    /**
     * Primeras categorías para la grilla “Líneas de productos” en la home.
     *
     * @return Collection<int, Category>
     */
    protected function homeLineCategories(): Collection
    {
        return Category::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->limit(4)
            ->get();
    }

    /**
     * Categorías ordenadas para la página Productos (cabecera de líneas).
     *
     * @return Collection<int, Category>
     */
    protected function catalogCategoriesOrdered(): Collection
    {
        return Category::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    /**
     * Recetas publicadas para el bloque preview de la home.
     *
     * @return Collection<int, Recipe>
     */
    protected function homePreviewRecipes(): Collection
    {
        return Recipe::query()
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->orderByDesc('updated_at')
            ->limit(3)
            ->get();
    }

    protected function nikitosPublicLinked(): bool
    {
        return is_dir(public_path('nikitos')) || is_link(public_path('nikitos'));
    }

    /**
     * Banners de hero por página (clave = placement).
     *
     * @return \Illuminate\Support\Collection<string, Banner>
     */
    protected function sectionBannersByPlacement(): Collection
    {
        if ($this->sectionBannerCache === null) {
            $this->sectionBannerCache = Banner::query()
                ->whereIn('placement', Banner::sectionPlacementKeys())
                ->get()
                ->keyBy('placement');
        }

        return $this->sectionBannerCache;
    }

    protected function sectionBanner(string $placement): ?Banner
    {
        return $this->sectionBannersByPlacement()->get($placement);
    }

    protected function isAbsoluteUrl(string $url): bool
    {
        return strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0;
    }

    /**
     * Imagen de fondo del hero cuando no hay carrusel de slides (respaldo visual).
     */
    protected function resolveHeroBackgroundImageUrl(): ?string
    {
        $configured = config('nikitos_home.hero_background_url');
        if (is_string($configured) && trim($configured) !== '') {
            $t = trim($configured);
            if ($this->isAbsoluteUrl($t)) {
                return $t;
            }

            return asset(ltrim($t, '/'));
        }

        $candidates = [
            'hero-fondo.png',
            'Papas F. c Clasico.png',
            'Banner productos 2.png',
            'Linea juvenil metalizada 1.png',
        ];
        foreach ($candidates as $file) {
            if (File::isReadable(public_path('nikitos/'.$file))) {
                return url('nikitos/'.rawurlencode($file));
            }
        }

        return null;
    }

    /**
     * @return Collection<int, Product>
     */
    protected function featuredHomeProducts(): Collection
    {
        $with = [
            'category',
            'images' => static function ($q) {
                $q->orderByDesc('is_primary')->orderBy('sort_order');
            },
        ];

        $featured = Product::query()
            ->with($with)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->limit(4)
            ->get();

        if ($featured->count() >= 4) {
            return $featured;
        }

        $need = 4 - $featured->count();
        $ids = $featured->pluck('id')->all();
        $more = Product::query()
            ->with($with)
            ->when($ids !== [], static function ($q) use ($ids) {
                $q->whereNotIn('id', $ids);
            })
            ->orderBy('sort_order')
            ->orderBy('id')
            ->limit($need)
            ->get();

        return $featured->concat($more)->take(4);
    }

    /**
     * @return Collection<string, SiteSection>
     */
    protected function siteSections()
    {
        return SiteSection::query()
            ->whereIn('key', self::SITE_SECTION_KEYS)
            ->get()
            ->keyBy('key');
    }

    /**
     * Lista demo para la maquetación de «Donde comprar» (sin modelo en BD).
     *
     * @return array<int, array{name: string, city: string, province: string}>
     */
    private function dondeComprarDistribuidoresDemo(): array
    {
        return [
            ['name' => 'Distribuidor Nikitos Sur', 'city' => 'La Plata', 'province' => 'Buenos Aires'],
            ['name' => 'Mayorista Avellaneda', 'city' => 'Avellaneda', 'province' => 'Buenos Aires'],
            ['name' => 'Depósito Lomas', 'city' => 'Lomas de Zamora', 'province' => 'Buenos Aires'],
            ['name' => 'Nikitos Centro', 'city' => 'CABA', 'province' => 'Ciudad Autónoma de Buenos Aires'],
            ['name' => 'Distribuidor Oeste', 'city' => 'Morón', 'province' => 'Buenos Aires'],
            ['name' => 'Snacks del Norte', 'city' => 'San Fernando', 'province' => 'Buenos Aires'],
            ['name' => 'Logística Sur', 'city' => 'Lanús', 'province' => 'Buenos Aires'],
            ['name' => 'Mayorista Quilmes', 'city' => 'Quilmes', 'province' => 'Buenos Aires'],
        ];
    }
}

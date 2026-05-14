# Nikitos — Prueba técnica (Laravel 8)

Réplica funcional del sitio **Nikitos** con **panel de administración** para gestionar contenido, imágenes y mensajes de contacto.

**Repositorio de entrega:** [github.com/Marki0/PruebaTecnica-Osole](https://github.com/Marki0/PruebaTecnica-Osole)

## Entrega — qué incluye este proyecto

- **Sitio público:** home, productos (por categoría), dónde comprar, recetas (listado y detalle por slug), nosotros, contacto (formulario con límite de envíos).
- **Panel `/admin`** (usuario administrador): textos por sección (`site_sections`), **banners**, **categorías** (incl. color de acento), **productos** (galería e imágenes optimizadas), **recetas**, lectura de **mensajes de contacto**.
- **Assets de diseño:** carpeta `Nikitos/` (export Figma) y comando Artisan `nikitos:link-assets` para enlazar imágenes a `public/nikitos`.
- **Front:** vistas Blade, estilos propios (`resources/css/site.css`, build con Laravel Mix + PostCSS/Tailwind según `package.json` / `webpack.mix.js`).

Stack principal: **Laravel 8**, **SQLite** por defecto (configurable a MySQL), **Intervention Image** para optimización de JPEG en banners, categorías y productos.

## Requisitos

- PHP `^7.3|^8.0` (compatible con Laravel 8 del `composer.json`)
- Composer
- Node.js y npm (assets con Laravel Mix)
- Extensiones PHP habituales: `openssl`, `pdo`, `pdo_sqlite` (SQLite) o `pdo_mysql` (MySQL), `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`
- Subida de imágenes (Intervention): **`gd` o `imagick`** (`php -m | grep -i gd`)

## Instalación

```bash
git clone https://github.com/Marki0/PruebaTecnica-Osole.git
cd PruebaTecnica-Osole
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
```

Por defecto `.env.example` usa **SQLite** (`DB_CONNECTION=sqlite`). El archivo `database/database.sqlite` no se versiona (está en `.gitignore`).

Migraciones y datos iniciales (ejecutá **un comando por línea**; no pegues comentarios `# ...` en la misma línea que `php artisan`, o Artisan puede fallar con *“got #”*).

```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan nikitos:link-assets
```

Para **reiniciar** la base y volver a sembrar (borra tablas y datos):

```bash
php artisan migrate:fresh --seed
php artisan storage:link
php artisan nikitos:link-assets
```

El comando `nikitos:link-assets` crea `public/nikitos` como enlace a la carpeta `Nikitos/` (export de Figma) para que la landing pueda servir esas imágenes. El seed copia algunos de esos archivos a `storage/app/public` para banners, categorías y productos de demostración.

Los avisos *Deprecated* de `voku/portable-ascii` al ejecutar Artisan suelen aparecer en PHP 8.2+ con Laravel 8; no impiden que los comandos terminen bien.

Assets front-end:

```bash
npm install
npm run dev
```

Servidor de desarrollo:

```bash
php artisan serve
```

## Acceso al panel

Tras el seed:

| Campo       | Valor                 |
|-------------|------------------------|
| Email       | `admin@nikitos.test`   |
| Contraseña | `password`            |

Cambiá la contraseña en entornos reales. Solo usuarios con `is_admin = true` pueden entrar al panel (`/admin`).

## Estructura relevante

- `routes/web.php` — páginas públicas: `/`, `/productos`, `/donde-comprar`, `/recetas`, `/nosotros`, `GET /contacto`; `POST /contacto` guarda el mensaje; login/logout
- `routes/admin.php` — panel bajo prefijo `/admin` (middleware `auth` + `admin`)
- `app/Http/Controllers/Admin/*` — panel: textos (`site_sections`), **banners** (CRUD + imagen), **categorías** y **productos** (imágenes optimizadas), **recetas**, **mensajes de contacto**
- Vistas en `resources/views/home/*.blade.php` (cabecera/pie compartidos en `partials/landing-*.blade.php` y `layouts/landing.blade.php`), helpers en `app/Support/Landing.php`
- Home `/`: imagen full-screen (`Nikitos/hero-fondo.png` o `HOME_HERO_BACKGROUND_URL` en `.env`); separador hero → naranja con `Nikitos/Vector-4.png` (ver `config/nikitos_home.php` y `partials/tear-vector4.blade.php`)
- Referencia de diseño: [prototipo Figma Nikitos](https://www.figma.com/proto/rMIU14zUYIY3Ci5A1bZYLy/Nikitos?page-id=0%3A1&node-id=2181-2957&viewport=431%2C389%2C0.02&t=Ak5PWNjAU2rrtwq1-1&scaling=min-zoom&content-scaling=fixed&starting-point-node-id=2181%3A2957)
- `app/Services/CategoryImageStorage.php` — categorías (JPEG optimizado)
- `app/Services/BannerImageStorage.php` — banners (JPEG optimizado, carpeta `banners/`)
- `app/Http/Middleware/EnsureUserIsAdmin.php` — restricción a administradores
- `app/Services/ProductImageStorage.php` — productos (carpeta `products/`)
- `app/Services/RecipeImageStorage.php` — recetas
- `app/Services/NosotrosBlockImageStorage.php` — bloques en “Nosotros”
- `database/migrations/*` — usuarios, secciones, banners, categorías, productos, imágenes, contacto, recetas

## Licencia

MIT (framework Laravel).

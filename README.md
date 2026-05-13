# Nikitos — Prueba técnica (Laravel 8)

Réplica funcional del sitio Nikitos con panel de administración. Este repositorio contiene la **base del proyecto**: Laravel 8, migraciones del dominio, rutas públicas y `/admin`, autenticación de administradores y vistas mínimas.

## Requisitos

- PHP `^7.3|^8.0` (compatible con Laravel 8 del `composer.json`)
- Composer
- Node.js y npm (assets con Laravel Mix)
- Extensiones PHP habituales: `openssl`, `pdo`, `pdo_sqlite` (SQLite) o `pdo_mysql` (MySQL), `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`
- Subida de imágenes (Intervention): **`gd` o `imagick`** (`php -m | grep -i gd`)

## Instalación

```bash
git clone <url-del-repo> && cd PruebaTecnica-Osole
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
```

Por defecto `.env.example` usa **SQLite** (`DB_CONNECTION=sqlite`). El archivo `database/database.sqlite` no se versiona (está en `.gitignore`).

Migraciones y datos iniciales:

```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

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

| Campo    | Valor               |
|----------|---------------------|
| Email    | `admin@nikitos.test` |
| Contraseña | `password`        |

Cambiá la contraseña en entornos reales. Solo usuarios con `is_admin = true` pueden entrar al panel (`/admin`).

## Estructura relevante

- `routes/web.php` — landing, login, logout, formulario de contacto (`POST /contacto`)
- `routes/admin.php` — panel bajo prefijo `/admin` (middleware `auth` + `admin`)
- `app/Http/Controllers/Admin/*` — panel: textos (`site_sections`), **banners** (CRUD + imagen), **categorías** y **productos** (imágenes optimizadas), **mensajes de contacto**
- Maquetación pública según [prototipo Figma Nikitos](https://www.figma.com/proto/rMIU14zUYIY3Ci5A1bZYLy/Nikitos?page-id=0%3A1&node-id=2181-2957&viewport=431%2C389%2C0.02&t=Ak5PWNjAU2rrtwq1-1&scaling=min-zoom&content-scaling=fixed&starting-point-node-id=2181%3A2957) (pendiente en la landing)
- `app/Services/CategoryImageStorage.php` — categorías (JPEG optimizado)
- `app/Services/BannerImageStorage.php` — banners (JPEG optimizado, carpeta `banners/`)
- `app/Http/Middleware/EnsureUserIsAdmin.php` — restricción a administradores
- `app/Services/ProductImageStorage.php` — productos (carpeta `products/`)
- `database/migrations/*` — usuarios, secciones, banners, categorías, productos, imágenes, contacto

## Licencia

MIT (framework Laravel).

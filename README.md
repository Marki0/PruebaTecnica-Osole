# Nikitos — Prueba técnica (Laravel 8)

Réplica funcional del sitio Nikitos con panel de administración. Este repositorio contiene la **base del proyecto**: Laravel 8, migraciones del dominio, rutas públicas y `/admin`, autenticación de administradores y vistas mínimas.

## Requisitos

- PHP `^7.3|^8.0` (compatible con Laravel 8 del `composer.json`)
- Composer
- Node.js y npm (assets con Laravel Mix)
- Extensiones PHP habituales: `openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`

## Instalación

```bash
git clone <url-del-repo> && cd PruebaTecnica-Osole
composer install
cp .env.example .env
php artisan key:generate
```

Configurá la base de datos en `.env` (`DB_*`). Para desarrollo rápido podés usar SQLite:

```env
DB_CONNECTION=sqlite
# y comentá DB_HOST, etc.; creá el archivo:
# touch database/database.sqlite
```

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
- `app/Http/Controllers/Admin/*` — controladores del dashboard (CRUD a completar)
- `app/Http/Middleware/EnsureUserIsAdmin.php` — restricción a administradores
- `database/migrations/*` — usuarios, secciones, banners, categorías, productos, imágenes, recetas, mensajes de contacto

## Licencia

MIT (framework Laravel y este proyecto salvo que indiques otra cosa).

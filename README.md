# Nikitos — Prueba técnica (Laravel 8)

Réplica funcional del sitio **Nikitos** con **panel de administración** para gestionar contenido, imágenes y mensajes de contacto.

**Repositorio de entrega:** [github.com/Marki0/PruebaTecnica-Osole](https://github.com/Marki0/PruebaTecnica-Osole)

## Entrega — qué incluye este proyecto

- **Sitio público:** home, productos (por categoría), dónde comprar, recetas (listado y detalle por slug), nosotros, contacto (formulario con límite de envíos).
- **Panel `/admin`** (usuario administrador): textos por sección (`site_sections`), **banners**, **categorías** (incl. color de acento), **productos** (galería e imágenes optimizadas), **recetas**, lectura de **mensajes de contacto**.
- **Assets de diseño:** carpeta `Nikitos/` (export Figma) y comando Artisan `nikitos:link-assets` para enlazar imágenes a `public/nikitos`.
- **Front:** vistas Blade, estilos propios (`resources/css/site.css`, build con Laravel Mix + PostCSS/Tailwind según `package.json` / `webpack.mix.js`).

Stack principal: **Laravel 8**, **SQLite** por defecto (configurable a MySQL), **Intervention Image** para optimización de JPEG en banners, categorías y productos.

---

## Estructura del proyecto

Vista general de carpetas y responsabilidad de cada una:

```
PruebaTecnica-Osole/
├── app/
│   ├── Console/Commands/          # Comandos Artisan (p. ej. nikitos:link-assets)
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/             # Panel: productos, categorías, recetas, banners, secciones, mensajes
│   │   │   └── Auth/              # Login / logout
│   │   ├── Middleware/            # auth, guest, admin (EnsureUserIsAdmin), CSRF, etc.
│   │   └── Requests/              # Form Requests (validación admin, contacto, login)
│   ├── Models/                    # Eloquent: User, Product, Category, Recipe, Banner, SiteSection, ContactMessage…
│   ├── Providers/                 # RouteServiceProvider (carga web.php, admin.php, api.php)
│   ├── Services/                  # Almacenamiento y optimización de imágenes (banners, productos, etc.)
│   └── Support/                   # Helpers de presentación (Landing, páginas Nosotros)
├── bootstrap/                     # Arranque de la aplicación
├── config/                        # nikitos_home.php, filesystems, database, etc.
├── database/
│   ├── factories/
│   ├── migrations/                # Esquema SQLite/MySQL (tablas y cambios incrementales)
│   └── seeders/                   # Datos demo y usuario admin
├── Nikitos/                       # Recursos gráficos del diseño (Figma); se enlazan a public con Artisan
├── public/                        # index.php, mix manifiestos, enlace simbólico storage, carpeta nikitos (tras comando)
├── resources/
│   ├── css/                       # site.css (Tailwind/PostCSS vía Mix)
│   ├── js/
│   └── views/                     # Blade: layouts, home/, admin/, auth/, partials/
├── routes/
│   ├── web.php                    # Rutas públicas, contacto, login
│   ├── admin.php                  # Rutas del panel bajo prefijo /admin
│   └── api.php                    # API mínima (Sanctum /user)
├── storage/                       # app, framework, logs (writable en servidor)
├── tests/
├── composer.json
├── package.json
└── webpack.mix.js
```

### Rutas y capas principales

| Ubicación | Uso |
|-----------|-----|
| `routes/web.php` | Páginas públicas (`/`, `/productos`, `/donde-comprar`, `/recetas`, `/nosotros`, `GET /contacto`), `POST /contacto`, login/logout |
| `routes/admin.php` | Panel bajo `/admin` con middleware `web` + `auth` + `admin` |
| `app/Http/Controllers/HomeController.php` | Lógica del sitio público y consultas a modelos |
| `app/Http/Controllers/ContactController.php` | Alta de mensajes de contacto |
| `app/Http/Controllers/Admin/*` | CRUD y gestión del panel |
| `resources/views/home/*.blade.php` | Vistas del sitio; cabecera/pie en `partials/landing-*.blade.php` y `layouts/landing.blade.php` |
| `app/Support/Landing.php` | URLs de imágenes y tonos de categoría en vistas |
| `app/Http/Middleware/EnsureUserIsAdmin.php` | Solo usuarios con `is_admin` acceden al panel |
| `database/migrations/*` | Usuarios, secciones, banners, categorías, productos, imágenes, contacto, recetas |

Referencia de diseño: [prototipo Figma Nikitos](https://www.figma.com/proto/rMIU14zUYIY3Ci5A1bZYLy/Nikitos?page-id=0%3A1&node-id=2181-2957&viewport=431%2C389%2C0.02&t=Ak5PWNjAU2rrtwq1-1&scaling=min-zoom&content-scaling=fixed&starting-point-node-id=2181%3A2957)

---

## Requisitos

- PHP `^7.3|^8.0` (compatible con Laravel 8 del `composer.json`)
- Composer
- Node.js y npm (assets con Laravel Mix)
- Extensiones PHP habituales: `openssl`, `pdo`, `pdo_sqlite` (SQLite) o `pdo_mysql` (MySQL), `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`
- Subida de imágenes (Intervention): **`gd` o `imagick`** (`php -m | grep -i gd`)

---

## Instalación (desarrollo local)

Seguí los pasos en orden. Si algo falla, revisá la sección **Problemas frecuentes** más abajo.

### 1. Obtener el código e instalar dependencias PHP

```bash
git clone https://github.com/Marki0/PruebaTecnica-Osole.git
cd PruebaTecnica-Osole
composer install
```

`composer install` descarga Laravel y paquetes (Intervention Image, Sanctum, etc.).

### 2. Entorno y clave de aplicación

```bash
cp .env.example .env
php artisan key:generate
```

Editá `.env` si querés cambiar `APP_NAME`, `APP_URL` (debe coincidir con la URL desde la que abrís el sitio, p. ej. `http://127.0.0.1:8000` al usar `php artisan serve`).

Variables opcionales documentadas en `.env.example`: `HOME_HERO_BACKGROUND_URL`, `CATALOG_PDF_PATH`, `CATALOG_DOWNLOAD_FILENAME`.

### 3. Base de datos

**Opción A — SQLite (recomendado para probar rápido)**

Por defecto `.env.example` trae `DB_CONNECTION=sqlite`. Creá el archivo de base de datos:

```bash
touch database/database.sqlite
```

No hace falta definir `DB_DATABASE` salvo que quieras otra ruta absoluta al `.sqlite`.

**Opción B — MySQL**

En `.env`, comentá o borrá la sección SQLite y descomentá/ajustá:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nikitos
DB_USERNAME=root
DB_PASSWORD=tu_password
```

Creá la base `nikitos` (o el nombre que elijas) antes de migrar.

### 4. Migraciones, datos de prueba y enlaces

Ejecutá **un comando por línea**. No pegues comentarios `# ...` en la misma línea que `php artisan`, o Artisan puede fallar con *“got #”*.

```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan nikitos:link-assets
```

- **`migrate`**: crea tablas según `database/migrations/`.
- **`db:seed`**: usuario admin y datos demo (categorías, productos, etc.); copia parte de las imágenes a `storage/app/public`.
- **`storage:link`**: enlace `public/storage` → `storage/app/public` (URLs de imágenes subidas al panel).
- **`nikitos:link-assets`**: crea `public/nikitos` apuntando a la carpeta `Nikitos/` para servir el pack gráfico en la landing.

### 5. Assets front-end (CSS/JS con Mix)

```bash
npm install
npm run dev
```

- **`npm run dev`**: compila una vez (desarrollo).
- **`npm run prod`**: build minificado para producción.

Los estilos principales están en `resources/css/site.css`; la salida va a `public/css/` según `webpack.mix.js`.

### 6. Servidor de desarrollo

```bash
php artisan serve
```

Abrí en el navegador la URL que indique Artisan (por defecto `http://127.0.0.1:8000`).

### Reiniciar base y volver a sembrar

Borra tablas y datos y vuelve a crear todo:

```bash
php artisan migrate:fresh --seed
php artisan storage:link
php artisan nikitos:link-assets
```

Los avisos *Deprecated* de `voku/portable-ascii` al ejecutar Artisan suelen aparecer en PHP 8.2+ con Laravel 8; no impiden que los comandos terminen bien.

### Problemas frecuentes

- **`SQLSTATE[HY000]` / no encuentra la base SQLite:** comprobá que exista `database/database.sqlite` y que `DB_CONNECTION=sqlite` en `.env`.
- **Imágenes rotas en el sitio:** ejecutá `php artisan nikitos:link-assets` y `php artisan storage:link`; verificá que exista la carpeta `Nikitos/` en la raíz del proyecto.
- **Errores al subir archivos en el panel:** revisá permisos de escritura en `storage/` y `bootstrap/cache/`.
- **Mix / `manifest.json` no encontrado:** corré `npm run dev` al menos una vez después de clonar.

---

## Acceso al panel

Tras el seed:

| Campo       | Valor                 |
|-------------|------------------------|
| Email       | `admin@nikitos.test`   |
| Contraseña | `password`            |

Cambiá la contraseña en entornos reales. Solo usuarios con `is_admin = true` pueden entrar al panel (`/admin`).

---

## Licencia

MIT (framework Laravel).

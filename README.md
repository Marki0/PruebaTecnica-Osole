# Nikitos — Prueba técnica (Laravel 8, PHP 8.2+)

Réplica funcional del sitio **Nikitos** con **panel de administración** para gestionar contenido, imágenes y mensajes de contacto.

**Repositorio de entrega:** [github.com/Marki0/PruebaTecnica-Osole](https://github.com/Marki0/PruebaTecnica-Osole)

## Entrega — qué incluye este proyecto

- **Sitio público:** home, productos (por categoría), dónde comprar, recetas (listado y detalle por slug), nosotros, contacto (formulario con límite de envíos).
- **Panel `/admin`** (usuario administrador): textos por sección (`site_sections`), **banners**, **categorías** (incl. color de acento), **productos** (galería e imágenes optimizadas), **recetas**, lectura de **mensajes de contacto**.
- **Assets de diseño:** carpeta `Nikitos/` (export Figma) y comando Artisan `nikitos:link-assets` para enlazar imágenes a `public/nikitos`.
- **Front:** vistas Blade, estilos propios (`resources/css/site.css`, build con Laravel Mix + PostCSS/Tailwind según `package.json` / `webpack.mix.js`).

Stack principal: **Laravel 8** (`laravel/framework` ^8.75), **SQLite** por defecto (configurable a MySQL), **Intervention Image** para optimización de JPEG en banners, categorías y productos.

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

### Versiones (importante)

| Herramienta | Versión |
|-------------|---------|
| **PHP** | **8.2, 8.3 o 8.4** (recomendado **8.2.x** o **8.3.x** para este repo). **No** PHP 7.4 ni 8.0/8.1: el `composer.lock` actual trae dependencias (p. ej. `brick/math`) que exigen **PHP ≥ 8.2**. **PHP 8.5** suele funcionar, pero Laravel 8 muestra más *deprecated* en consola. |
| **Composer** | **2.x** (`composer --version`) |
| **Node.js** | **LTS 18+** (para `npm` y Laravel Mix) |

Antes de instalar, comprobá la versión que usa la terminal (no la del IDE):

```bash
php -v
# Debe indicar 8.2.x, 8.3.x o 8.4.x
```

En macOS con Homebrew, si `php -v` muestra 8.5 u otra mayor, podés priorizar 8.2 en esa sesión con `source bin/use-php-8.2.sh` (ver script en la raíz del repo).

### Extensiones PHP

- `openssl`, `pdo`, `pdo_sqlite` (SQLite) o `pdo_mysql` (MySQL), `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`
- Subida de imágenes (Intervention): **`gd` o `imagick`** (`php -m | grep -i gd`)

### Nota sobre `composer.json` y `composer.lock`

- En **`composer.json`** el requisito de PHP está alineado con lo que permite el **lock actual**: **`^8.2`** (PHP 8.2 hasta &lt; 9.0).
- **`composer install`** respeta el lock: si Composer se queja de “platform”, casi siempre es porque la versión de PHP del sistema **no cumple** lo que piden los paquetes bloqueados. No es un fallo del código de la app, sino del entorno.

---

## Instalación (desarrollo local)

Seguí los pasos en orden. Si algo falla, revisá **Problemas frecuentes** más abajo.

### 0. PHP y Composer

1. Asegurate de tener **PHP 8.2+** activo en la misma terminal donde vas a correr Composer (`php -v`).
2. Instalá dependencias **solo cuando** el punto anterior sea correcto.

### 1. Obtener el código e instalar dependencias PHP

```bash
git clone https://github.com/Marki0/PruebaTecnica-Osole.git
cd PruebaTecnica-Osole
composer install
```

`composer install` instala lo definido en **`composer.lock`** (Laravel 8, Intervention Image, Sanctum, etc.). No hace falta `composer update` para una primera instalación en condiciones normales.

### 2. Entorno y clave de aplicación

```bash
cp .env.example .env
php artisan key:generate
```

El segundo comando **debe** ejecutarse con el mismo PHP con el que correrás la app (el del paso 0). Si falla, revisá que `composer install` haya terminado bien y que `vendor/` exista.

Editá `.env` si querés cambiar `APP_NAME`, `APP_URL` (debe coincidir con la URL desde la que abrís el sitio, p. ej. `http://127.0.0.1:8000` al usar `php artisan serve`).

Variables opcionales documentadas en `.env.example`: `HOME_HERO_BACKGROUND_URL`, `CATALOG_PDF_PATH`, `CATALOG_DOWNLOAD_FILENAME`.

### 3. Base de datos

**Opción A — SQLite (recomendado para probar rápido)**

Por defecto `.env.example` trae `DB_CONNECTION=sqlite`. Creá el archivo de base de datos:

```bash
database/database.sqlite
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

Los avisos *Deprecated* de `voku/portable-ascii` al ejecutar Artisan suelen aparecer en **PHP 8.2+** con Laravel 8; en general **no** impiden que los comandos terminen bien.

### Problemas frecuentes

- **`composer install` falla por “platform” / versión de PHP:** el lock está pensado para **PHP 8.2 a 8.4**. Corré `php -v` y, si hace falta, cambiá de versión (p. ej. Homebrew `php@8.2`) o `source bin/use-php-8.2.sh`. Para ver qué paquete bloquea una versión más vieja de PHP: `composer why-not php 8.1.0` (cambiá la versión de ejemplo).
- **`Your requirements could not be resolved` al hacer `composer update`:** es distinto de `install`: mezcla versiones nuevas de paquetes; para reproducir la entrega, preferí **`composer install`** con PHP compatible.
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

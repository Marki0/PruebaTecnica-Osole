# Arquitectura del back-end (Nikitos)

Este documento resume cómo está organizada la aplicación Laravel para que puedas ubicarte rápido.

## Capas y responsabilidades

| Capa | Ubicación | Rol |
|------|-----------|-----|
| **Rutas HTTP** | `routes/web.php`, `routes/admin.php` | Definen URLs públicas y del panel. El panel usa prefijo `/admin`, nombre de rutas `admin.*` y middleware `web`, `auth`, `admin`. |
| **Controladores** | `app/Http/Controllers/` | `HomeController` sirve la landing; `ContactController` persiste el formulario; `Admin/*` el CRUD del panel; `Auth/LoginController` el acceso. |
| **Form Requests** | `app/Http/Requests/` | Validación y autorización declarativa (`authorize()` + `rules()`). Login: `Auth/LoginRequest`. |
| **Modelos** | `app/Models/` | Eloquent: `User`, `SiteSection`, `Banner`, `Category`, `Product`, `ProductImage`, `Recipe`, `ContactMessage`. |
| **Servicios de archivos** | `app/Services/*ImageStorage.php` | Subida + optimización con Intervention Image (redimensionado JPEG, calidad ~85). Un servicio por tipo de recurso (producto, banner, categoría, receta). |
| **Soporte** | `app/Support/Landing.php` | URLs de la landing: productos, categorías, recetas, **heroes de sección** (`sectionHeroImageUrl`).

## Flujo de datos (resumen)

1. **Contenido editable** (`site_sections`): claves fijas (`home_snacks`, `nosotros` resumen en home, `nosotros_bloque_1` … `nosotros_bloque_4` para la página Nosotros con párrafos e imagen Nikitos, `contacto_page`, `recetas_page`). El admin lista y edita título/cuerpo; en los bloques de Nosotros también `extra.nikitos_image` y `image_alt`.
2. **Banners de sección (heroes)**: `banners` con `placement` fijo: `section_productos`, `section_donde_comprar`, `section_nosotros`, `section_recetas` → cada uno alimenta el hero de esa página. El panel lista los cuatro con vista previa y etiqueta. Si falta imagen o está inactivo, `Landing::sectionHeroImageUrl()` usa un PNG de respaldo en `public/nikitos`. El **hero de la home** (`/`) sigue aparte: `config/nikitos_home.php` / `resolveHeroBackgroundImageUrl()`.
3. **Catálogo**: `categories` → `products` → `product_images`. Las tarjetas de “líneas” en home y productos leen categorías desde la BD; el color de acento puede guardarse en `accent_color` o heredarse del `config/nikitos_product_lines.php` por slug.
4. **Recetas**: tabla `recipes`; listado público solo `is_published`; detalle en `/recetas/{slug}`.
5. **Contacto**: `POST /contacto` → `contact_messages`; el admin solo lectura y marca `read_at` al abrir un mensaje.

## Seguridad

- Rutas `/admin/*`: middleware `EnsureUserIsAdmin` (además de `auth`).
- Login: solo usuarios con `is_admin` entran al panel.
- Formularios: validación centralizada en Form Requests; CSRF en Blade (`@csrf`).

## Rendimiento (consultas)

- Listados admin usan `with()` / `withCount()` donde aplica (productos con categoría e imagen principal, etc.).
- Home: consultas acotadas (`limit` en destacados y preview de recetas).

Tras cambios en CSS fuente (`resources/css/`), compilá assets con `npm run dev` o `npm run production`.

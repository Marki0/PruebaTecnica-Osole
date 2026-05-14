<div
    class="nk-footer-plate{{ request()->routeIs('home') ? ' nk-footer-plate--home' : '' }}"
    style="--nk-footer-vector4: url('{{ \App\Support\Landing::nk('Vector-4.png') }}')"
>
    <footer class="nk-footer nk-footer--on-vector">
        <div class="nk-wrap nk-footer__grid">
            <div class="nk-footer__brand">
                <a href="{{ route('home') }}" class="nk-footer__logo-link" aria-label="Nikitos Snacks inicio">
                    <img class="nk-footer__logo-img" src="{{ \App\Support\Landing::nk('image 177.png') }}" alt="Nikitos snacks" width="220" height="62" loading="lazy" decoding="async">
                </a>
                <div class="nk-footer__social">
                    <a href="#" aria-label="Facebook" class="nk-social">f</a>
                    <a href="#" aria-label="Instagram" class="nk-social">in</a>
                </div>
            </div>
            <div>
                <h3 class="nk-footer__h">Secciones</h3>
                <ul class="nk-footer__list">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('productos') }}">Productos</a></li>
                    <li><a href="{{ route('donde-comprar') }}">Donde comprar</a></li>
                    <li><a href="{{ route('recetas') }}">Recetas</a></li>
                    <li><a href="{{ route('nosotros') }}">Nosotros</a></li>
                    <li><a href="{{ route('contacto') }}">Contacto</a></li>
                </ul>
            </div>
            <div>
                <h3 class="nk-footer__h">Suscribite al Newsletter</h3>
                <form class="nk-newsletter" id="nk-newsletter" action="#" method="get">
                    <input type="email" name="newsletter_email" placeholder="Tu email" autocomplete="email" aria-label="Email newsletter">
                    <button type="submit" aria-label="Enviar">→</button>
                </form>
            </div>
            <div>
                <h3 class="nk-footer__h">Contacto</h3>
                <p class="nk-footer__contact">Av. Ejemplo 1234, CABA<br>Tel: +54 11 0000-0000<br>info@nikitos.test<br>Lun a Vie 9–18 hs</p>
            </div>
        </div>
        <div class="nk-footer__bar nk-wrap">
            <span>© {{ date('Y') }} Nikitos Snacks</span>
            <span>By Marcos Miño — <a href="{{ route('login') }}">Panel admin</a></span>
        </div>
    </footer>
</div>

<a class="nk-fab" id="nk-fab-chat" href="{{ route('contacto') }}" aria-label="Ir a contacto">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <path d="M4 6h16v10H8l-4 4V6z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
    </svg>
</a>

<div class="nk-modal" id="product-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="product-modal-title">
    <div class="nk-modal__backdrop" data-close-modal></div>
    <div class="nk-modal__dialog">
        <button type="button" class="nk-modal__close" data-close-modal aria-label="Cerrar">×</button>
        <div class="nk-modal__img">
            <img id="product-modal-img" src="" alt="">
        </div>
        <div class="nk-modal__body">
            <h3 id="product-modal-title"></h3>
            <p id="product-modal-desc"></p>
        </div>
    </div>
</div>

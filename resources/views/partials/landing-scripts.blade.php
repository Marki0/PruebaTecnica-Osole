<script>
    (function () {
        var drawer = document.getElementById('nk-drawer');
        var openBtn = document.getElementById('nk-open-menu');
        var closeBtn = document.getElementById('nk-close-menu');
        var drawerBackdrop = document.getElementById('nk-drawer-backdrop');
        function openDrawer() {
            if (drawer) drawer.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        }
        function closeDrawer() {
            if (drawer) drawer.classList.remove('is-open');
            document.body.style.overflow = '';
        }
        if (openBtn) openBtn.addEventListener('click', openDrawer);
        if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
        if (drawerBackdrop) drawerBackdrop.addEventListener('click', closeDrawer);
        if (drawer) {
            drawer.querySelectorAll('a').forEach(function (a) {
                a.addEventListener('click', closeDrawer);
            });
        }

        var nl = document.getElementById('nk-newsletter');
        if (nl) {
            nl.addEventListener('submit', function (e) {
                e.preventDefault();
                window.alert('Newsletter: demostración visual. No se envían datos.');
            });
        }

        var modal = document.getElementById('product-modal');
        if (modal) {
            var mImg = document.getElementById('product-modal-img');
            var mTitle = document.getElementById('product-modal-title');
            var mDesc = document.getElementById('product-modal-desc');

            function openModal(card) {
                mImg.src = card.getAttribute('data-img') || '';
                mImg.alt = card.getAttribute('data-title') || '';
                mTitle.textContent = card.getAttribute('data-title') || '';
                mDesc.textContent = card.getAttribute('data-desc') || '';
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            }
            function closeModal() {
                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            }

            document.querySelectorAll('.nk-open-modal').forEach(function (card) {
                card.addEventListener('click', function () { openModal(card); });
                card.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        openModal(card);
                    }
                });
            });
            modal.querySelectorAll('[data-close-modal]').forEach(function (el) {
                el.addEventListener('click', closeModal);
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
            });
        }
    })();
</script>

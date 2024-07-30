<button id="toTop" class="to-top" aria-label="Scroll to top">
    ↑
</button>

<footer class="footer">
    <div class="footer__container">
        <?php if (has_custom_logo()) : ?>
            <div class="footer__logo">
                <?php the_custom_logo(); ?>
            </div>
        <?php endif; ?>

        <nav class="footer__nav">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'footer_menu',
                'menu_id'        => 'footer-menu',
                'container'      => false,
                'menu_class'     => 'footer__menu',
            ));
            ?>
        </nav>
        <div class="footer__right-container">
        <div class="footer__social">
            <?php
            $facebook_url = get_theme_mod('facebook_url'); 
            if ($facebook_url) :
            ?>
                <a href="<?php echo esc_url($facebook_url); ?>" target="_blank" aria-label="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
            <?php endif; ?>
        </div>

            <p class="footer__rights">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Tous droits réservés.</p>
        </div>
    </div>
    <div class="footer__bottom">Made by <a href="https://www.charlymuziotti.fr/" target="_blank">Charly Muziotti</a> with ❤️</div>
</footer>

<?php wp_footer(); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toTopButton = document.getElementById('toTop');

        window.addEventListener('scroll', function() {
            if (window.scrollY > 100) {
                toTopButton.classList.add('show');
            } else {
                toTopButton.classList.remove('show');
            }
        });

        toTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        var header = document.querySelector('.header');
        var lastScrollTop = 0;
        var isHeaderHidden = false;

        window.addEventListener('scroll', function() {
            var scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            // Si l'utilisateur fait défiler vers le bas et que le header est visible
            if (scrollTop > lastScrollTop && !isHeaderHidden && scrollTop > 50) {
                header.classList.add('header-hidden');
                isHeaderHidden = true;
            }
            // Si l'utilisateur fait défiler vers le haut et que le header est caché
            else if (scrollTop < lastScrollTop && isHeaderHidden) {
                header.classList.remove('header-hidden');
                isHeaderHidden = false;
            }

            lastScrollTop = scrollTop;
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        var burgerMenu = document.querySelector('.header__burger-menu');
        var navMenu = document.querySelector('.header__nav');

        burgerMenu.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            if (document.body.style.overflow === 'hidden') {
                document.body.style.overflow = '';
            } else {
                document.body.style.overflow = 'hidden';
            }
            burgerMenu.classList.toggle('active');
        });
    });
</script>
</body>

</html>
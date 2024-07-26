<footer class="footer">
    <nav class="footer__nav">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'menu_id'        => 'primary-menu',
        ));
        ?>
    </nav>
    <?php if (has_custom_logo()) : ?>
        <div class="footer__logo">
            <?php the_custom_logo(); ?>
        </div>
    <?php endif; ?>
    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Tous droits réservés</p>
</footer>

<?php wp_footer(); ?>
<script>
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
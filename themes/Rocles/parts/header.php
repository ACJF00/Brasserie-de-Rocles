<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <header class="header">
        <div class="header__logo-container">
            <?php if (has_custom_logo()) : ?>
                <div class="header__logo-container--logo">
                    <?php the_custom_logo(); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="header__description">
            <?php if (is_front_page() && is_home()) : ?>
                <h1 class="header__description--title"><?php bloginfo('name'); ?></h1>
            <?php else : ?>
                <p class="header__description--title"><?php bloginfo('name'); ?></p>
            <?php endif; ?>
            <p class="header__description--description"><?php bloginfo('description'); ?></p>
        </div>

        <button class="header__burger-menu" aria-label="Menu">
            <span class="header__burger-menu--line"></span>
            <span class="header__burger-menu--line"></span>
            <span class="header__burger-menu--line"></span>
        </button>

        <nav class="header__nav" id="primary-menu">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_id'        => 'primary-menu',
            ));
            ?>
        </nav>
    </header>
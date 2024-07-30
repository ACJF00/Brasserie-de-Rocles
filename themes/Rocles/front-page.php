<?php get_template_part('parts/header'); ?>

<div class="content-area">
  <div class="hero-section">
    <div class="hero-overlay"></div>
    <?php
    // Récupérer les champs ACF
    $hero = get_field('hero');
    $hero_title = $hero['hero_title'];
    $hero_txt = $hero['hero_txt'];

    // Récupérer les images du champ ACF 'hero'
    $hero_images = array();
    for ($i = 1; $i <= 10; $i++) {
      if (!empty($hero['hero_image_' . $i])) {
        $hero_images[] = $hero['hero_image_' . $i];
      }
    }

    if (!empty($hero_images)) :
    ?>
      <div class="hero-text">
        <?php if ($hero_title) : ?>
          <h1 class="hero-title"><?php echo esc_html($hero_title); ?></h1>
        <?php endif; ?>

        <?php if ($hero_txt) : ?>
          <p class="hero-txt"><?php echo esc_html($hero_txt); ?></p>
        <?php endif; ?>
      </div>

      <div class="swiper-container hero-swiper">
        <div class="swiper-wrapper">
          <?php foreach ($hero_images as $image) : ?>
            <div class="swiper-slide">
              <div class="hero-content" style="background-image: url('<?php echo esc_url($image['url']); ?>');"></div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <main class="site-main">
    <?php
    // Débogage des posts pour voir s'ils sont bien récupérés
    if (have_posts()) :
      while (have_posts()) : the_post();
    ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <!-- <header class="entry-header">
            <h2 class="entry-title"><?php the_title(); ?></h2>
          </header> -->
          <div class="entry-content">
            <?php the_content(); ?>

            <div class="gamme-container site-wrap">
              <?php
              // Récupérer le groupe de champs ACF 'gamme_de_bieres'
              $gamme = get_field('gamme_de_bieres');

              if ($gamme) :
                // Récupérer les sous-champs
                $title_gamme = isset($gamme['title_gamme']) ? $gamme['title_gamme'] : '';
                $text_gamme = isset($gamme['text_gamme']) ? $gamme['text_gamme'] : '';
                $image_gamme = isset($gamme['image_gamme']) ? $gamme['image_gamme'] : '';

                if ($title_gamme || $text_gamme || $image_gamme) : ?>
                  <div class="gamme-container__content">
                    <?php if ($title_gamme) : ?>
                      <h2><?php echo esc_html($title_gamme); ?></h2>
                    <?php endif; ?>

                    <?php if ($text_gamme) : ?>
                      <div class="gamme-text">
                        <p><?php echo $text_gamme; ?></p>
                      </div>
                    <?php endif; ?>

                    <a href="<?php echo esc_url(home_url('/toutes-nos-bieres')); ?>" class="button">Voir toutes les bières</a>

                    <?php if ($image_gamme) : ?>
                      <div class="gamme-image">
                        <img src="<?php echo esc_url($image_gamme['url']); ?>" alt="<?php echo esc_attr($image_gamme['alt']); ?>">
                      </div>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            </div>

            <div class="presentation-container">
              <?php
              // Récupérer le groupe de champs ACF 'presentation'
              $presentation = get_field('presentation');
              if ($presentation) :
                // Récupérer le champ 'presentation_title'
                $presentation_title = isset($presentation['title_presentation']) ? $presentation['title_presentation'] : '';
                if ($presentation_title) : ?>
                  <h2><?php echo esc_html($presentation_title); ?></h2>
                <?php endif; ?>
                <div class="presentation-container__content site-wrap">
                  <?php
                  if (!empty($presentation['texte_presentation'])) : ?>
                    <div class="display-text">
                      <p><?php echo $presentation['texte_presentation']; ?></p>
                    </div>
                  <?php endif;

                  if (!empty($presentation['image_presentation'])) :
                    $image = $presentation['image_presentation']; ?>
                    <div class="presentation-container__content__image">
                      <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                    </div>
                  <?php endif;
                else : ?>
                  <p>Le champ ACF 'presentation' est vide ou introuvable.</p>
                  <?php
                  // Afficher toutes les valeurs des champs ACF pour déboguer
                  $fields = get_field_objects();
                  if ($fields) {
                    echo '<pre>' . print_r($fields, true) . '</pre>';
                  } else {
                    echo '<p>Aucun champ ACF trouvé.</p>';
                  }
                  ?>
                <?php endif; ?>
                </div>
            </div>

            <div class="points-de-vente-container site-wrap">
              <h2>Nos points de vente</h2>
              <div class="swiper-container swiper-points-de-vente">
                <div class="swiper-wrapper">
                  <?php
                  // La boucle pour afficher tous les points de vente
                  $args = array(
                    'post_type' => 'point_de_vente',
                    'posts_per_page' => -1, // Afficher tous les points de vente
                  );

                  $points_de_vente_query = new WP_Query($args);

                  if ($points_de_vente_query->have_posts()) :
                    while ($points_de_vente_query->have_posts()) : $points_de_vente_query->the_post();
                      // Récupérer les champs personnalisés
                      $adresse_complete = get_field('adresse_complete');
                      $ville = get_field('ville');
                      $adresse = get_field('adresse');
                      $site_web = get_field('site_web');
                      $logo = get_field('logo');

                      // Générer le lien Google Maps
                      $google_maps_link = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($adresse_complete);
                  ?>
                      <div class="swiper-slide">
                        <div class="point-de-vente-container">
                          <?php if ($logo) : ?>
                            <div class="point-de-vente-logo">
                              <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>">
                            </div>
                          <?php else : ?>
                            <div class="point-de-vente-logo">
                              <img src="<?php echo esc_url(get_template_directory_uri() . '/images/icon_generic.png'); ?>" alt="Default Logo">
                            </div>
                          <?php endif; ?>

                          <?php if ($site_web) : ?>
                            <a href="<?php echo esc_url($site_web); ?>" target="_blank">
                              <h3 class="point-de-vente-title"><?php the_title(); ?></h3>
                            </a>
                          <?php else : ?>
                            <h3 class="point-de-vente-title"><?php the_title(); ?></h3>
                          <?php endif; ?>

                          <?php if ($ville) : ?>
                            <h4 class="point-de-vente-ville"><?php echo esc_html($ville); ?></h4>
                          <?php endif; ?>

                          <?php if ($adresse) : ?>
                            <p class="point-de-vente-address"><?php echo esc_html($adresse); ?></p>
                          <?php endif; ?>

                          <?php if ($adresse_complete) : ?>
                            <a href="<?php echo esc_url($google_maps_link); ?>" target="_blank" class="google-maps-link">
                              <p>Google Map</p>
                            </a>
                          <?php endif; ?>
                        </div>
                      </div>
                  <?php
                    endwhile;
                    wp_reset_postdata();
                  else :
                    echo '<p>Aucun point de vente trouvé.</p>';
                  endif;
                  ?>
                </div>
                <!-- Ajouter les boutons de navigation -->
                <div class="swiper-button-next swiper-button-next-points-de-vente"></div>
                <div class="swiper-button-prev swiper-button-prev-points-de-vente"></div>
              </div>
            </div>

            <?php get_template_part('parts/contact-banner'); ?>

            <!-- Section Galerie -->
            <div class="gallery-container">
              <?php
              // Récupérer les images de la galerie
              $gallery_images = array();
              for ($i = 1; $i <= 10; $i++) {
                $image = get_field('image_gallery_' . $i);
                if ($image) {
                  $gallery_images[] = $image;
                }
              }

              if (!empty($gallery_images)) : ?>
                <h2>Galerie</h2>
                <div class="gallery">
                  <?php foreach ($gallery_images as $index => $image) : ?>
                    <div class="gallery-item">
                      <a href="<?php echo esc_url($image['url']); ?>" data-fslightbox>
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                      </a>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php else : ?>
                <p>Le champ ACF 'gallery_images' est vide ou introuvable.</p>
              <?php endif; ?>
            </div>




            <!-- <div class="bieres-container">
              <?php
              // La boucle pour afficher les bières
              $args = array(
                'post_type' => 'biere',
                'posts_per_page' => -1 // Afficher toutes les bières
              );

              $biere_query = new WP_Query($args);
              $animation_class = 'fade-right';

              if ($biere_query->have_posts()) :
                while ($biere_query->have_posts()) : $biere_query->the_post();
                  $animation_class = ($animation_class === 'fade-right') ? 'fade-left' : 'fade-right';

                  // Récupérer la valeur du champ beer_incrementer
                  $incrementer = get_field('beer_incrementer');
              ?>

                  <div class="biere-container" data-aos="<?php echo $animation_class; ?>">
                    <?php if (has_post_thumbnail()) : ?>
                      <div class="biere-thumbnail">
                        <?php the_post_thumbnail(); ?>
                      </div>
                    <?php endif; ?>

                    <?php
                    // Afficher les champs personnalisés
                    $description = get_field('description_biere');
                    $image = get_field('image_biere');

                    if ($image) : ?>
                      <div class="biere-image">
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                      </div>
                    <?php endif;

                    if ($description) : ?>
                      <div class="biere-description">
                        <p><?php echo esc_html($description); ?></p>
                        <?php
                        $biere_id = get_the_ID();
                        $details_url = home_url('/single-biere?biere_id=' . $biere_id);
                        ?>
                        <a href="<?php echo esc_url($details_url); ?>" class="button">Voir la fiche</a>
                      </div>
                    <?php endif; ?>

                  </div>

                <?php
                endwhile;
                wp_reset_postdata();
              else :
                ?>
                <p><?php _e('Aucune bière trouvée.', 'rocles'); ?></p>
              <?php
              endif;
              ?>
            </div> -->



            <div class="labels-container site-wrap">
              <div class="labels-container__title">
                <h2>Labels</h2>
              </div>
              <div class="label-container__pictos">
                <?php
                // Loop à travers les labels
                $j = 1;
                while (true) {
                  $label_field = 'label_' . $j;
                  $label = get_field($label_field);
                  if (!$label || !is_array($label)) {
                    break;
                  }

                  $label_image = isset($label['label_img']) ? $label['label_img'] : null;
                  $label_url = isset($label['label_url']) ? $label['label_url'] : null;

                  if ($label_image || $label_url) : ?>
                    <div class="label">
                      <?php if ($label_url && $label_image) : ?>
                        <a href="<?php echo esc_url($label_url); ?>" target="_blank">
                          <img src="<?php echo esc_url($label_image['url']); ?>" alt="<?php echo esc_attr($label_image['alt']); ?>">
                        </a>
                      <?php elseif ($label_image) : ?>
                        <img src="<?php echo esc_url($label_image['url']); ?>" alt="<?php echo esc_attr($label_image['alt']); ?>">
                      <?php endif; ?>
                    </div>
                <?php endif;

                  $j++;
                }
                ?>
              </div>
            </div>

          </div>
        </article>
      <?php
      endwhile;
    else :
      ?>
      <p><?php _e('No posts found.', 'rocles'); ?></p>
    <?php
    endif;
    ?>
  </main>
</div>

<?php get_template_part('parts/footer'); ?>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var heroSwiper = new Swiper('.hero-swiper', {
      loop: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      autoplay: {
        delay: 5000,
      },
    });
  });
  document.addEventListener('DOMContentLoaded', function() {
    new Swiper('.swiper-points-de-vente', {
      slidesPerView: 1,
      spaceBetween: 10,
      pagination: {
        el: '.swiper-pagination-points-de-vente',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next-points-de-vente',
        prevEl: '.swiper-button-prev-points-de-vente',
      },
      breakpoints: {
        640: {
          slidesPerView: 1,
          spaceBetween: 20,
        },
        768: {
          slidesPerView: 2,
          spaceBetween: 30,
        },
        1024: {
          slidesPerView: 3,
          spaceBetween: 40,
        },
      }
    });
  });
</script>
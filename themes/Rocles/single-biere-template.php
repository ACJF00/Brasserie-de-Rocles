<?php

/**
 * Template Name: Single Biere Template
 */

get_template_part('parts/header');
?>


<div class="content-area">
  <main class="site-main site-wrap">

    <?php
    // Récupérer le paramètre de l'URL
    $biere_id = isset($_GET['biere_id']) ? intval($_GET['biere_id']) : 0;

    // Débogage: Afficher l'ID de la bière récupérée
    echo '<!-- biere_id: ' . esc_html($biere_id) . ' -->';

    if ($biere_id) {
      // Récupérer les détails de la bière en fonction de l'ID
      $biere_query = new WP_Query(array(
        'post_type' => 'biere',
        'p' => $biere_id
      ));

      // Débogage: Afficher le nombre de posts trouvés
      echo '<!-- Found posts: ' . esc_html($biere_query->found_posts) . ' -->';

      if ($biere_query->have_posts()) :
        while ($biere_query->have_posts()) : $biere_query->the_post();
    ?>

          <article id="post-<?php the_ID(); ?>" <?php post_class('single-beer'); ?>>
            <header class="single-beer-header">
              <h1 class="single-beer-title"><?php the_title(); ?></h1>
            </header>
            <div class="single-beer-content">
              <?php
              if (has_post_thumbnail()) {
                the_post_thumbnail();
              }

              the_content();

              // Afficher les champs personnalisés
              $description = get_field('description_biere');
              $image = get_field('image_biere');
              $prix = get_field('prix_biere');
              $conditionnement = get_field('conditionnement');
              $recette = get_field('recette_biere');

              if ($description) {
                echo '<p class="single-beer-description">' . esc_html($description) . '</p>';
              }
              ?>
              <div class="single-beer-recipe">
                <?php
                if ($image) {
                  echo '<img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '">';
                }
                ?>
                <div class="single-beer-recipe__text">
                  <?php
                if ($recette) {
                  echo '<h2>Recette</h2>';
                  echo '<div>' . $recette . '</div>';
                }
                ?>
                </div>
              </div>

              <?php
              if ($prix) {
                echo '<p>Prix: ' . esc_html($prix) . '</p>';
              }

              if ($conditionnement) {
                echo '<p>Conditionnement: ' . esc_html($conditionnement) . '</p>';
              }
              ?>
            </div>

            <!-- Swiper imbriqué pour les points de vente -->
            <div class="points-de-vente">
              <h2>Points de Vente</h2>
              <div class="swiper-container swiper-nested">
                <div class="swiper-wrapper">
                  <?php
                  // Récupérer les points de vente associés à cette bière
                  $points_de_vente = get_field('points_de_vente');
                  if ($points_de_vente) :
                    foreach ($points_de_vente as $point) :
                      $ville = get_field('ville', $point->ID);
                      $adresse = get_field('adresse', $point->ID);
                      $site_web = get_field('site_web', $point->ID);
                      $logo = get_field('logo', $point->ID);

                      // Debugging
                      echo '<!-- Point de vente - Ville: ' . esc_html($ville) . ', Adresse: ' . esc_html($adresse) . ', Site Web: ' . esc_url($site_web) . ' -->';
                  ?>
                      <div class="swiper-slide">
                        <div class="point-de-vente-container">
                          <?php if ($logo) : ?>
                            <div class="point-de-vente-logo">
                              <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>">
                            </div>
                          <?php endif; ?>
                          <?php if ($site_web) : ?>
                            <a href="<?php echo esc_url($site_web); ?>" target="_blank">
                              <h3 class="point-de-vente-title"><?php echo esc_html($point->post_title); ?></h3>
                            </a>
                          <?php else : ?>
                            <h3 class="point-de-vente-title"><?php echo esc_html($point->post_title); ?></h3>
                          <?php endif; ?>

                          <?php if ($ville) : ?>
                            <h4 class="point-de-vente-ville"><?php echo esc_html($ville); ?></h4>
                          <?php endif; ?>

                          <?php if ($adresse) : ?>
                            <p class="point-de-vente-address"><?php echo esc_html($adresse); ?></p>
                          <?php endif; ?>
                        </div>
                      </div>

                  <?php
                    endforeach;
                  else :
                    echo '<p class="no-stores">Aucun point de vente associé.</p>';
                  endif;
                  ?>
                </div>
                <!-- Ajouter la pagination -->
                <div class="swiper-pagination swiper-pagination-nested"></div>
                <!-- Ajouter les boutons de navigation -->
                <div class="swiper-button-next swiper-button-next-nested"></div>
                <div class="swiper-button-prev swiper-button-prev-nested"></div>
              </div>
            </div>
            <!-- Fin du Swiper imbriqué -->

          </article>

    <?php
        endwhile;
        wp_reset_postdata();
      else :
        echo '<p>Aucune bière trouvée.</p>';
      endif;
    } else {
      echo '<p>ID de bière manquant ou invalide.</p>';
    }
    ?>

  </main>
</div>

<?php get_template_part('parts/footer'); ?>

<script>
  // Swiper imbriqué
  var nestedSwipers = document.querySelectorAll('.swiper-nested');
  nestedSwipers.forEach(function(swiperElement) {
    new Swiper(swiperElement, {
      nested: true,
      pagination: {
        el: swiperElement.querySelector('.swiper-pagination-nested'),
        clickable: true,
      },
      navigation: {
        nextEl: swiperElement.querySelector('.swiper-button-next-nested'),
        prevEl: swiperElement.querySelector('.swiper-button-prev-nested'),
      },
      slidesPerView: 3,
      spaceBetween: 10,
    });
  });
</script>
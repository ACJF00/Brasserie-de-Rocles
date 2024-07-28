<?php
/*
Template Name: Nos Recettes
*/
get_template_part('parts/header');
?>

<div class="content-area">
  <main class="site-main site-wrap recipes">
    <div class="swiper-container swiper-main">
      <div class="swiper-wrapper">
        <?php
        // La boucle pour afficher les bières
        $args = array(
          'post_type' => 'biere',
          'posts_per_page' => -1, // Afficher toutes les bières
          'orderby' => 'meta_value_num', // Assurez-vous de trier par beer_incrementer
          'meta_key' => 'beer_incrementer',
          'order' => 'ASC' // Ordre croissant
        );

        $biere_query = new WP_Query($args);

        if ($biere_query->have_posts()) :
          while ($biere_query->have_posts()) : $biere_query->the_post();
            // Récupérer la valeur du champ beer_incrementer
            $incrementer = get_field('beer_incrementer');
        ?>
            <div class="swiper-slide" id="slide-<?php echo esc_attr($incrementer); ?>">
              <div class="recette-container">
                <?php if (has_post_thumbnail()) : ?>
                  <div class="recette-container__thumbnail">
                    <?php the_post_thumbnail(); ?>
                  </div>
                <?php endif; ?>

                <h2 class="recette-container__title"><?php the_title(); ?></h2>

                <?php
                // Afficher les champs personnalisés
                $recette = get_field('recette_biere');
                $image = get_field('image_biere');

                if ($image || $recette) : ?>
                  <div class="recette-container__content">
                    <?php if ($image) : ?>
                      <div class="recette-container__image">
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                      </div>
                    <?php endif; ?>

                    <?php if ($recette) : ?>
                      <div class="recette-container__description">
                        <div><?php echo $recette; ?></div>
                      </div>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
                <!-- Swiper imbriqué pour les points de vente -->
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
                      echo '<p>Aucun point de vente associé.</p>';
                    endif;
                    ?>
                  </div>
                  <!-- Ajouter la pagination -->
                  <div class="swiper-pagination">
                  </div>
                </div>
                <!-- Fin du Swiper imbriqué -->
              </div>
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
      </div>



      <!-- Ajouter les boutons de navigation -->
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>



  </main>
</div>

<?php get_template_part('parts/footer'); ?>

<!-- Initialisation de Swiper -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    function getSlideFromURL() {
      var urlParams = new URLSearchParams(window.location.search);
      var slide = urlParams.get('slide');
      console.log('Slide parameter from URL:', slide); // Débogage
      return slide ? parseInt(slide) - 1 : 0; // Swiper index starts at 0
    }

    var initialSlideIndex = getSlideFromURL();
    console.log('Initial slide index:', initialSlideIndex); // Débogage

    var swiper = new Swiper('.swiper-main', {
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      initialSlide: initialSlideIndex
    });
  });
  document.addEventListener('DOMContentLoaded', function() {
    // Swiper imbriqué
    var nestedSwipers = document.querySelectorAll('.swiper-nested');
    nestedSwipers.forEach(function(swiperElement) {
      new Swiper(swiperElement, {
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },
        slidesPerView: 1,
        spaceBetween: 10,
        nested: true,
        loop: true
      });
    });
  });
</script>
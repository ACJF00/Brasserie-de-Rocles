<?php
/*
Template Name: Nos Recettes
*/
get_template_part('parts/header');
?>

<div class="content-area">
  <main class="site-main site-wrap recipes">
  <div class="swiper-container">
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
        // Log the incrementer for debugging
        echo '<!-- beer_incrementer: ' . esc_attr($incrementer) . ' -->';
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

    var swiper = new Swiper('.swiper-container', {
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
  // document.addEventListener('DOMContentLoaded', function() {
  //   var swiper = new Swiper('.swiper-container', {
  //     loop: true,
  //     navigation: {
  //       nextEl: '.swiper-button-next',
  //       prevEl: '.swiper-button-prev',
  //     }
  //   });
  // });
</script>
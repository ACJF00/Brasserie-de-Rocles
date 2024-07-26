<?php get_template_part('parts/header'); ?>

<div class="content-area">
  <div class="hero-section">
    <?php
    // Récupérer le groupe de champs ACF 'hero'
    $hero = get_field('hero');

    if ($hero) :
      $hero_img = $hero['hero_img'];
      $hero_title = $hero['hero_title'];
      $hero_txt = $hero['hero_txt'];
    ?>

      <div class="hero-content" style="background-image: url('<?php echo esc_url($hero_img['url']); ?>');">
        <div class="hero-overlay">
          <?php if ($hero_title) : ?>
            <h1 class="hero-title"><?php echo esc_html($hero_title); ?></h1>
          <?php endif; ?>

          <?php if ($hero_txt) : ?>
            <p class="hero-txt"><?php echo esc_html($hero_txt); ?></p>
          <?php endif; ?>
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
          <div class="entry-content site-wrap">
            <?php the_content(); ?>
            <div class="presentation-container">
              <h2>Présentation</h2>
              <div class="presentation-container__content">
                <?php
                // Récupérer le groupe de champs ACF 'presentation'
                $presentation = get_field('presentation');
                if ($presentation) :
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


            <div class="bieres-container">
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
                        <a href="<?php echo site_url('/nos-recettes?slide=' . esc_attr($incrementer)); ?>" class="button">Voir la recette</a>

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
            </div>



            <div class="labels-container">
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
<?php
/*
Template Name: La Brasserie
*/
get_template_part('parts/header');
?>


<div class="content-area">
  <main class="site-main">
    <?php
    if (have_posts()) :
      while (have_posts()) : the_post();
    ?>

        <header class="entry-header">
          <h2 class="entry-title"><?php the_title(); ?></h2>
        </header>
        <div class="who-container site-wrap">
          <?php the_content(); ?>
          <div class="who-container__text display-text">
            <?php
            // Débogage pour la page d'accueil
            $who_title = get_field('who_title_1');
            if ($who_title) : ?>
              <h3><?php echo esc_html($who_title); ?></h3>

              <?php

              $who_paragraphe_1 = get_field('who_paragraphe_1_1');
              $who_paragraphe_2 = get_field('who_paragraphe_2_1');
              $who_paragraphe_3 = get_field('who_paragraphe_3_1');

              // Afficher les paragraphes s'ils existent
              if ($who_paragraphe_1) : ?>
                <p><?php echo esc_html($who_paragraphe_1); ?></p>
              <?php endif; ?>

              <?php if ($who_paragraphe_2) : ?>
                <p><?php echo esc_html($who_paragraphe_2); ?></p>
              <?php endif; ?>

              <?php if ($who_paragraphe_3) : ?>
                <p><?php echo esc_html($who_paragraphe_3); ?></p>
              <?php endif; ?>
          </div>
          <?php
              // Récupérer l'image ACF
              $who_image_1 = get_field('who_image_1');

              // Afficher l'image si elle existe
              if ($who_image_1) : ?>
            <img src="<?php echo esc_url($who_image_1['url']); ?>" alt="<?php echo esc_attr($who_image_1['alt']); ?>">
          <?php endif; ?>

        <?php else : ?>
          <p>Le champ ACF 'who_title' est vide ou introuvable.</p>
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
        <div class="image-text site-wrap">
          <?php
          // Récupérer le champ texte 1
          $texte_1 = get_field('texte_1');
          if ($texte_1) : ?>
            <p><?php echo esc_html($texte_1); ?></p>
          <?php endif; ?>

          <?php
          // Récupérer le champ image 1
          $image_1 = get_field('image_1');
          if ($image_1) : ?>
            <img src="<?php echo esc_url($image_1['url']); ?>" alt="<?php echo esc_attr($image_1['alt']); ?>">
          <?php endif; ?>
        </div>
        
        <?php get_template_part('parts/contact-banner'); ?>

        <div class="text-image site-wrap">
          <?php
          // Récupérer le champ texte 1
          $texte_1 = get_field('img_text_text_1');
          if ($texte_1) : ?>
            <p><?php echo esc_html($texte_1); ?></p>
          <?php endif; ?>

          <?php
          // Récupérer le champ image 1
          $image_1 = get_field('img_text_img_1');
          if ($image_1) : ?>
            <img src="<?php echo esc_url($image_1['url']); ?>" alt="<?php echo esc_attr($image_1['alt']); ?>">
          <?php endif; ?>
        </div>
        <div class="image-text site-wrap">
          <?php
          // Récupérer le champ texte 2
          $texte_2 = get_field('texte_2');
          if ($texte_2) : ?>
            <p><?php echo esc_html($texte_2); ?></p>
          <?php endif; ?>

          <?php
          // Récupérer le champ image 2
          $image_2 = get_field('image_2');
          if ($image_2) : ?>
            <img src="<?php echo esc_url($image_2['url']); ?>" alt="<?php echo esc_attr($image_2['alt']); ?>">
          <?php endif; ?>
        </div>
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
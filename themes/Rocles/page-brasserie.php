<?php
/*
Template Name: La Brasserie
*/
get_template_part('parts/header'); 
?>


<div class="content-area">
  <main class="site-main site-wrap">
    <?php
    if (have_posts()) :
      while (have_posts()) : the_post();
    ?>

          <header class="entry-header">
            <h2 class="entry-title"><?php the_title(); ?></h2>
          </header>
          <div class="who-container">
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
          <div class="image-text">
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
            <div class="text-image">
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
            <div class="image-text">
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
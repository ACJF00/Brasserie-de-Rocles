<?php get_template_part('parts/header'); ?>

<div class="content-area">
  <main class="site-main">
    <?php
    // Récupérer les posts
    if (have_posts()) :
      while (have_posts()) : the_post();
    ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <header class="entry-header">
            <h2 class="entry-title"><?php the_title(); ?></h2>
          </header>
          <div class="entry-content">
            <?php the_content(); ?>

            <?php
            // Afficher le champ ACF pour la page d'accueil
            if (is_front_page()) :
              $who_title = get_field('who_title');
              if ($who_title) : ?>
                <h3><?php echo esc_html($who_title); ?></h3>
              <?php else : ?>
                <p>Le champ ACF 'who_title' est vide ou introuvable.</p>
              <?php endif; ?>
            <?php endif; ?>
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

<?php
get_template_part('parts/header');
?>

<div class="content-area">
    <main class="site-main">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p><?php _e('No posts found.', 'mon-theme'); ?></p>
        <?php endif; ?>
    </main>
</div>

<?php get_template_part('parts/footer'); ?>

<?php wp_footer(); ?>
</body>
</html>
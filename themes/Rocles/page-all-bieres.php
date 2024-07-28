<?php
/**
 * Template Name: All Bieres Template
 */
get_template_part('parts/header');
?>

<div class="content-area all-beers site-wrap">
    <main class="site-main all-beers-main">

        <?php
        // Récupérer tous les tags de bières
        $tags = get_terms(array(
            'taxonomy' => 'beer_tag',
            'hide_empty' => true,
        ));

        // Récupérer le tag filtré actuel
        $current_tag = get_query_var('beer_tag');
        
        if ($tags && !is_wp_error($tags)) {
            echo '<div class="all-beers-filters">';
            echo '<a href="' . esc_url(add_query_arg('beer_tag', '', home_url('/toutes-nos-bieres'))) . '" class="' . (empty($current_tag) ? 'active' : '') . '">Tous</a>'; // Lien pour tous les bières
            foreach ($tags as $tag) {
                $tag_link = add_query_arg('beer_tag', $tag->slug, home_url('/toutes-nos-bieres'));
                $active_class = ($current_tag === $tag->slug) ? 'active' : '';
                echo '<a href="' . esc_url($tag_link) . '" class="' . $active_class . '">' . esc_html($tag->name) . '</a>';
            }
            echo '</div>';
        }
        ?>

        <?php
        // Vérifier si un tag est filtré
        $tag_slug = get_query_var('beer_tag');

        // La boucle pour afficher toutes les bières
        $args = array(
            'post_type' => 'biere',
            'posts_per_page' => -1, // Afficher toutes les bières
            'orderby' => 'meta_value_num', // Assurez-vous de trier par beer_incrementer
            'meta_key' => 'beer_incrementer',
            'order' => 'ASC', // Ordre croissant
        );

        if ($tag_slug) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'beer_tag',
                    'field' => 'slug',
                    'terms' => $tag_slug,
                ),
            );
        }

        $biere_query = new WP_Query($args);

        if ($biere_query->have_posts()) :
            echo '<div class="all-beers-grid">';
            while ($biere_query->have_posts()) : $biere_query->the_post();
                // Récupérer l'ID et le titre de la bière
                $biere_id = get_the_ID();
                $biere_title = get_the_title();
                // URL de la page de détails de la bière
                $details_url = home_url('/single-biere?biere_id=' . $biere_id);
                ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class('all-beers-item'); ?>>
                    <a href="<?php echo esc_url($details_url); ?>" class="all-beers-link">
                        <header class="entry-header all-beers-header">
                            <h2 class="entry-title all-beers-title"><?php echo esc_html($biere_title); ?></h2>
                        </header>
                        <div class="entry-content all-beers-content">
                            <?php
                            if (has_post_thumbnail()) {
                                echo '<div class="all-beers-thumbnail">';
                                the_post_thumbnail();
                                echo '</div>';
                            }

                            // Afficher les champs personnalisés
                            $description = get_field('description_biere');
                            $image = get_field('image_biere');
                            $prix = get_field('prix_biere');
                            $conditionnement = get_field('conditionnement');

                            if ($description) {
                                echo '<p class="all-beers-description">' . esc_html($description) . '</p>';
                            }

                            if ($image) {
                                echo '<div class="all-beers-image"><img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '"></div>';
                            }

                            if ($prix) {
                                echo '<p class="all-beers-prix">Prix: ' . esc_html($prix) . '</p>';
                            }

                            if ($conditionnement) {
                                echo '<p class="all-beers-conditionnement">Conditionnement: ' . esc_html($conditionnement) . '</p>';
                            }

                            // Afficher les tags de bière
                            $tags = get_the_terms($biere_id, 'beer_tag');
                            if ($tags && !is_wp_error($tags)) {
                                echo '<div class="all-beers-tags">';
                                foreach ($tags as $tag) {
                                    echo '<span class="beer-tag">' . esc_html($tag->name) . '</span>';
                                }
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </a>
                </article>

                <?php
            endwhile;
            echo '</div>';
            wp_reset_postdata();
        else :
            echo '<p>Aucune bière trouvée.</p>';
        endif;
        ?>

    </main>
</div>

<?php get_template_part('parts/footer'); ?>

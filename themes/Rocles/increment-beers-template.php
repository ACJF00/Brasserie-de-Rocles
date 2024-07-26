<?php
/**
 * Template Name: Increment Beers Template
 */

get_header();

function increment_existing_beers() {
    // Arguments de la requête pour obtenir toutes les bières
    $args = array(
        'post_type' => 'biere',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'date', // Assurez-vous qu'elles sont ordonnées par date
        'order' => 'ASC', // Ordre croissant
    );

    $query = new WP_Query($args);
    $counter = 1; // Initialiser le compteur à 1

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();

            // Récupérer la valeur actuelle du champ beer_incrementer
            $incrementer = get_field('beer_incrementer', $post_id);

            // Si le champ beer_incrementer n'est pas défini, le définir
            if (!$incrementer) {
                update_field('beer_incrementer', $counter, $post_id);
                echo 'Post ID ' . $post_id . ' a été mis à jour avec l\'incrementer ' . $counter . '<br>';
                $counter++;
            }
        }
        wp_reset_postdata();
    }
}

// Exécuter la fonction pour incrémenter les bières existantes
increment_existing_beers();

echo 'Les bières ont été incrémentées avec succès.';

get_footer();
?>

<?php
// Assurez-vous que ce fichier est exécuté dans le contexte de WordPress
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function increment_existing_beers() {
    // Arguments de la requête pour obtenir toutes les bières
    $args = array(
        'post_type' => 'biere',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_key' => 'beer_incrementer',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
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
                $counter++;
            }
        }
        wp_reset_postdata();
    }
}

// Exécuter la fonction pour incrémenter les bières existantes
increment_existing_beers();

echo 'Les bières ont été incrémentées avec succès.';

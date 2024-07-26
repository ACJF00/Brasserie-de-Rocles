<?php
function rocles_enqueue_styles()
{
    wp_enqueue_style('style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'rocles_enqueue_styles');

function rocles_setup()
{
    // Enregistrer le menu de navigation
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'rocles'),
    ));

    // Ajouter le support pour le logo personnalisé
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'rocles_setup');

function rocles_enqueue_styles_scripts()
{
    // Enqueue main stylesheet
    wp_enqueue_style('style', get_template_directory_uri() . '/css/style.css');

    // Enqueue AOS styles and scripts via CDN
    wp_enqueue_style('aos-css', 'https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css');
    wp_enqueue_script('aos-js', 'https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js', array(), '2.3.4', true);

    // Enqueue custom script to initialize AOS
    wp_add_inline_script('aos-js', 'AOS.init();');
}
add_action('wp_enqueue_scripts', 'rocles_enqueue_styles_scripts');

// Enregistrer le Custom Post Type "Bières"
function register_biere_cpt()
{
    $labels = array(
        'name'               => 'Bières',
        'singular_name'      => 'Bière',
        'menu_name'          => 'Bières',
        'name_admin_bar'     => 'Bière',
        'add_new'            => 'Ajouter une nouvelle',
        'add_new_item'       => 'Ajouter une nouvelle bière',
        'new_item'           => 'Nouvelle bière',
        'edit_item'          => 'Modifier la bière',
        'view_item'          => 'Voir la bière',
        'all_items'          => 'Toutes les bières',
        'search_items'       => 'Rechercher des bières',
        'parent_item_colon'  => 'Bières parentes:',
        'not_found'          => 'Aucune bière trouvée.',
        'not_found_in_trash' => 'Aucune bière trouvée dans la corbeille.'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'biere'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 4,
        'supports'           => array('title', 'thumbnail'),
        'menu_icon'          => 'dashicons-beer'
    );

    register_post_type('biere', $args);
}

function register_point_de_vente_cpt()
{
    $labels = array(
        'name'               => 'Points de Vente',
        'singular_name'      => 'Point de Vente',
        'menu_name'          => 'Points de Vente',
        'name_admin_bar'     => 'Point de Vente',
        'add_new'            => 'Ajouter un nouveau',
        'add_new_item'       => 'Ajouter un nouveau point de vente',
        'new_item'           => 'Nouveau point de vente',
        'edit_item'          => 'Modifier le point de vente',
        'view_item'          => 'Voir le point de vente',
        'all_items'          => 'Tous les points de vente',
        'search_items'       => 'Rechercher des points de vente',
        'parent_item_colon'  => 'Points de vente parents:',
        'not_found'          => 'Aucun point de vente trouvé.',
        'not_found_in_trash' => 'Aucun point de vente trouvé dans la corbeille.'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'point-de-vente'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array('title', 'thumbnail'),
        'menu_icon'          => 'dashicons-store', // Choisissez une icône appropriée
    );

    register_post_type('point_de_vente', $args);
}
add_action('init', 'register_point_de_vente_cpt');

// Masquer les articles standard dans le menu d'administration

function remove_default_post_type_menu() {
    remove_menu_page('edit.php'); // Masque le menu "Articles"
    remove_menu_page('edit-comments.php'); // Masque le menu "Commentaires"
}

add_action('admin_menu', 'remove_default_post_type_menu');

add_action('init', 'register_biere_cpt');

function enqueue_custom_fonts() {
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap', false);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_fonts');

function make_beer_incrementer_readonly() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            // Cibler le champ incrémenteur par son nom
            var incrementerField = $('input[name="acf[field_66a3a755cedf8]"]');
            incrementerField.prop('readonly', true);
        });
    </script>
    <?php
}
add_action('acf/input/admin_footer', 'make_beer_incrementer_readonly');

function set_beer_incrementer($post_id) {
    // On s'assure que ce n'est pas une révision.
    if (wp_is_post_revision($post_id)) {
        return;
    }

    // On s'assure que c'est bien un type de post 'biere'.
    if (get_post_type($post_id) != 'biere') {
        return;
    }

    // Récupérer la valeur actuelle du champ beer_incrementer.
    $incrementer = get_field('beer_incrementer', $post_id);

    // Si le champ beer_incrementer n'est pas déjà défini, le définir.
    if (!$incrementer) {
        // Récupérer le dernier numéro incrémenté parmi toutes les bières.
        $args = array(
            'post_type' => 'biere',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'meta_key' => 'beer_incrementer',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
        );

        $query = new WP_Query($args);
        $last_incrementer = 0;
        if ($query->have_posts()) {
            $query->the_post();
            $last_incrementer = get_field('beer_incrementer');
        }
        wp_reset_postdata();

        // Définir le nouveau champ incrémenteur.
        $new_incrementer = $last_incrementer + 1;
        update_field('beer_incrementer', $new_incrementer, $post_id);
    }
}
add_action('save_post', 'set_beer_incrementer');
<?php

// Gutenberg est le nouvelle éditeur de contenu propre à wordPress
// il ne nous intérresse pas pour l'utilisation du thème que
// nous allons créer. On va le désactiver :

// Disable Gutenberg on the back end.
add_filter( 'use_block_editor_for_post', '__return_false' ); // une chaîne de caractère qui existe dans wordPress

// Disable Gutenberg for widgets.
add_filter( 'use_widgets_block_editor', '__return_false' );
// Disable default front-end styles.

add_action( 'wp_enqueue_scripts', function() {
    // Remove CSS on the front end.
    wp_dequeue_style( 'wp-block-library' );
    // Remove Gutenberg theme.
    wp_dequeue_style( 'wp-block-library-theme' );
    // Remove inline global CSS on the front end.
    wp_dequeue_style( 'global-styles' );
}, 20 );


// Activer l'utilisation des vignettes (images de couverture) sur nos post_type
add_theme_support( 'post-thumbnails', ['recipe', 'travel']);


// Enregistrer de nouveau type de contenu qui seront stockés dans la table "wp_posts",
// avec un identifint spécifique dans la colonne "post_type"

register_post_type('recipe', [
    'label' => 'Recettes',
    'description' => 'Les recettes liées à nos voyages',
    'menu_position' => 6,
    'menu_icon' => 'dashicons-carrot',
    'public' => true,
    'has_archive' => true,
    'rewrite' => [
        'slug' => 'recettes'
    ],
    'supports' => ['title', 'excerpt', 'editor', 'thumbnail'],
]);

register_post_type('travel', [
    'label' => 'Voyages',
    'description' => 'Les voyages que nous avons réalisés',
    'menu_position' => 5,
    'menu_icon' => 'dashicons-airplane',
    'public' => true,
    'has_archive' => true,
    'rewrite' => [
        'slug' => 'voyages'
    ],
    'supports' => ['title', 'excerpt', 'editor', 'thumbnail'],
]);

// Ajouter des "catégories" (taxonomies) sur ces post_types:

register_taxonomy('course', ['recipe'], [
    'labels' => [
        'name' => 'Services',
        'singular_name' => 'Service',
    ],
    'description' => 'A quel moment du repas ce plat intervient-il ?',
    'public' => true,
    'hierarchical' => true,
    'show_tagcloud' => false,
]);

register_taxonomy('diet', ['recipe'], [
    'labels' => [
        'name' => 'Régimes alimentaires',
        'singular_name' => 'Régime',
    ],
    'description' => 'A quel type de régime appartient cette recette ?',
    'public' => true,
    'hierarchical' => true,
    'show_tagcloud' => false,
]);

// Paramétrer des tailles d'images pour le générateur de thumbnails de Wordpress :

// Sans recadrage :
add_image_size('travel-side', 420, 420);
// Avec recadrage :
add_image_size('travel-header', 1920, 400, true);


register_nav_menu( 'header', 'Le menu de navigation principale du haut de la page' );
register_nav_menu( 'footer', 'Le menu de navigation principale du bas de la page' );



//Créer une nouvelle fonction qui permet de retourner un menu de navigation formaté en un tableau d'objets afin de pouvoir l'afficher à notre guise dans le template

function dw_get_navigation_links(string $location): array
{
    //Récupérer l'objet WP pour le menu à la location $location
    $locations = get_nav_menu_locations();

    if (! isset($locations[$location])) {
        return [];
    }

    $nav_id = $locations[$location];
    $nav = wp_get_nav_menu_items($nav_id);


    // Transformer le menu en un tableau de liens, chaque lien étant un objet personnalisé

    $links = [];

    foreach ($nav as $post) {
        $link = new stdClass();
        $link->href = $post->url;
        $link->label = $post->title;
        $link->icone = get_field('icon', $post);



        /*$links[] = $link; même chose mais en plus court*/
        array_push($links, $link);
    }


    //Retourner ce tableau d'objets (liens).

    return $links;

}
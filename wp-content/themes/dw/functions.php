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



// Enregistrer de nouveau type de contenu qui seront stockés dans la table "wp_posts",
// avec un identifint spécifique dans la colonne "post_type"

register_post_type('recipe', [
    'label' => 'Recettes',
    'description' => 'Les recettes liées à nos voyages',
    'menu_position' => 6,
    'menu_icon' => 'dashicons-carrot',
    'public' => true,
    'rewrite' => [
        'slug' => 'recettes'
    ],
]);
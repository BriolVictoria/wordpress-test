<?php
// Charger les champs ACF exportés :
include_once('fields.php');

// Vérifier si la session est active ("started") ?
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function hepl_trad_load_textdomain(): void
{
    load_theme_textdomain('hepl-trad', get_template_directory() . '/locales');
}

add_action('after_setup_theme', 'hepl_trad_load_textdomain');

function __hepl(string $translation, array $replacements = [])
{
// 1. Récupérer la traduction de la phrase présente dans $translation
    $base = __($translation, 'hepl-trad');

// 2. Remplacer toutes les occurrences des variables par leur valeur
    foreach ($replacements as $key => $value) {
        $variable = ':' . $key;
        $base = str_replace($variable, $value, $base);
    }

// 3. Retourner la traduction complète.
    return $base;
}

/**
 * Récupère la valeur d'un champ ACF d'une page d'option pour la langue courante.
 *
 * Cette fonction utilise Advanced Custom Fields PRO (ACF) et Polylang
 * pour récupérer la valeur d'un champ d'option spécifique en fonction
 * de la langue active sur le site.
 *
 * @param string $field Le nom du champ ACF à récupérer.
 * @return mixed La valeur du champ, ou `false` si le champ n'existe pas.
 *
 *
 */
function get__option($field): mixed
{
    return get_field($field, pll_current_language('slug'));
}


$manifestPath = get_theme_file_path('public/.vite/manifest.json');

if (file_exists($manifestPath)) {
    $manifest = json_decode(file_get_contents($manifestPath), true);
    if (isset($manifest['wp-content/themes/dw/ressources/css/styles.scss'])) {
        wp_enqueue_style('dw', get_theme_file_uri('public/' . $manifest['wp-content/themes/dw/ressources/css/styles.scss']['file']));
    }

    if (isset($manifest['wp-content/themes/dw/ressources/js/scripts.js'])) {
        wp_enqueue_script('dw', get_theme_file_uri('public/' . $manifest['wp-content/themes/dw/ressources/js/scripts.js']['file'],[], true));
    }
}

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'wp_print_comments');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'classic-theme-styles-inline-css');

// Gutenberg est le nouvelle éditeur de contenu propre à wordPress
// il ne nous intérresse pas pour l'utilisation du thème que
// nous allons créer. On va le désactiver :

// Disable Gutenberg on the back end.
add_filter('use_block_editor_for_post', '__return_false'); // une chaîne de caractère qui existe dans wordPress

// Disable Gutenberg for widgets.
add_filter('use_widgets_block_editor', '__return_false');
// Disable default front-end styles.

add_action('wp_enqueue_scripts', function () {
    // Remove CSS on the front end.
    wp_dequeue_style('wp-block-library');
    // Remove Gutenberg theme.
    wp_dequeue_style('wp-block-library-theme');
    // Remove inline global CSS on the front end.
    wp_dequeue_style('global-styles');
}, 20);


// Activer l'utilisation des vignettes (images de couverture) sur nos post_type
add_theme_support('post-thumbnails', ['recipe', 'travel']);


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


register_nav_menu('header', 'Le menu de navigation principale du haut de la page');
register_nav_menu('footer', 'Le menu de navigation principale du bas de la page');



//Créer une nouvelle fonction qui permet de retourner un menu de navigation formaté en un tableau d'objets afin de pouvoir l'afficher à notre guise dans le template

function dw_get_navigation_links(string $location): array
{
    //Récupérer l'objet WP pour le menu à la location $location
    $locations = get_nav_menu_locations();

    if (!isset($locations[$location])) {
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

register_post_type('contact_message', [
    'label' => 'Messages de contact',
    'description' => 'Les envois de formulaire via la page de contact',
    'menu_position' => 10,
    'menu_icon' => 'dashicons-email',
    'public' => false,
    'show_ui' => true,
    'has_archive' => false,
    'supports' => ['title','editor'],
]);

register_post_type('recipe_message', [
    'label' => 'Messages de recipe',
    'description' => 'Les envois de formulaire via la page de recipe',
    'menu_position' => 10,
    'menu_icon' => 'dashicons-email',
    'public' => false,
    'show_ui' => true,
    'has_archive' => false,
    'supports' => ['title','editor'],
]);

// Créer une fonction qui permet de créer des pages d'options ACF pour le thème :
function create_site_options_page():void

{

    if(function_exists('acf_add_options_page')){

//Pageprincipale

        acf_add_options_page([

            'page_title'=>'SiteOptions',

            'menu_title'=>'SiteSettings',

            'menu_slug'=>'site-options',

            'capability'=>'edit_posts',

            'redirect'=>false

        ]);



        foreach(['fr','en']as$lang){

            acf_add_options_sub_page([

                'page_title'=>sprintf(__('Optionsdusite%s','hepl-trad'),strtoupper($lang)),

                'menu_title'=>sprintf(__('Optionsdusite%s','hepl-trad'),strtoupper($lang)),

                'menu_slug'=>'site-options-'.$lang,

                'post_id'=>$lang,

                'parent'=>'site-options',

            ]);

        }

    }

}



add_action('acf/init', 'create_site_options_page');

// Ajouter un post pour un formulaire de contact personnalisé

add_action('admin_post_dw_submit_contact_form', 'dw_handle_contact_form');
add_action('admin_post_nopriv_dw_submit_contact_form', 'dw_handle_contact_form');
// Chargement de notre classe qui va gérer ce formulaire

require_once(__DIR__ . '/forms/ContactForm.php');


function dw_handle_contact_form()
{
    $form = (new \DW_Theme\Forms\ContactForm())
        ->rule('firstname', 'required')
        ->rule('lastname', 'required')
        ->rule('email', 'required')
        ->rule('email', 'email')
        ->rule('message', 'required')
        ->rule('message', 'no_test')
        ->sanitize('firstname', 'sanitize_text_field')
        ->sanitize('lastname', 'sanitize_text_field')
        ->sanitize('email', 'sanitize_text_field')
        ->sanitize('message', 'sanitize_textarea_field');

    return $form->handle($_POST);
}


require_once(__DIR__ . '/forms/RecipeForm.php');
function dw_handle_recipe_form()
{
    $form = (new \DW_Theme\Forms\RecipeForm())
        ->rule('firstname', 'required')
        ->rule('lastname', 'required')
        ->rule('email', 'required')
        ->rule('email', 'email')
        ->rule('message', 'required')
        ->rule('message', 'no_test')
        ->sanitize('firstname', 'sanitize_text_field')
        ->sanitize('lastname', 'sanitize_text_field')
        ->sanitize('email', 'sanitize_text_field')
        ->sanitize('message', 'sanitize_textarea_field');

    return $form->handle($_POST);
}

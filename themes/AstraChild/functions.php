<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

/**
 * Permet de charger le CSS du fichier thème.css 
 */
 
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/css/theme.css', array(), filemtime(get_stylesheet_directory() . '/css/theme.css'));
}

// Fonction pour ajouter un lien "Admin" dans le menu pour les utilisateurs connectés

add_filter( 'wp_nav_menu_items', 'prefix_add_menu_item', 10, 2 );

function prefix_add_menu_item( $items, $args ) {
    if ( ! is_user_logged_in() ) {
        return $items;
    }

    // Trouver la position de la deuxième balise <li>
    $second_li_position = strpos( $items, '<li', strpos( $items, '<li' ) + 1 );

    // Si aucune deuxième balise <li> n'est trouvée, retourner les éléments tels quels
    if ( $second_li_position === false ) {
        return $items;
    }

    // Insérer le lien 'Admin' après la deuxième balise <li>
    $admin_link = '<li class="menu-item"><a class="menu-admin" href="' . esc_url( admin_url() ) . '">Admin</a></li>';
    $items = substr( $items, 0, $second_li_position ) . $admin_link . substr( $items, $second_li_position );

    return $items;
}

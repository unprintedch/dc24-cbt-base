<?php
require_once get_template_directory() . '/functions/dc24-functions.php';


require_once get_template_directory() . '/functions/dc24-enqueue.php';
// register acf block (automatique si le fichier est dans le dossier blocks)
require_once get_template_directory() . '/functions/dc24-block-register.php';
//regsieter block styles
require_once get_template_directory() . '/functions/dc24-block-styles.php';
// Quand on sauve un post, cela check les classes tailwind et les ajoute au safelist
require_once get_template_directory() . '/functions/dc24-safelist-update.php';
// Observe les couleurs et les styles des heading pour les copier dans tailwind
require_once get_template_directory() . '/functions/dc24-theme-styles.php';

// Plugin specific functions - Chargement conditionnel
if ( class_exists( 'ACF' ) ) {
    require_once get_template_directory() . '/functions/dc24-acf.php';
}

if ( class_exists( 'FacetWP' ) ) {
    require_once get_template_directory() . '/functions/dc24-facet.php';
}

if ( class_exists( 'GFCommon' ) ) {
    require_once get_template_directory() . '/functions/dc24-gravityform.php';
}

if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
    require_once get_template_directory() . '/functions/dc24-wpml.php';
}

// Si on utilise le menu "hybride"
require_once get_template_directory() . '/functions/dc24-menu-walker.php';



function register_theme_menus()
{
  register_nav_menus(array(
    'primary' => __('Primary Menu'),
    'offcanvas' => __('Offcanvas Menu'),
    'footer' => __('Footer Menu'),
  ));
}
add_action('init', 'register_theme_menus');



// function my_acf_init() {
    
//   acf_update_setting('google_api_key', '');
// }

// add_action('acf/init', 'my_acf_init');

// Contrôle de l'édition FSE selon l'environnement
function dc24_control_fse_editing() {
    // Désactiver l'édition FSE en production pour les utilisateurs non-administrateurs
    if ( ! wp_doing_ajax() && ! is_admin() && ! current_user_can( 'administrator' ) ) {
        // Vous pouvez ajouter une logique ici pour désactiver certaines fonctionnalités FSE
        // Par exemple, masquer le bouton "Modifier le site" pour les utilisateurs non-admin
    }
}
add_action( 'init', 'dc24_control_fse_editing' );



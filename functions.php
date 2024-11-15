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


//Plugin specific functions
// require_once get_template_directory() . '/functions/dc24-acf.php';
// require_once get_template_directory() . '/functions/dc24-facet.php';
// require_once get_template_directory() . '/functions/dc24-gravityform.php';
// require_once get_template_directory() . '/functions/dc24-acf.php';

// Au cas ou on a besoin de WPML
// require_once get_template_directory() . '/functions/dc24-wpml.php';
// Si on utilise le menu "hybride"
// require_once get_template_directory() . '/functions/dc24-menu-walker.php';



function register_theme_menus()
{
  register_nav_menus(array(
    'primary' => __('Primary Menu'),
    'footer' => __('Footer Menu'),
  ));
}
add_action('init', 'register_theme_menus');



// function my_acf_init() {
    
//   acf_update_setting('google_api_key', '');
// }

// add_action('acf/init', 'my_acf_init');



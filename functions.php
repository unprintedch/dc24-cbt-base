

<?php
// require_once get_template_directory() . '/block-variation/dc24-register-block-variation.php';
require_once get_template_directory() . '/functions/dc24-functions.php';
require_once get_template_directory() . '/functions/dc24-block-register.php';
require_once get_template_directory() . '/functions/dc24-enqueue.php';
require_once get_template_directory() . '/functions/dc24-block-styles.php';
require_once get_template_directory() . '/functions/dc24-theme-styles.php';
require_once get_template_directory() . '/functions/dc24-menu-walker.php';
require_once get_template_directory() . '/functions/dc24-facet.php';
require_once get_template_directory() . '/functions/dc24-gravityform.php';
require_once get_template_directory() . '/functions/dc24-acf.php';
require_once get_template_directory() . '/functions/dc24-safelist-update.php';
// require_once get_template_directory() . '/functions/dc24-wpml.php';




function register_theme_menus()
{
  register_nav_menus(array(
    'primary' => __('Primary Menu'),
    'footer' => __('Footer Menu'),
  ));
}
add_action('init', 'register_theme_menus');



function my_acf_init() {
    
  acf_update_setting('google_api_key', 'AIzaSyDT2r_nPHuX3M2Wdstpt0g3DajsyGFIZrw');
}

add_action('acf/init', 'my_acf_init');


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
require_once get_template_directory() . '/functions/dc24-calendar.php';
require_once get_template_directory() . '/functions/dc24-menu-formation.php';
// require_once get_template_directory() . '/functions/dc24-wpml.php';

add_filter('aos_init', function ($aos_init) {
  return '
  var aoswp_params = {
      "offset":"100",
      "duration":"200",
      "easing":"ease-in-out",
      "delay":"200",
      "once": false
      };
  ';
});


function register_theme_menus()
{
  register_nav_menus(array(
    'primary' => __('Primary Menu'),
    'footer' => __('Footer Menu'),
  ));
}
add_action('init', 'register_theme_menus');


function add_sticky_header_body_class($classes) {
  if (is_page()) {
      // Check if the ACF field 'sticky_header' is enabled for the current page
      if (get_field('sticky_header')) {
          $classes[] = 'has-sticky-header';
      }
  }
  return $classes;
}
add_filter('body_class', 'add_sticky_header_body_class');


function my_acf_init() {
    
  acf_update_setting('google_api_key', 'AIzaSyDT2r_nPHuX3M2Wdstpt0g3DajsyGFIZrw');
}

add_action('acf/init', 'my_acf_init');
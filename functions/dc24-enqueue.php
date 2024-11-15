<?php
add_action('wp_enqueue_scripts', 'dc24_enqueue_styles');
function dc24_enqueue_styles()
{
  
  wp_enqueue_style('front-styles', get_template_directory_uri() . '/build/style.css');
  wp_enqueue_script('front-scripts', get_template_directory_uri() . '/build/app.js', array('jquery'), null, true);
  wp_localize_script('front-scripts', 'ajax_object', array(
    'ajax_url' => admin_url('admin-ajax.php'),
  ));

}

function dc24_enqueue_block_assets() {
  // Enqueue the editor stylesheet.
  wp_enqueue_style(
    'dc24_enqueue_block_editor_styles',
    get_theme_file_uri('/build/style.css'),
    array(),
    wp_get_theme()->get('Version')
  );
}
add_action('enqueue_block_assets', 'dc24_enqueue_block_assets');




// function enqueue_slider_block_assets()
// {
//   global $post;
//   if (has_block('dc24/slider', $post) || has_block('dc24/slider-items', $post) || has_block('dc24/slider-video', $post)) {
//     // Enqueue Swiper CSS
//     // wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper/swiper-bundle.min.css');

//     // Enqueue Swiper JS
//     // wp_enqueue_script('swiper-js', 'https://unpkg.com/swiper/swiper-bundle.min.js', array(), null, true);
//   }
// }
// add_action('wp_enqueue_scripts', 'enqueue_slider_block_assets');

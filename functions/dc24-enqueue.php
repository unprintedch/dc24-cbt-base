<?php
add_action('wp_enqueue_scripts', 'dc24_enqueue_styles');
function dc24_enqueue_styles()
{
  
  wp_enqueue_style(
    'monotype-fonts',
    'https://cdn.fonts.net/kit/d9e95a14-3f4f-4569-ac9a-fda1668b7e2f/d9e95a14-3f4f-4569-ac9a-fda1668b7e2f.css',
    array(),
    null
  );
  
  // Add preconnect link for optimization
  add_action('wp_head', function() {
    echo '<link rel="preconnect" href="https://cdn.fonts.net">';
  });
  
  wp_enqueue_style('front-styles', get_template_directory_uri() . '/build/style.css');
  wp_enqueue_script('front-scripts', get_template_directory_uri() . '/build/app.js', array('jquery'), null, true);
  wp_localize_script('front-scripts', 'ajax_object', array(
    'ajax_url' => admin_url('admin-ajax.php')
  ));

}

function dc24_enqueue_block_assets() {
  // Enqueue the editor stylesheet.
  wp_enqueue_style(
      'dc24-editor-styles',                 // Handle for the stylesheet.
      get_theme_file_uri('/build/style.css'), // Path to the stylesheet file.
      array(),                                      // Define dependencies.
      wp_get_theme()->get('Version')                // Version number for cache busting.
  );
}
add_action('enqueue_block_assets', 'dc24_enqueue_block_assets');


function mytheme_enqueue_block_editor_fonts() {
  wp_enqueue_style(
      'monotype-fonts-editor',
      'https://cdn.fonts.net/kit/d9e95a14-3f4f-4569-ac9a-fda1668b7e2f/d9e95a14-3f4f-4569-ac9a-fda1668b7e2f.css',
      array(),
      null
  );
  add_action('enqueue_block_editor_assets', function() {
      echo '<link rel="preconnect" href="https://cdn.fonts.net">';
      echo '<link href="https://cdn.fonts.net/kit/d9e95a14-3f4f-4569-ac9a-fda1668b7e2f/d9e95a14-3f4f-4569-ac9a-fda1668b7e2f.css" rel="stylesheet">';
  });
}
add_action('enqueue_block_assets', 'mytheme_enqueue_block_editor_fonts');

// function enqueue_slider_block_assets()
// {
//   global $post;

//   if (has_block('dc24/slider', $post) || has_block('dc24/slider-items', $post) || has_block('dc24/slider-video', $post)) {
//     // Enqueue Swiper CSS
//     // wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper/swiper-bundle.min.css');
//     // wp_enqueue_style('swiper-css', get_theme_file_uri("/package-local/package/swiper-bundle.min.css"));

//     // Enqueue Swiper JS
//     // wp_enqueue_script('swiper-js', 'https://unpkg.com/swiper/swiper-bundle.min.js', array(), null, true);
//     // wp_enqueue_script('swiper-js', get_theme_file_uri("/package-local/package/swiper-bundle.min.js"), array(), null, true);
//   }
// }
// add_action('wp_enqueue_scripts', 'enqueue_slider_block_assets');

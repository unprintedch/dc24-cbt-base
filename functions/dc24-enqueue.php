<?php
add_action('wp_enqueue_scripts', 'dc24_enqueue_styles');
function dc24_enqueue_styles()
{
  // Utiliser le versioning automatique pour le cache busting
  $style_version = function_exists( 'dc24_get_asset_version' ) ? dc24_get_asset_version( 'build/style.css' ) : '1.0.0';
  $script_version = function_exists( 'dc24_get_asset_version' ) ? dc24_get_asset_version( 'build/app.js' ) : '1.0.0';
  
  wp_enqueue_style('front-styles', get_template_directory_uri() . '/build/style.css', array(), $style_version);
  
  wp_enqueue_script('front-scripts', get_template_directory_uri() . '/build/app.js', array('jquery'), $script_version, true);
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

// Chargement conditionnel des assets pour les blocs spécifiques
function dc24_enqueue_conditional_block_assets() {
  global $post;
  
  // Vérifier si on est sur une page avec du contenu
  if ( ! $post || ! is_object( $post ) ) {
    return;
  }
  
  $content = $post->post_content;
  
  // Charger Swiper seulement si des blocs slider sont présents
  if ( has_block( 'dc24/slider', $post ) || 
       has_block( 'dc24/slider-items', $post ) || 
       has_block( 'dc24/slider-video', $post ) ||
       strpos( $content, 'dc24/slider' ) !== false ) {
    
    wp_enqueue_style( 'swiper-css', get_template_directory_uri() . '/node_modules/swiper/swiper-bundle.min.css' );
    wp_enqueue_script( 'swiper-js', get_template_directory_uri() . '/node_modules/swiper/swiper-bundle.min.js', array(), null, true );
  }
  
  // Ajouter d'autres conditions pour d'autres blocs si nécessaire
  // if ( has_block( 'dc24/maps', $post ) ) {
  //   wp_enqueue_script( 'maps-js', 'https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY', array(), null, true );
  // }
}
add_action('wp_enqueue_scripts', 'dc24_enqueue_conditional_block_assets');

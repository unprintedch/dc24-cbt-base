

<?php
// require_once get_template_directory() . '/block-variation/dc24-register-block-variation.php';
require_once get_template_directory() . '/functions/dc24-block-register.php';
require_once get_template_directory() . '/functions/dc24-block-styles.php';
require_once get_template_directory() . '/functions/dc24-theme-styles.php';
?>

<?php
add_action( 'wp_enqueue_scripts', 'dc24_enqueue_styles' );
function dc24_enqueue_styles()
{
  wp_enqueue_style('front-styles', get_template_directory_uri() . '/build/style.css');
}

add_action('enqueue_block_editor_assets', 'dc24_enqueue_block_editor_styles');
function dc24_enqueue_block_editor_styles()
{
  // Enqueue the editor stylesheet.
  wp_enqueue_style(
    'dc24_enqueue_block_editor_styles',                 // Handle for the stylesheet.
    get_theme_file_uri('/build/editor.css'), // Path to the stylesheet file.
    array(),                                      // Define dependencies.
    wp_get_theme()->get('Version')                // Version number for cache busting.
  );
}

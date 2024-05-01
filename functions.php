

<?php
require_once get_template_directory() . '/block-variation/dc24-register-block-variation.php';
?>

<?php 
add_action( 'wp_enqueue_scripts', 'dc24_enqueue_styles' );
  function dc24_enqueue_styles() {
    wp_enqueue_style( 'styles', get_template_directory_uri() . '/style.css' );
}
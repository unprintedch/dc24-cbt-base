<?php

/**
 * Adds option 'li_class' to 'wp_nav_menu'.
 *
 * @param string  $classes String of classes.
 * @param mixed   $item The curren item.
 * @param WP_Term $args Holds the nav menu arguments.
 *
 * @return array
 */
function dc24_nav_menu_add_li_class( $classes, $item, $args, $depth ) {
	if ( isset( $args->li_class ) ) {
		$classes[] = $args->li_class;
	}

	if ( isset( $args->{"li_class_".$depth} ) ) {
		$classes[] = $args->{"li_class_".$depth};
	}

	return $classes;
}

add_filter( 'nav_menu_css_class', 'dc24_nav_menu_add_li_class', 10, 4 );

/**
 * Adds option 'submenu_class' to 'wp_nav_menu'.
 *
 * @param string  $classes String of classes.
 * @param mixed   $item The curren item.
 * @param WP_Term $args Holds the nav menu arguments.
 *
 * @return array
 */
function dc24_nav_menu_add_submenu_class( $classes, $args, $depth ) {
	if ( isset( $args->submenu_class ) ) {
		$classes[] = $args->submenu_class;
	}

	if ( isset( $args->{"submenu_class_".$depth} ) ) {
		$classes[] = $args->{"submenu_class_".$depth};
	}

	return $classes;
}

add_filter( 'nav_menu_submenu_css_class', 'dc24_nav_menu_add_submenu_class', 10, 3 );





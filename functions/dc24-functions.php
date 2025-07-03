<?php

    // Here comes the general helper functione

/**
 * Ajouter la classe front-end-only au body pour isoler certains styles
 */
function dc24_add_frontend_class($classes) {
    if (!is_admin()) {
        $classes[] = 'front-end-only';
    }
    return $classes;
}
add_filter('body_class', 'dc24_add_frontend_class');

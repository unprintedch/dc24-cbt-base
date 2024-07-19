<?php 
add_filter('wpml_permalink', 'preserve_query_string', 10, 2);

function preserve_query_string($url, $lang) {
    if (!is_admin() && !empty($_SERVER['QUERY_STRING'])) {
        $url .= '?' . $_SERVER['QUERY_STRING'];
    }
    return $url;
}
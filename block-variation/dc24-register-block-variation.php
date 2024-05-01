<?php

add_filter('get_block_type_variations', 'dc24_block_type_variations', 10, 2);

function dc24_block_type_variations($variations, $block_type)
{
    if ('core/navigation' === $block_type->name) {
        $variations[] = array(
            'name'       => 'dc24-navigation',
            'title'      => __('Navigation alternative', 'dc24'),
            'scope'     => array('block', 'transform'),
        );
    }
    return $variations;
}

<?php

/**
 * Text Block template.
 *
 * @param array $block The block settings and attributes.
 */

// Support custom "anchor" values.
$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = '';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}
$is_admin = is_admin();
$post_id = get_the_ID();
$parent_id = wp_get_post_parent_id($post_id);

?>

<?php if ($is_admin) : ?>
    <div class="admin-view-only flex items-center justify-center bg-slate-200 p-12 hover:bg-slate-300 transition-all">
        <!-- Content to be shown only in admin -->
        <h2>Header and navigation for formation pages.</h2>
    </div>
<?php
    return;
endif; ?>

<div class="z-0 relative mt-0 h-[520px] overflow-hidden bg-cover flex items-end justify-center after:content-[''] after:absolute after:w-full after:h-full after:top-0 after:left-0 after:bg-black after:bg-opacity-30 after:z-10;" style="background-image: url('<?php echo get_the_post_thumbnail_url(null, 'full'); ?>');">    
    <div class="relative z-20 pb-3">
        <?php
        $top_menu_items = dc24_get_top_navigation_formations($parent_id, $post_id);
        echo $top_menu_items;
        ?>
    </div>
</div>
<div class="flex justify-center">
    <?php
   
    $sub_menu_items = dc24_get_sub_navigation_formations($parent_id, $post_id);
    echo $sub_menu_items;

    ?>
</div>
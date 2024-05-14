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



?>

<div <?php echo esc_attr($anchor); ?>class="<?php echo esc_attr($class_name); ?>">
    <?php if ($is_admin) : ?>
        <div class="admin-view-only flex items-center justify-center bg-slate-200 p-12 hover:bg-slate-300 transition-all">
            <!-- Content to be shown only in admin -->
            <h2>Slider hero content.</h2>
            
        </div>
    <?php
        return;
    endif; ?>

    <div class="flex justify-between px-6">
        <div class="top-0 right-0 flex gap-4 items-center ">
            <!-- <div class="dc23-slick-prev text-black "><i class="fa-regular fa-arrow-left-long"></i></div> -->
            <div class="dc23-slick-next text-black  "><i class="fa-regular fa-arrow-right-long"></i></div>
        </div>
    </div>
    <div class="">
        <div class="flex slider-post gap-12">
            <div> Slide </div>
            <div> Slide </div>
            <div> Slide </div>
            <div> Slide </div>
        </div>
    </div>

</div>
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

add_filter('body_class', function ($classes) {
    return array_merge($classes, array('has-sticky-hero'));
});


$title = get_field("title", $block['id']);
$subtitle = get_field("subtitle", $block['id']);
$link = get_field("link", $block['id']);
$slides = get_field("slides", $block['id']);



$is_admin = is_admin();
?>

<?php if ($is_admin) : ?>
    <div class="admin-view-only flex items-center justify-center bg-slate-200 p-12 hover:bg-slate-300 transition-all">
        <!-- Content to be shown only in admin -->
        <h2>Slider hero content.</h2>
    </div>
<?php
    return;
endif; ?>

<div <?php echo esc_attr($anchor); ?> class="<?php echo esc_attr($class_name); ?> top-0 ">
    <!-- Slider main container -->
    <div class="swiper ">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <?php foreach ($slides as $slide) :
                $image_id = $slide["image"];
                $image_caption = $slide["Caption"];
            ?>
                <div class="swiper-slide h-screen bg-cover bg-black bg-no-repeat  bg-[center_top_20%]" style="background-image: url(<?php echo esc_url(wp_get_attachment_image_url($image_id, 'full')); ?>)">
                    <div class="absolute  lg:right-64 right-6 bottom-8  md:bottom-44 text-white uppercase font-medium text-[12px] md:text-[14px] text-right border-t border-white pt-6 ">
                        <?php echo $image_caption; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- If we need scrollbar -->
    </div>

</div>
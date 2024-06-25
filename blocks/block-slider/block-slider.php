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

<div <?php echo esc_attr($anchor); ?> class="<?php echo esc_attr($class_name); ?> z-10 top-0 w-full h-[100vh] sticky">
    <div class="relative z-20 ">
        <div class="absolute bottom-44 left-6 z-10  pointer-events-auto ">
            <h2 class="text-white uppercase text-7xl "><?php echo $title ?></h2>
            <!-- If we need navigation buttons -->
            <div class="flex  relative w-[160px] items-center gap-3 pb-4 text-white mt-6">
                <div class="dc24-swiper-button-prev flex items-center"><i class="fa-thin fa-chevron-left"></i></div>
                <div class="dc24-swiper-pagination relative "></div>
                <div class="dc24-swiper-button-next flex items-center"><i class="fa-thin fa-chevron-right"></i></div>
            </div>
            <p class="text-white  text-xl mb-6"><?php echo $subtitle ?></p>
            <a href="<?php echo $link["url"] ?>" class="rounded-full bg-primary pt-[10px] pb-[6px] pr-4 pl-4 text-xs uppercase text-white shadow-lg"><?php echo $link["title"] ?></a>
        </div>
        <div class="flex flex-col justify-center items-center absolute bottom-12 w-full z-20 pointer-event-none">
            <div class="text-sm text-white mb-2">scroll down</div>
            <i class="fa-light fa-chevron-down text-white text-sm"></i>
        </div>

        <!-- Slider main container -->
        <div class="swiper">

            <!-- Additional required wrapper -->
            <div class="swiper-wrapper relative z-0">
                <?php foreach ($slides as $slide) :
                    $image_id = $slide["image"];
                    $image_caption = $slide["Caption"];
                ?>
                    <div class="swiper-slide relative min-h-screen">
                        <img class="min-h-screen object-cover w-full" src="<?php echo esc_url(wp_get_attachment_image_url($image_id, 'full')); ?>" alt="">
                        <div class="absolute  right-64 bottom-44 text-white uppercase font-medium text-[14px] text-right border-t border-white pt-6">
                            <?php echo $image_caption; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- If we need scrollbar -->
        </div>
    </div>
</div>
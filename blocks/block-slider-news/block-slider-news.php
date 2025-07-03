<?php

/**
 * News Slider Block template.
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

// Get ACF field for number of slides
$slides_per_view = get_field('slides_per_view') ?: 1; // Default to 1 if not set

if ($slides_per_view == 1) {
    $class_name_slider = ' w-3/12';
} elseif ($slides_per_view == 2) {
    $class_name_slider = ' w-8/12';
} elseif ($slides_per_view == 3) {
    $class_name_slider = ' w-8/12';
}
if ($slides_per_view == 1) {
    $class_name_slider_height = ' !h-[600px]';
} elseif ($slides_per_view == 2) {
    $class_name_slider_height = ' !h-[400px]';
} elseif ($slides_per_view == 3) {
    $class_name_slider_height = ' !h-[500px]';
}


// Get posts (keep 10 posts)
$posts = get_posts(array(
    'numberposts' => 10,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC'
));

?>

<?php if ($is_admin) : ?>
    <div class="admin-view-only flex items-center justify-center bg-slate-200 p-12 hover:bg-slate-300 transition-all">
        <!-- Content to be shown only in admin -->
        <h2>News Slider - Latest 10 Posts</h2>
    </div>
<?php
    return;
endif; ?>

<div <?php echo esc_attr($anchor); ?> class="<?php echo esc_attr($class_name); ?> container py-8 flex flex-col items-center">
    <div class="flex justify-end items-center  <?php echo esc_attr($class_name_slider); ?>">
        <div class="flex relative w-[160px] items-center justify-center gap-3 pb-4 text-primary pt-6 bottom-6 left-7">
            <div class="dc24-swiper-button-prev-items flex items-center"><i class="fa-solid fa-chevron-left"></i></div>
            <div class="dc24-swiper-button-next-items flex items-center"><i class="fa-solid fa-chevron-right"></i></div>
        </div>
    </div>
    <!-- Slider main container -->
    <div class="swiper-items overflow-hidden  m-auto relative <?php echo esc_attr($class_name_slider); ?>" data-slides-per-view="<?php echo esc_attr($slides_per_view); ?>">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper mb-12 !h-[500px]">
            <?php foreach ($posts as $post) :
                setup_postdata($post);
                $image_id = get_post_thumbnail_id($post->ID);
                $title = get_the_title($post->ID);
                $excerpt = substr(get_the_excerpt($post->ID), 0, 60) . '...';
                $date = get_the_date('F Y', $post->ID);
                $link = get_permalink($post->ID);
            ?>
                <div class="swiper-slide group bg-white rounded-lg overflow-hidden h-full">
                    <a class="" href="<?php echo esc_url($link); ?>">
                        <div class="">
                            <?php if ($image_id) : ?>
                                <img class="w-full h-full object-cover" src="<?php echo esc_url(wp_get_attachment_image_url($image_id, 'medium')); ?>" alt="<?php echo esc_attr($title); ?>">
                            <?php else : ?>
                                <div class="">
                                    <i class="fa-regular fa-newspaper "></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="p-4 news-slider-content">
                            <div>
                                <h5 class="text-2xl font-bold text-primary mb-0"><?php echo esc_html($title); ?></h5>
                                <p class=" font-bold mb-4 capitalize"><?php echo esc_html($date); ?></p>
                                <p class=""><?php echo esc_html($excerpt); ?></p>
                            </div>
                            <div class=" bg-primary text-white rounded-full w-6 h-6 flex items-center justify-center absolute bottom-3 right-3 text-xs">
                                <i class="fa-solid fa-plus text-white"></i>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
</div>

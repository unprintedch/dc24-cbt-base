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

// Arguments for the WP Query
$args = array(
    'post_type' => 'video', // Your custom post type name
    'posts_per_page' => -1, // Retrieve all posts
    'orderby' => 'date',
    'order' => 'ASC',
    'category_name' => 'featured', // Category slug

);

// The Query
$query = new WP_Query($args);
?>

<?php if ($is_admin) : ?>
    <div class="admin-view-only flex items-center justify-center bg-slate-200 p-12 hover:bg-slate-300 transition-all">
        <!-- Content to be shown only in admin -->
        <h2>Slider video.</h2>
    </div>
<?php
    return;
endif; ?>

<div <?php echo esc_attr($anchor); ?> class="<?php echo esc_attr($class_name); ?>    relative z-20  px-12 overflow-hidden">

    <!-- Slider main container -->
    <div class="swiper-video">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper  mb-12">
            <?php
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $post_id = get_the_ID();
                    $image_id = get_field("image", $post_id);
                    $title = get_the_title();
                    $link =  get_permalink();
            ?>
                    <div class="swiper-slide group rounded-lg overflow-hidden dc24-overlay shadow-lg hover:shadow-md transition-all">
                        <a class="flex relative aspect-[3/4] " href="<?php echo $link ?>">
                            <img class="object-cover scale-100 group-hover:scale-110 transition-all" src="<?php echo esc_url(wp_get_attachment_image_url($image_id, 'full')); ?>" alt="">
                            <div class="title absolute  bottom-12 left-8 right-8">
                                <h5 class="text-white font-normal mt-4">
                                    <?php echo $title ?>
                                </h5>
                            </div>
                        </a>
                    </div>
            <?php }
            } else {
                // No posts found
            }
            /* Restore original Post Data */
            wp_reset_postdata();
            ?>
        </div>
        <!-- If we need navigation buttons -->
        <div class="flex relative w-[160px] items-center gap-3 pb-4 text-primary pt-6 bottom-6 left-7">
            <div class="dc24-swiper-button-prev-items flex items-center"><i class="fa-thin fa-chevron-left"></i></div>
            <div class="dc24-swiper-pagination-primary  relative "></div>
            <div class="dc24-swiper-button-next-items flex items-center"><i class="fa-thin fa-chevron-right"></i></div>
        </div>
    </div>
    <!-- If we need scrollbar -->

</div>
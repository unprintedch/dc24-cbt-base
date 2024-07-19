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

<?php if ($is_admin) : ?>
    <div class="admin-view-only flex items-center justify-center bg-slate-200 p-12 hover:bg-slate-300 transition-all">
        <!-- Content to be shown only in admin -->
        <h2>Grille de video.</h2>
    </div>
<?php
    return;
endif;

// Arguments for the WP Query
$args = array(
    'post_type' => 'video', // Your custom post type name
    'posts_per_page' => 4, // Retrieve all posts
    'orderby' => 'date',
    'order' => 'ASC',
    "facetwp"        => true
);

// The Query
$query = new WP_Query($args);
?>
<div class="alignfull px-12">
    <div class="flex gap-6 justify-between dc24-filters m-auto pb-3 pt-8">
        <div class="flex gap-4">
            <?php echo facetwp_display('facet', 'search'); ?>
            <?php echo facetwp_display('facet', 'categories'); ?>
          
        </div>
        <div class="flex gap-4">
            <?php echo facetwp_display('facet', 'tri'); ?>
        </div>
    </div>

    <div class="facetwp-template grid lg:grid-cols-4 md:grid-cols-3 gap-6 ">
        <?php
        // The Loop
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();
                // Get the video metadata   
                $title = get_the_title();
                $date = get_the_date('d/m/Y');
                $link = get_the_permalink();
                $categories = get_the_terms(get_the_ID(), 'category');
                $categories_names = [];
                if ($categories) {
                    foreach ($categories as $category) {
                        $categories_names[] = $category->name;
                    }
                }
                $image = get_field("image", $post_id);
        ?>

                <a href="<?php echo get_permalink() ?>" class=" no-underline group flex flex-col border border-gray-100 bg-white rounded-lg shadow-lg mb-4 relative hover:shadow-sm transition-all">
                    <?php
                    if ($image) {
                        $attachment_id =  $image;
                        $size = "full";
                        echo wp_get_attachment_image($attachment_id, $size, "", array("class" => "object-cover h-56 rounded-t-lg brightness-100 group-hover:brightness-105 transition-all"));
                    }
                    ?>

                    <div class="p-4 flex flex-col flex-grow justify-between">
                        <p class="text-[18px]  mb-2"><?php echo $title; ?></p>
                        <div class="self">
                            <p class="text-sm text-gray-600 mb-2"><?php echo $date; ?></p>
                            <?php if (!empty($categories_names)) : ?>
                                <p class="text-xs text-primary mt-2"><?php echo implode(" - ", $categories_names) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>

        <?php
            }
        } else {
            // No posts found
            echo '<p class="text-gray-600">No videos found.</p>';
        };
     
        // Restore original Post Data
        wp_reset_postdata();
        ?>
             

    </div>
    <div class="flex justify-center pt-6">
            <?php echo facetwp_display('facet', 'pager_video'); ?>
    </div>
</div>
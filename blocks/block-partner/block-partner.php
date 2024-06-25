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
        <h2>Grille des partnaires.</h2>
    </div>
<?php
    return;
endif;

// Arguments for the WP Query
$args = array(
    'post_type' => 'partners', // Your custom post type name
    'posts_per_page' => -1, // Retrieve all posts
    "facetwp"        => true
);

// The Query
$query = new WP_Query($args);
?>
<div class="alignfull  p-16 ">
    <div class="flex  rounded-lg bg-gray-light overflow-hidden">
        <div class="w-4/12 flex flex-col gap-6 dc24-filters dc24-filters__partner mx-auto p-3 pt-12">
            <?php echo facetwp_display('facet', 'search'); ?>
            <?php echo facetwp_display('facet', 'partner_type'); ?>
        </div>
        <div class="w-7/12 justify-self-end">
            <?php echo facetwp_display('facet', 'partner_map'); ?>
        </div>
    </div>
    <div class="facetwp-template">
        <?php
        // The Loop
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();
                // Get the video metadata   
                $title = get_the_title();
                $address = get_field('address', $post_id);
                $email = get_field('email', $post_id);
                $link = get_field('url', $post_id);
                $phone = get_field('Phone', $post_id);
                $categories = get_the_terms(get_the_ID(), 'partner_type');
        ?>
                <!-- <div class="p-4">
                            <h3 class="text-xl font-bold text-gray-800"><?php echo $title; ?></h3>
                            <p class=""><?php echo $address["street"]; ?> <?php echo $address["street_num"]; ?></p>
                            <p class=""><?php echo $address["city"]; ?> <?php echo $address["npa"]; ?></p>
                            <p><a href="<?php echo "mailto:" . $email ?>" class=""><?php echo $email ?></a></p>
                            <p><a href="<?php echo "tel:" . $phone ?>" class=""><?php echo $phone ?></a></p>
                            <p><a href="<?php echo $link; ?>" class=""><?php echo $link; ?></a></p>
                        </div> -->
        <?php
            }
        } else {
            // No posts found
            echo '<p class="text-gray-600">No videos found.</p>';
        }

        // Restore original Post Data
        wp_reset_postdata();
        ?>
    </div>
</div>
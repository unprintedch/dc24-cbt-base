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
        <h2>Fromation grid.</h2>
    </div>
<?php
    return;
endif; ?>



<div>
    <?php
    $args = array(
        'post_type'      => 'formation',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC'
    );

    $posts = get_posts($args);

    foreach ($posts as $post) {
        $post_id = $post->ID;
        $parent_id = $post->post_parent;
        $post_thumbnail = get_the_post_thumbnail_url($post_id, 'full');
        $post_title = get_the_title($post_id);
        $post_link = get_permalink($post_id);
        $formation_hierarchy[$parent_id][] = array(
            'post_id' => $post_id,
            'post_thumbnail' => $post_thumbnail,
            'post_title' => $post_title,
            'post_link' => $post_link
        );
    } ?>
    <div class="container">
        <div id="filter-buttons-formation" class="flex flex-col lg:flex-row gap-2  justify-center py-2 mb-6 border-b border-gray-100">
            <?php
            foreach ($formation_hierarchy[0] as $parent) {
                $parent_id = $parent['post_id'];
                $parent_title = $parent['post_title'];
                if($parent_id == "1602" ){
                    $classes = "text-primary ";
                } else {
                    $classes = "";
                }
            ?>
                <button data-filter="<?php echo  $parent_id ?>" class="<?php echo $classes ?> px-4 py-2 text-[20px] text-[#808080] hover:text-primary  uppercase  text-center transition-all"> <?php echo $parent_title ?></button>
            <?php
            } ?>
        </div>


        <div class="grid lg:grid-cols-4 grid-cols-2 gap-5 p-b">
            <?php
            foreach ($formation_hierarchy as $parent_id => $child_posts) {
                if ($parent_id == 0) {
                    continue;
                } ?>
                <?php foreach ($child_posts as $child) {
                    $child_id = $child['post_id'];
                    $child_title = $child['post_title'];
                    $post_thumbnail = $child['post_thumbnail'];
                

                ?><a href="<?php echo get_permalink($child_id) ?>" class="formation-item relative h-[165px] <?php echo $classes." ".$parent_id  ?>">
                        <div class="z-0 relative rounded-lg  brightness-75	h-full  bg-cover bg-bottom hover:brightness-100 transition-all hover:scale-105"  style="background-image: url('<?php echo get_the_post_thumbnail_url($child_id, 'full'); ?>');">
                        </div>
                        <div class="pointer-events-none absolute p-6 text-white text-[20px] bottom-0 left-0 z-10 uppercase"><?php echo $child_title ?></div>
                    </a>
                <?php
                } ?>

            <?php }
            ?>
        </div>


    </div>


</div>
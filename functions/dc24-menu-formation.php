<?php

function get_child_count($parent_id)
{
    $args = array(
        'post_type'      => 'formation',
        'post_status'    => 'publish',
        'post_parent'    => $parent_id,
        'fields'         => 'ids' // Only get the IDs to save memory
    );

    $children = get_posts($args);
    return count($children);
}

function get_first_child_by_menu_order($parent_id)
{
    $args = array(
        'post_type'      => 'formation',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'post_parent'    => $parent_id,
        'orderby'        => 'menu_order',
        'order'          => 'ASC'
    );

    $children = get_posts($args);

    if (!empty($children)) {
        return $children[0]; // Return the first child post
    }

    return null; // Return null if no children are found
}



function dc24_get_top_navigation_formations($parent_id = 0, $post_id = 0)
{
    $args = array(
        'post_type'      => 'formation',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'post_parent'    => 0,
        'orderby'        => 'menu_order',
        'order'          => 'ASC'
    );

    $posts = get_posts($args);

    if (empty($posts)) {
        return '';
    }

    ob_start();
?>
    <ul class="flex flex-col lg:flex-row gap-2 ">
        <?php foreach ($posts as $post) :

            if ($parent_id == 0) {
                $is_current = ($post->ID == $post_id) ? 'border-b border-gray-300' : 'hover:text-white ';
              
            } else {
                $is_current = ($post->ID == $parent_id) ? 'border-b border-gray-300' : 'hover:text-white ';
              
            }
            $first_child = get_first_child_by_menu_order($post->ID)->ID;
            $permalink = get_permalink($first_child);

        ?>
            <li class="">
                <a href="<?php echo $permalink; ?>" class="block px-4 py-2 text-[20px] text-gray-200  uppercase  text-center transition-all <?php echo esc_attr($is_current); ?>">
                    <?php echo esc_html($post->post_title); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php
    return ob_get_clean();
}
function dc24_get_sub_navigation_formations($parent_id = 0, $post_id = 0)
{

    if ($parent_id == 0) {
        $parent_id = $post_id;
    }

    $args = array(
        'post_type'      => 'formation',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'post_parent'    => $parent_id,
        'orderby'        => 'menu_order',
        'order'          => 'ASC'
    );

    $posts = get_posts($args);

    if (empty($posts)) {
        return '';
    }

    ob_start();
?>
    <ul class="flex gap-2 flex-wrap justify-center">
        <?php foreach ($posts as $post) :

            $is_current = ($post->ID == $post_id) ? 'bg-primary text-white' : 'hover:bg-primary hover:text-white';

        ?>
            <li class="">
                <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" class="uppercase text-sm font-medium block px-4 py-2 text-[#808080] bg-gray-light rounded-lg transition-all <?php echo esc_attr($is_current); ?>">
                    <?php echo esc_html($post->post_title); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php
    return ob_get_clean();
}


function get_current_formation_hierarchy()
{
    global $post;
    if (!$post) {
        return array();
    }

    $current_page_id = $post->ID;

    // Find the top-most parent
    $parent_id = $post->post_parent;
    while ($parent_id) {
        $page = get_post($parent_id);
        $parent_id = $page->post_parent;
        if ($parent_id == 0) {
            $top_parent_id = $page->ID;
            break;
        }
    }

    if (empty($top_parent_id)) {
        $top_parent_id = $current_page_id;
    }

    // Retrieve the hierarchy
    $hierarchy = get_formations_tree($top_parent_id);
    return $hierarchy;
}

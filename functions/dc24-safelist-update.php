<?php 


function get_additional_block_classes($blocks) {
    $classes = [];

    foreach ($blocks as $block) {
        if (isset($block['attrs']['className'])) {
            $class_array = explode(' ', $block['attrs']['className']);
            $classes = array_merge($classes, $class_array);
        }

        // Check inner blocks recursively
        if (isset($block['innerBlocks']) && is_array($block['innerBlocks'])) {
            $inner_classes = get_additional_block_classes($block['innerBlocks']);
            $classes = array_merge($classes, $inner_classes);
        }
    }

    return array_unique($classes);
}

function add_custom_classes_to_safelist($post_id) {
    // Check if this is an autosave or not
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Verify the post type is one we want to target (optional, but recommended)
    $post_type = get_post_type($post_id);
    if (!in_array($post_type, ['post', 'page', 'formation'])) {
        return;
    }

    // Get the post content
    $post_content = get_post_field('post_content', $post_id);

    // Parse the content into blocks
    $blocks = parse_blocks($post_content);

    // Retrieve additional block classes
    $classes = get_additional_block_classes($blocks);

    // Define the safelist file path
    $safelist_file = get_template_directory() . '/tailwind.safelist.json';

    // Load existing safelist classes
    $safelist_classes = [];
    if (file_exists($safelist_file)) {
        $safelist_classes = json_decode(file_get_contents($safelist_file), true);
    }

    // Ensure $safelist_classes is an array
    if (!is_array($safelist_classes)) {
        $safelist_classes = [];
    }

    // Find new classes not already in the safelist
    $new_classes = array_diff($classes, $safelist_classes);

    if (!empty($new_classes)) {
        // Merge new classes with existing safelist
        $updated_safelist = array_merge($safelist_classes, $new_classes);

        // Save the updated safelist
        if (is_writable($safelist_file) || (!file_exists($safelist_file) && is_writable(dirname($safelist_file)))) {
            file_put_contents($safelist_file, json_encode($updated_safelist, JSON_PRETTY_PRINT));
        } else {
            error_log('Failed to write to safelist file: ' . $safelist_file);
        }
    }
}

add_action('save_post', 'add_custom_classes_to_safelist');
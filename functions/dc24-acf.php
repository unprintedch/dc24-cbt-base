<?php




/**
 * Count Gravity Form entries by unique ID and sum participants, then update ACF repeater sub-field.
 */

add_action('acf/save_post', 'add_unique_id_to_repeater_items', 20);
function add_unique_id_to_repeater_items($post_id)
{
    // Check if the ACF repeater field is set
    if (have_rows('cours', $post_id)) {
        $row_index = 0;
        while (have_rows('cours', $post_id)) {
            the_row();
            $row_index++;

            // Generate a unique ID for this row if it doesn't have one
            $unique_id = get_sub_field('unique_id');
            if (empty($unique_id)) {
                $unique_id = uniqid();
                update_sub_field('unique_id', $unique_id, $post_id);
            }
        }
    }
}

/**
 * Get a repeater item by its unique ID.
 *
 * @param string $post_id The ID of the post where the repeater field is located.
 * @param string $repeater_field The name of the repeater field.
 * @param string $unique_id The unique ID to search for.
 * @return array|false The repeater item if found, false otherwise.
 */
function dc24_get_repeater_item_by_unique_id($post_id, $repeater_field, $unique_id)
{
    // Retrieve all rows of the repeater field
    $rows = get_field($repeater_field, $post_id);

    // Check if rows exist
    if ($rows) {
        // Loop through each row
        foreach ($rows as $row) {
            // Check if the unique_id matches
            if ($row['unique_id'] === $unique_id) {
                return $row;
            }
        }
    }

    // Return false if no match is found
    return false;
}

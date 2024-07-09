<?php

/**
 * Gravity Perks // Inventory // Add Number as a Supported Field Type
 * https://gravitywiz.com/documentation/gravity-forms-inventory/
 */
add_filter('gpi_supported_field_types', function ($field_types) {
    // Update "number" to desired field type.
    $field_types['number'] = true;

    return $field_types;
});

add_filter('gpi_inventory_limit_advanced_2_31', 'dc24_setlimit');
function dc24_setlimit()
{
    // get post id form the url
    if(!isset($_GET['postid']) || !isset($_GET['sessionid'])) return;

    $post_id = $_GET['postid'];
    $repeater_field = 'cours';
    $unique_id = $_GET['sessionid'];
    // get the repeater item
    $row = dc24_get_repeater_item_by_unique_id($post_id, $repeater_field, $unique_id);
    $inventory_total = $row['info']['inventory_total'] ?? 0;
    // Update "FORMID" to the ID of your form.
    // Update "FIELDID" to the ID of your field.
    // Update "10" to the desired limit.
    return $inventory_total;
}

// get the number of booking for frontend

function dc24_get_booked_count_from_session_id($unique_id)
{
    // Retrieve entries from Gravity Form that match the unique ID
    $form_id = '2';
    $unique_id_field_id = '37';
    $participants_field_id = '31';

    $search_criteria = [
        'field_filters' => [
            [
                'key' => $unique_id_field_id,
                'value' => $unique_id
            ]
        ]
    ];
    $entries = GFAPI::get_entries($form_id, $search_criteria);
    // Sum the participants field for matching entries
    $participant_count = 0;
    foreach ($entries as $entry) {
        $participant_count += intval(rgar($entry, $participants_field_id));
    }
    return $participant_count;
}
// get the number of booking for frontend

function dc24_get_booked_list_from_session_id($unique_id)
{
    // Retrieve entries from Gravity Form that match the unique ID
    $form_id = '2';
    $unique_id_field_id = '37';
    $participants_field_id = '31';

    $search_criteria = [
        'field_filters' => [
            [
                'key' => $unique_id_field_id,
                'value' => $unique_id
            ]
        ]
    ];
    $entries = GFAPI::get_entries($form_id, $search_criteria);
    // Sum the participants field for matching entries
    return $entries;
}


add_filter('gform_default_styles', function ($styles) {
    return '{"theme":"orbital","inputSize":"md","inputBorderRadius":"20","inputBorderColor":"#e3e3e3","inputBackgroundColor":"#e3e3e3","inputColor":"#000000","inputPrimaryColor":"#204ce5","labelFontSize":"16","labelColor":"#000000","descriptionFontSize":"16","descriptionColor":"#000000","buttonPrimaryBackgroundColor":"#0000df","buttonPrimaryColor":"#fff"}';
});

add_filter( 'gform_address_display_format', 'address_format', 10, 2 );
function address_format( $format, $field ) {
return 'zip_before_city';
}
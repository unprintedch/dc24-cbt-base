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
// get  from url parameter
if (!$is_admin && isset($_GET['postid']) && isset($_GET['sessionid'])) :
    $course_id = $_GET['postid'];
    $course_title = get_the_title($course_id);
    $parent_title = get_the_title(wp_get_post_parent_id($course_id));
    $course_title  = $parent_title . ' - ' . $course_title;
    // get the repeater item
    $repeater_field = 'cours';
    $unique_id = $_GET['sessionid'];
    $row = dc24_get_repeater_item_by_unique_id($course_id, $repeater_field, $unique_id);
    $place = $row["info"]["place_tax"]->name;
    $dates_grouped = group_dates_by_day($row['dates']);
    $session = array();
    foreach ($dates_grouped as $key => $sessions) {
        $session[] = $key . ' ' . implode(" – ", array_map(function ($session) {
            return $session['time_start'] . ' ' . $session['time_end'];
        }, $sessions));
    };
else :
    $course_id = 0;
    $course_title = '';
    $place = '';
    $session = array();
endif;
?>

<?php if ($is_admin) : ?>
    <div class="admin-view-only flex items-center justify-center bg-slate-200 p-12 hover:bg-slate-300 transition-all">
        <!-- Content to be shown only in admin -->
        <h2>Header formation inscription.</h2>
    </div>
<?php
    return;
endif; ?>




<div class="min-h-[400px] flex items-center justify-center border-b border-black relative container">
    <div class="flex flex-col text-center">
        <h1 class="text-[56px]"><?php echo get_the_title() ?></h1>
        <p><?php echo $course_title ?></p>
        <p><?php echo $place ?></p>
        <p class="text-sm"><?php echo implode(" <br> ", $session)  ?></p>
    </div>
    <div class="absolute left-0 bottom-6">
        <a href="<?php echo get_permalink($course_id) ?>" class="text-primary"><i class="fa-regular fa-chevron-left"></i> Retour aux formations</a>
    </div>
</div>
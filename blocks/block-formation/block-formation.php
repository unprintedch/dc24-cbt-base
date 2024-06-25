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
        <h2>Liste des cours.</h2>
    </div>
<?php
    return;
endif;
?>




<?php
// list of courses from the meta
$post_id = get_the_ID();
$courses = get_field('cours', $post_id);
if ($courses) :

    $courses_places_list = array_map(function ($course) {
        if (isset($course['info']['place'])) {
            return [
                'name' => $course['info']['place'],
                'slug' => sanitize_title($course['info']['place'])
            ];
        }
        return null;
    }, $courses);
    // Remove any null values
    $courses_places_list = array_filter($courses_places_list);
    // Remove duplicate values based on 'slug'
    $courses_places_list = array_unique($courses_places_list, SORT_REGULAR);
?>


    <div class="p-6 pt-0 grid gap-6">
        <div class="py-3 filter-buttons flex gap-3">
            <button data-filter="all" class="text-primary">All</button>

            <?php foreach ($courses_places_list as $place) {
                $place_name = $place['name'];
                $place_slug = $place['slug']; ?>
                <button data-filter="<?php echo $place_slug ?>" class=''><?php echo $place_name ?> </button>
            <?php  } ?>
        </div>
        <?php foreach ($courses as $course) :
            $unique_id = $course['unique_id'];
            $info = $course["info"];
            $info_place = $info['place'];
            $info_place_slug = sanitize_title($info_place);
            $info_teacher = $info['teacher'];
            $info_inventory_total = (int) $info['inventory_total'];
            // get the bookings 
            $booked = dc24_get_booked_count_from_session_id($unique_id);
            $booked = (int) $booked;


            $info_inventory_free =  $info_inventory_total - $booked;
            $dates = $course['dates'];
        ?>
            <a href="<?php echo get_permalink(1103) ?>?postid=<?php echo $post_id ?>&sessionid=<?php echo  $unique_id ?>" class="<?php echo  $info_place_slug ?> course-item p-6 bg-gray-200 grid grid-cols-2 text-base rounded-lg shadow-md">
                <div class="text-sm col-span-2 mb-2 pb-2 border-b border-gray-300">
                    <i class="fa-solid fa-location-pin text-xs text-primary"></i> <?php echo $info_place; ?>
                </div>
                <div class="font-medium">
                    <div>
                        <?php echo $info_teacher; ?>
                    </div>
                    <div class="text-primary">
                        Places disponibles: <?php echo $info_inventory_free; ?>/<?php echo $info_inventory_total; ?>
                    </div>
                </div>
                <div class="font-light">
                    <?php
                    foreach ($dates as $session) :
                        $session_date = $session['date'];
                        $session_time = $session['time'];
                    ?>
                        <div class="flex gap-5">
                            <div class=""> <?php echo $session_date  ?></div>
                            <div class=""> <?php echo $session_time ?></div>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>
            </a>
            <div>
                <?php
                if ($booked > 0 && current_user_can("manage_options")) { ?>
                    <details>
                        <summary class="text-primary">Liste des participants</summary>
                        <?php $entries = dc24_get_booked_list_from_session_id($unique_id);
                        foreach ($entries as $entry) {
                            $company = $entry['18'];
                            $main_contact_firstname = $entry['1.3'];
                            $main_contact_lastname = $entry['1.6'];
                            $main_contact_email = $entry['2'];
                            $main_contact_phone = $entry['5'];
                            $participants = $entry['33'];
                            $participants = unserialize($participants);
                        ?>
                            <div class="mb-2 pb-2 border-b border-gray-200">
                                <div><?php echo $company ?></div>
                                <div class="font-medium"><?php echo  $main_contact_firstname . " " . $main_contact_lastname ?> </div>

                                <?php
                                if ($participants !== false) {
                                    // Access the array data
                                    foreach ($participants as $item) {
                                        $prenom = $item['Prénom'];
                                        $nom = $item['Nom']; ?>
                                        <div class="font-light"><?php echo $prenom . " " . $nom . "<br>"; ?></div>
                                <?php
                                    }
                                } else {
                                    echo "Failed to unserialize the string.";
                                } ?>
                            </div>
                        <?php  } ?>
                        <div>
                            <a class="text-primary text-sm " href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=gf_entries&view=entries&id=2&orderby=0&order=ASC&s=<?php echo $unique_id ?>&field_id=37&operator=is">
                                Gerer les réservations
                            </a>
                        </div>
                    </details>
                <?php };
                ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
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

// ________________ TEST

//  $course_id = 1084;
// $session_id = "668423c74e751";
// get_course_data($course_id,  $session_id);

// _______________________




$courses = get_field('cours', $post_id);
if ($courses) :
    $courses_places_list = array_map(function ($course) {
        if (isset($course['info']['place_tax'])) {
            $place_tax = $course['info']['place_tax'];
            return [
                'name' => $place_tax->name,
                'slug' => $place_tax->slug
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

            // check if the cours is still in the futur    
            $dates = $course['dates'];
            $future = dc24_checkLargestDateInPast($dates);
            $classe_list = "";
            if ($future === false) {
                $classe_list = "hidden";
                continue;
            }
            //________________________________________

            // Group the date for display
            $dates_grouped = group_dates_by_day($dates);



            $unique_id = $course['unique_id'];
            $info = $course["info"];
            $info_place = $info['place_tax']->name;
            $info_place_slug = $info['place_tax']->slug;
            $info_teacher_tax = $info['formateur_tax']->name ?? null;
            $info_inventory_total = (int) $info['inventory_total'];
            // get the bookings 
            $booked = dc24_get_booked_count_from_session_id($unique_id);
            $booked = (int) $booked;
            $info_inventory_free =  $info_inventory_total - $booked;
            if ($info_inventory_free > 0) {
                $available  = true;
                $classes_available = "";
                $is_open = false;
                if ($booked >= 2) {
                    $is_open = true;
                }
            } else {
                $available  = false;
                $classes_available = "pointer-events-none opacity-50";
                $is_open = false;
            }

        ?>
            <div class="<?php echo  $info_place_slug . " " . $classes_available ?> course-item">
                <a href="<?php echo get_permalink(1103) ?>?postid=<?php echo $post_id ?>&sessionid=<?php echo  $unique_id ?>" class=" flex flex-col gap-4  p-6 bg-gray-200  text-base rounded-lg shadow-md hover:shadow-none hover:bg-gray-100 transition-all">
                    <div class="flex justify-between mb-2 pb-2 border-b border-gray-300 text-primary">
                        <div>
                            <i class="fa-solid fa-location-pin "></i> <?php echo $info_place; ?>
                        </div>
                        <div>
                            <i class="fa-solid fa-person-chalkboard "></i> <?php echo $info_teacher_tax; ?>
                        </div>
                    </div>
                    <div class="">
                        <?php
                        foreach ($dates_grouped as $key => $sessions) :
                            $session_date = $key;
                        ?>
                            <div class="flex gap-3 text-lg">
                                <div class="text-nowrap	"> <?php echo $session_date  ?></div>
                                <div class="">
                                    <?php
                                    foreach ($sessions as $session) {
                                        $start = $session['time_start'];
                                        $end = $session['time_end'];
                                        echo $start . " - " . $end . "<br>";
                                    }
                                    ?>

                                </div>
                            </div>
                        <?php
                        endforeach;
                        ?>
                    </div>

                    <div class="border-t border-gray-300 flex justify-between mt-2 pt-2 text-primary">
                        <div class="">

                            <?php if ($available) : ?>
                                <?php if ($is_open) : ?>
                                    Cours ouvert – places disponibles: <?php echo $info_inventory_free; ?>/<?php echo $info_inventory_total; ?>
                                <?php else: ?>
                                    Places disponibles: <?php echo $info_inventory_free; ?>/<?php echo $info_inventory_total; ?>
                                <?php endif; ?>
                            <?php else : ?>
                                Complet
                            <?php endif; ?>
                        </div>
                        <div>
                            Réserver <i class="fa-solid fa-arrow-right "></i>
                        </div>
                    </div>
                </a>
                <div class="py-3 pointer-events-auto">
                    <?php
                    if ($booked > 0 && current_user_can("manage_options")) {
                    ?>
                        <div class="relative <?php echo  $classe_list ?>">
                            <details>
                                <summary class="text-primary">Liste des participants </summary>
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
                                        if ($participants !== false && !empty($participants) && is_array($participants)) {
                                            // Access the array data
                                            foreach ($participants as $item) {
                                                $prenom = $item['Prénom'];
                                                $nom = $item['Nom']; ?>
                                                <div class="font-light"><?php echo $prenom . " " . $nom . "<br>"; ?></div>
                                        <?php
                                            }
                                        } ?>
                                    </div>
                                <?php  } ?>
                                <div>
                                    <a class="text-primary text-sm " href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=gf_entries&view=entries&id=2&orderby=0&order=ASC&s=<?php echo $unique_id ?>&field_id=37&operator=is">
                                        Gerer les réservations
                                    </a>
                                </div>
                            </details>
                            <a href="" class="generate-ics absolute top-2 right-2 text-xs " data-course-id="<?php echo $post_id ?>" data-session-id="<?php echo $unique_id ?>"><i class="fa-light fa-calendar-arrow-down"></i> Ajouter au calendrier</a>
                        </div>
                    <?php };
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
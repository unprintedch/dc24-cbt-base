<?php

add_action('wp_ajax_generate_ics', 'generate_ics_file');
add_action('wp_ajax_nopriv_generate_ics', 'generate_ics_file');

function generate_ics_file()
{
    // On recupère les données du formulaire (id et sesssion id)
    $course_id = isset($_POST['course_id']) ? intval($_POST['course_id']) : 0;
    $session_id = isset($_POST['session_id']) ? $_POST['session_id'] : '';

    // On recupère les donnée du cours et de la session.
    $course = get_course_data($course_id,  $session_id);

    if (!$course) {
        wp_send_json_error('Invalid course ID');
        wp_die();
    }

    $icsContent = "BEGIN:VCALENDAR\r\n";
    $icsContent .= "VERSION:2.0\r\n";
    $icsContent .= "PRODID:-//Your Organization//Your Product//EN\r\n";

    foreach ($course['dates'] as $date) {
        $startDate = DateTime::createFromFormat('d/m/Y H:i', $date['date_start'], new DateTimeZone('Europe/Zurich'));
        $endDate = DateTime::createFromFormat('d/m/Y H:i', $date['date_end'], new DateTimeZone('Europe/Zurich'));

        if ($startDate && $endDate) {
            $icsContent .= "BEGIN:VEVENT\r\n";
            $icsContent .= "UID:" . uniqid() . "@yourdomain.com\r\n";
            $icsContent .= "DTSTAMP:" . gmdate('Ymd\THis\Z') . "\r\n";
            $icsContent .= "DTSTART;TZID=Europe/Zurich:" . $startDate->format('Ymd\THis') . "\r\n";
            $icsContent .= "DTEND;TZID=Europe/Zurich:" . $endDate->format('Ymd\THis') . "\r\n";
            $icsContent .= "SUMMARY:" . $course['title'] . "\r\n";
            $icsContent .= "DESCRIPTION:" . $course['description'] . "\r\n";
            $icsContent .= "LOCATION:" . $course['location'] . "\r\n";
            $icsContent .= "END:VEVENT\r\n";
        }
    }

    $icsContent .= "END:VCALENDAR\r\n";

    // Output ICS file content
    wp_send_json_success($icsContent);
    wp_die();
}

function get_course_data($course_id,  $session_id)
{

    // get the session data from the right course
    $courses = get_field('cours', $course_id);
    // get the custom title of the course
   
    if(get_field('formation_title', $course_id)){
        $course_title = get_field('formation_title', $course_id) ;
    } else{
        // get title and parent title 
        $course_title = get_the_title($course_id);
        $parent_title = get_the_title(wp_get_post_parent_id($course_id));
        $course_title  = $parent_title . ' - ' . $course_title;
    }

    // get the session data from the right course
    $course = array_filter($courses, function ($course) use ($session_id) {
        return $course['unique_id'] === $session_id;
    });
    // Re-index the filtered array to start from index 0
    $course = array_values($course);
    $dates = $course[0]["dates"];
    $formateur = $course[0]["info"]["formateur_tax"]->name;

    // get the students in the gravityform entries
    $description = get_course_description($session_id, $formateur, $dates);

    $return =  [
        'title' => "Formation avec $formateur –  $course_title ",
        'description' => $description,
        'location' => $course[0]["info"]["place_tax"]->name,
        'dates' => $dates,
    ];
    // var_dump($return);
    return $return;
}

function get_course_description($unique_id, $formateur, $dates)
{
    // Fetch the booked list from the session ID
    $entries = dc24_get_booked_list_from_session_id($unique_id);
    $dates_grouped = group_dates_by_day($dates);


    // Initialize an empty description string
    $description = "Formateur et dates\\n";
    $description .= "$formateur\\n";
    foreach ($dates_grouped as $key => $sessions) {
        foreach ($sessions as $session) {
            $start = $session['time_start'];
            $end = $session['time_end'];
            $description .= "$key – $start/$end \\n";
        }
    };
    $description .= "––––––––––––––––––––––––––––––––\\n";

    // Loop through each entry
    foreach ($entries as $entry) {
        $company = isset($entry['18']) ? $entry['18'] : '';
        $main_contact_firstname = isset($entry['1.3']) ? $entry['1.3'] : '';
        $main_contact_lastname = isset($entry['1.6']) ? $entry['1.6'] : '';
        $main_contact_email = isset($entry['2']) ? $entry['2'] : '';
        $main_contact_phone = isset($entry['5']) ? $entry['5'] : '';
        $participants = isset($entry['33']) ? unserialize($entry['33']) : [];

        // Append the entry details to the description
        $description .= "Company: $company\\n";
        $description .= "Contact: $main_contact_firstname $main_contact_lastname\\n";
        $description .= "Email: $main_contact_email\\n";
        $description .= "Phone: $main_contact_phone\\n";

        if (!empty($participants) && is_array($participants)) {
            $description .= "Participants:\\n";
            // Access the array data
            foreach ($participants as $participant) {
                $prenom = isset($participant['Prénom']) ? $participant['Prénom'] : '';
                $nom = isset($participant['Nom']) ? $participant['Nom'] : '';
                $description .= "$prenom $nom\\n";
            }
        }

        // Separate entries with a blank line
        $description .= "\\n";
    }

    return $description;
}

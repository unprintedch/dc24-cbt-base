<?php 

function group_dates_by_day($dates) {
    $grouped_dates = [];

    foreach ($dates as $date) {
        // Extract the date and time from the 'date_start' and 'date_end'

        $date_start = DateTime::createFromFormat('d/m/Y H:i', $date['date_start']);
        $date_end = DateTime::createFromFormat('d/m/Y H:i', $date['date_end']);

        // Check if date_start and date_end are valid
        if ($date_start !== false && $date_end !== false) {
            // Format the date as 'd M Y' to use as the key
            $day_key = $date_start->format('d/m/Y');

            // Initialize the array for this day if not already set
            if (!isset($grouped_dates[$day_key])) {
                $grouped_dates[$day_key] = [];
            }

            // Append the times to the array for this day
            $grouped_dates[$day_key][] = [
                'time_start' => $date_start->format('H:i'),
                'time_end' => $date_end->format('H:i')
            ];
        }
    }

    return $grouped_dates;
}

function dc24_checkLargestDateInPast($dates) {
  // Initialize variables
  $largest_date = null;
  $current_date = new DateTime(); // Get current date

  // Loop through the dates to find the largest date
  foreach ($dates as $session) {

      $session_date_str = $session["date_start"];
      $session_date = DateTime::createFromFormat('d/m/Y H:i', $session_date_str);
      
    if (!$session_date) {
          // If the date format is invalid, skip this date
          continue;
      }

      if ($largest_date === null || $session_date > $largest_date) {
          $largest_date = $session_date;
      }
  }

  // Check if the largest date is in the past
  if ($largest_date < $current_date) {
      return false;
  }

  return true;
}
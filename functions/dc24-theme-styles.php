<?php

function dc24_get_theme_styles()
{

    $global_settings = wp_get_global_settings();
    $global_styles = wp_get_global_styles();

    
    $newConfig = "      fontSize: {
        'h4': '1.25rem',  // for example, 20px
    },";
   return $result;
    
}


function dc24_get_theme_styles_create_json($data)
{
    // Get the current theme directory
    $themeDirectory = get_template_directory();
    $fileName = "dc24-theme-styles.json";

    // Create the full file path
    $filePath = $themeDirectory . '/' . $fileName;

    // Convert the data array to JSON format
    $json_data = json_encode($data);

    // Check if the JSON data was created successfully
    if ($json_data === false) {
        // Handle error; JSON encoding failed
        return 'JSON encode error: ' . json_last_error_msg();
    }

    // Write the JSON data to a file
    if (file_put_contents($filePath, $json_data) === false) {
        // Handle error; file write failed
        return 'Error writing to file.';
    }

    // Return success message
    return 'Data successfully written to ' . $filePath;
}

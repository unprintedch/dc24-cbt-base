<?php

// function updateTailwindConfig($newConfig) {
//     $themeDirectory = get_template_directory();
//     $filePath = "$themeDirectory/tailwind.config.js"; // Adjust the path as necessary

//     // Data to append
//     $dataToAppend = "\nmodule.exports = {\n  theme: {\n    extend: {\n" . $newConfig . "\n    }\n  }\n};\n";

//     // Append to the file
//     if (file_put_contents($filePath, $dataToAppend, FILE_APPEND) === false) {
//         return 'Error writing to file.';
//     }

//     return 'Config successfully updated.';
// }


function createAndWriteJsonInTheme($data) {


    // Get the current theme directory
    $themeDirectory = get_template_directory();
    $fileName = $fileName . '.json';

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


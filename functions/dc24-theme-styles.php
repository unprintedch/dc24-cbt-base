<?php

function dc24_handle_global_styles_save($post_id, $post, $update)
{
    // Check if the updated post is of type 'wp_global_styles'
    if ($post->post_type !== 'wp_global_styles') {
        return;
    }

    // Ensure this is not an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    $global_styles = wp_get_global_styles();
    $global_settings = wp_get_global_settings();

    // write heading styles to a file
    $heading_update = dc24_write_custom_heading_css($global_styles);
    dc24_write_custom_colors_json($global_settings);

    // For example, you can log a message or trigger a custom action
    error_log($heading_update);
  
}
add_action('save_post', 'dc24_handle_global_styles_save', 10, 3);

function dc24_write_custom_colors_json($global_settings)
{
    $colors = $global_settings["color"]["palette"]["theme"];
    $colors_custom = $global_settings["color"]["palette"]["custom"];
    // merge these two arrays
    $colors = array_merge($colors, $colors_custom);


    // Define the path to the JSON file
    $file_path = get_template_directory() . '/tailwind-color.json';

    // Write the colors to the JSON file
    if (file_put_contents($file_path, json_encode($colors, JSON_PRETTY_PRINT)) === false) {

        error_log('Failed to write custom colors JSON to ' . $file_path);
    } else {
        error_log('Custom colors JSON written to ' . $file_path);
    }
}

function dc24_write_custom_heading_css($global_styles)
{
    // Generate the CSS content    
    // Define the path to the CSS file
    $file_path = get_template_directory() . '/css/heading.css';

    // extract heading styles from global styles
    $heading_styles = $global_styles['elements'];

    // array of heading styles

    foreach ($heading_styles as $key => $value) {
        if (in_array($key, ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'])) {
            $headings[$key] = [
                "font-style" => $value["typography"]["fontStyle"] ?? "normal",
                "font-weight" => $value["typography"]["fontWeight"] ?? 400,
                "font-size" => $value["typography"]["fontSize"],
            ];
        }
    }

    $css = dc24_generate_heading_css($headings);


    // Generate the CSS content
    // $css = json_encode($headings, JSON_PRETTY_PRINT);


    // Write the CSS content to the file
    if (file_put_contents($file_path, $css) === false) {
        error_log('Failed to write custom heading CSS to ' . $file_path);
        return "Failed to write custom heading CSS to " . $file_path;
    } else {
        error_log('Custom heading CSS written to ' . $file_path);
        return "success! Custom heading CSS written to " . $file_path;
    }
}


function dc24_generate_heading_css($headings)
{
    $css = '';

    foreach ($headings as $key => $styles) {
        $css .= "$key {\n";
        foreach ($styles as $property => $value) {
            $css .= "    {$property}: {$value};\n";
        }
        $css .= "}\n";
    }

    return $css;
}

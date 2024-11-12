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

    //Log for debug
    error_log($heading_update);
  
}
add_action('save_post', 'dc24_handle_global_styles_save', 10, 3);

function dc24_write_custom_colors_json($global_settings)
{
    $colors = $global_settings["color"]["palette"]["theme"];
    if(isset($global_settings["color"]["palette"]["custom"])){
        $colors_custom = $global_settings["color"]["palette"]["custom"];
    }else{
        $colors_custom = [];
    }
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
    // Define the path to the CSS file
    $file_path = get_template_directory() . '/css/heading.css';

    // Extract heading styles from global styles
    $heading_styles = $global_styles['elements'];
    // Log the global styles for debugging
    
    // Set default values for heading styles, checking the global styles for defaults
    $default_heading_styles = [
        "font-style" => $heading_styles['heading']['typography']['fontStyle'] ?? "normal",
        "font-weight" => $heading_styles['heading']['typography']['fontWeight'] ?? 400,
        "font-size" => $heading_styles['heading']['typography']['fontSize'] ?? "inherit",
        "font-family" => $heading_styles['heading']['typography']['fontFamily'] ?? "inherit",
        "line-height" => $heading_styles['heading']['typography']['lineHeight'] ?? "inherit"
    ];
    error_log(print_r($heading_styles["h4"], true));

    // Initialize an array to store the styles for each heading tag
    // Check if the heading has specific styles defined, otherwise use default
    $headings = [];

    foreach (['h1', 'h2', 'h3', 'h4', 'h5', 'h6'] as $heading_tag) {
        $headings[$heading_tag] = [
            "font-style" => $heading_styles[$heading_tag]["typography"]["fontStyle"] ?? $default_heading_styles["font-style"],
            "font-weight" => $heading_styles[$heading_tag]["typography"]["fontWeight"] ?? $default_heading_styles["font-weight"],
            "font-size" => $heading_styles[$heading_tag]["typography"]["fontSize"] ?? $default_heading_styles["font-size"],
            "font-family" => $heading_styles[$heading_tag]["typography"]["fontFamily"] ?? $default_heading_styles["font-family"],
            "line-height" => $heading_styles[$heading_tag]["typography"]["lineHeight"] ?? $default_heading_styles["line-height"]
        ];
    }

    // Generate the CSS from the heading styles
    $css = dc24_generate_heading_css($headings, $default_heading_styles);

    // Write the CSS content to the file
    if (file_put_contents($file_path, $css) === false) {
        error_log('Failed to write custom heading CSS to ' . $file_path);
        return "Failed to write custom heading CSS to " . $file_path;
    } else {
        error_log('Custom heading CSS written to ' . $file_path);
        return "Success! Custom heading CSS written to " . $file_path;
    }
}

function dc24_generate_heading_css($headings, $default_heading_styles)
{
    $css = '';

    // Add default heading styles to the CSS output
    $css .= "h1, h2, h3, h4, h5, h6 {\n";
    foreach ($default_heading_styles as $property => $value) {
        $css .= "    {$property}: {$value};\n";
    }
    $css .= "}\n\n";

    // Add specific heading styles (if any) to the CSS output
    foreach ($headings as $key => $styles) {
        $css .= "$key {\n";
        foreach ($styles as $property => $value) {
            $css .= "    {$property}: {$value};\n";
        }
        $css .= "}\n";
    }

    return $css;
}

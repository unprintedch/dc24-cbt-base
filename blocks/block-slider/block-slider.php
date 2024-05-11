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
// load all post form the calendrier category order by meta starting date

// $globale_styles = wp_remote_get("http://winbiz.local/wp-json/wp/v2/global-styles/themes/dc24-cbt-base");
// var_dump($globale_styles);


$global_settings = wp_get_global_settings();
$global_styles = wp_get_global_styles();


//var_dump($global_settings);
//var_dump($global_styles["elements"]);

// $dataArray = [
//     'name' => 'John Doe',
//     'email' => 'john.doe@example.com',
//     'age' => 30
// ];

// $filePath = 'data.json'; // Path where the JSON file will be saved

// // Call the function
// $result = createAndWriteJsonInTheme($dataArray, $filePath);
// echo $result; // Output the result

$newConfig = "      fontSize: {
    'h4': '1.25rem',  // for example, 20px
},";
$result = updateTailwindConfig($newConfig);
echo $result;



?>

<div <?php echo esc_attr($anchor); ?>class="<?php echo esc_attr($class_name); ?>">
    <?php if ($is_admin) : ?>
        <div class="admin-view-only flex items-center justify-center bg-slate-200 p-12 hover:bg-slate-300 transition-all">
            <!-- Content to be shown only in admin -->
            <h2>Slider hero content.</h2>
            
        </div>
    <?php
        return;
    endif; ?>

    <div class="flex justify-between px-6">
        <div class="top-0 right-0 flex gap-4 items-center ">
            <!-- <div class="dc23-slick-prev text-black "><i class="fa-regular fa-arrow-left-long"></i></div> -->
            <div class="dc23-slick-next text-black  "><i class="fa-regular fa-arrow-right-long"></i></div>
        </div>
    </div>
    <div class="">
        <div class="flex slider-post gap-12">
            <div> Slide </div>
            <div> Slide </div>
            <div> Slide </div>
            <div> Slide </div>
        </div>
    </div>

</div>
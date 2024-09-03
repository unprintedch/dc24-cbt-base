<?php


function display_popup_content()
{
    // Fetch popup posts
    $args = array(
        'post_type' => 'pop-up',
        'posts_per_page' => 1,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'start_date',
                'value' => date('Ymd'),
                'compare' => '<=',
                'type' => 'DATE'
            ),
            array(
                'key' => 'end_date',
                'value' => date('Ymd'),
                'compare' => '>=',
                'type' => 'DATE'
            )
        )
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        // setcookie('popupClosed', '', time() - 3600, '/'); // Set expiration date to one hour in the past
        // check for cookie to see if popup has been closed
        if (!isset($_COOKIE['popupClosed'])) {
            $cookie_class = '';
        } else {
            $cookie_class = 'hidden';
        }
        while ($query->have_posts()) {
            $query->the_post();
            $title = get_field("pop_title");
            $content = get_field("content");
            $button_title = get_field("button_title");
            // Popup content 
?>
            <div id="popup" class=" <?php echo  $cookie_class ?>  text-center fixed  inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                <div class="bg-white p-6 pt-0 rounded-lg w-[480px] relative">
                    <div class="flex justify-between items-center pt-4 border-b border-gray-100 mb-3">
                        <h5 class="text-secondary text-xs mt-0 mb-0"><i class="fa-sharp fa-solid fa-circle-exclamation mr-1"></i> <?php echo $button_title ?></h5> <button id="popup-close" class=""><i class="fa-sharp fa-solid fa-xmark"></i></button>
                    </div>
                    <h3 id="popup-title " class="mt-3 text-[24px]"><?php echo $title; ?></h3>
                    <div id="popup-content"><?php echo $content; ?></div>
                </div>
            </div>
            <?php
            // event indicator
            ?>
            <div id="infobox" class=" fixed w-full top-0 z-50 flex items-center justify-center flex-col drop-shadow-md">
                <div id="infobox-content" class="bg-white max-w-[600px]  rounded-b-lg overflow-hidden transition-all duration-800 ease-in-out max-h-0 ">
                    <div class="p-6">
                        <h3 id="infobox-title"class="mt-3 text-[24px]  text-center"><?php echo $title; ?></h3>
                        <div><?php echo $content; ?></div>
                    </div>
                </div>
                <div id="infobox_button" class="bg-white rounded-b-lg px-4 py-1 text-[10px] uppercase hover:cursor-pointer hover:text-secondary">
                    <i class="fa-sharp fa-solid fa-circle-exclamation mr-1"></i> <?php echo $button_title ?>
                </div>
            </div>
<?php
        }
        wp_reset_postdata();
    }
}
add_action('wp_footer', 'display_popup_content');

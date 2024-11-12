<?php

/**
 * Header Block template.
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

// Get the primary menu ID
$primary_menu_id = get_nav_menu_locations()['primary'] ?? null;
$primary_mobile_menu_id = get_nav_menu_locations()['primary_mobile'] ?? null;

// Navigation block configuration
$nav_block = '<!-- wp:navigation {
    "ref":' . $primary_menu_id . ',
    "overlayMenu":"mobile",
    "layout":{
        "type":"flex",
        "orientation":"horizontal",
        "justifyContent":"left"
    },
    "style":{
        "spacing":{
            "blockGap":"var:preset|spacing|40"
        }
    },
    "fontSize":"small"
} /-->';
// Navigation mobile block configuration
$nav_mobile_block = '<!-- wp:navigation {
    "ref":' . $primary_mobile_menu_id . ',
    "overlayMenu":"never",
    "layout":{
        "type":"flex",
        "orientation":"vertical",
        "justifyContent":"left"
    },
    "style":{
        "spacing":{
            "blockGap":"var:preset|spacing|40"
        }
    },
    "fontSize":"small"
} /-->';
?>

<?php if ($is_admin) : ?>
    <div class="admin-view-only flex items-center justify-center bg-slate-200 p-12 hover:bg-slate-300 transition-all">
        <h3>Custom header</h3>
    </div>
    <?php return; ?>
<?php endif; ?>

<div <?php echo esc_attr($anchor); ?> class="site-header bg-primary dc24-navigation alignfull top-0 h-36 px-6 <?php echo esc_attr($class_name); ?>">
    <div class="container mx-auto">
        <div class="flex justify-between items-center py-8">
            <!-- Site Logo/Title -->
            <div class="site-branding">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    echo '<h1 class="site-title"><a href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a></h1>';
                }
                ?>
            </div>

            <!-- Navigation -->
            <nav class="main-navigation hidden lg:block">
                <?php echo do_blocks($nav_block); ?>
            </nav>


            <div class="flex justify-start  relative z-50" aria-expanded="false" aria-controls="offcanvas">
                <div id="burger-icon" class="burger-menu justify-items-start">
                    <span class="bg-black"></span>
                    <span class="bg-black"></span>
                    <span class="bg-black"></span>
                </div>
            </div>
            <div id="overlay" class="fixed inset-0 z-30 hidden backdrop-blur-sm bg-white/30"></div>
            <div id="offcanvas" class="fixed z-40 w-[500px] h-full top-0 -right-[500px] bg-white flex  flex-col items-center justify-center p-8 pt-20 transition-all">
                <nav class="">
                    <?php echo do_blocks($nav_mobile_block); ?>
                </nav>
            </div>
        </div>
    </div>
</div>
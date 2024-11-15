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

$post_id = get_the_ID();
$is_admin = is_admin();

?>

<?php if ($is_admin) : ?>
    <div class="admin-view-only flex items-center justify-center bg-slate-200 p-12 hover:bg-slate-300 transition-all">
        <h3>Custom header</h3>
    </div>
    <?php return; ?>
<?php endif; ?>


<div id="menu-container" <?php echo esc_attr($anchor); ?> class="alignfull top-0  h-36 px-6 inset-0">
    <div class="flex justify-end md:baseline container pt-8 ">
       
        <div class="flex justify-start  relative z-50" aria-expanded="false" aria-controls="offcanvas">
            <div id="burger-icon" class="burger-menu justify-items-start">
                <span class="bg-black"></span>
                <span class="bg-black"></span>
                <span class="bg-black"></span>
            </div>
        </div>
        <div id="overlay" class="fixed inset-0 z-30 hidden backdrop-blur-sm bg-white/30"></div>
        <div id="offcanvas" class="fixed z-40 w-[500px] h-full top-0 -right-[500px] bg-white flex  flex-col items-center justify-center p-8 pt-20 transition-all">
            <?php wp_nav_menu(
                array(
                    'container_id'    => 'offcanvas-menu',
                    'container_class' => '',
                    'menu_class'      => 'gap-16 items-baseline flex flex-col',
                    'li_class'        => 'font-display uppercase  text-[45px] ',
                    'fallback_cb'     => false
                )
            ); ?>
        </div>
    </div>
</div>
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

// Récupérer le logo depuis les options ACF
$logo_id = get_field('logo_white', 'option');

// Récupérer les données de l'image si l'ID existe
$logo = null;
if ($logo_id) {
    $logo = wp_get_attachment_image_src($logo_id, 'full');
    $logo_alt = get_post_meta($logo_id, '_wp_attachment_image_alt', true);
}


?>

<?php if ($is_admin) : ?>
    <div class="admin-view-only flex items-center justify-center bg-slate-200 p-12 hover:bg-slate-300 transition-all">
        <h3>Custom header</h3>

    </div>
    <?php return; ?>
<?php endif; ?>

<div id="menu-container" <?php echo esc_attr($anchor); ?> class="max-h-20 alignfull  border-primary border-t-4 top-0  inset-0 pb-3  fixed z-50 transition-all duration-300 ease-in-out  header-sticky ">
    <div class="relative alignfull">
        <div class="flex justify-end items-start container pt-2 ">
            <!-- Logo -->
            <div class="absolute left-12 -top-[50px] flex items-end justify-center logo-container  rounded-full p-6 pt-6 pb-0 bg-primary h-[160px] w-[160px] transition-all duration-300 ease-in-out">
                <?php if ($logo) : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="block " aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
                        <img
                            src="<?php echo esc_url($logo[0]); ?>"
                            alt="<?php echo esc_attr($logo_alt ?: get_bloginfo('name')); ?>"
                            width="<?php echo esc_attr($logo[1]); ?>"
                            height="<?php echo esc_attr($logo[2]); ?>"
                            class=" mb-6 object-contain transition-all duration-300 ease-in-out logo-img"
                            loading="eager">
                    </a>
                <?php else : ?>
                    <!-- Fallback : nom du site -->
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="text-2xl font-bold text-primary hover:text-gray-700 transition-colors logo-text">
                        <?php echo esc_html(get_bloginfo('name')); ?>
                    </a>
                <?php endif; ?>
            </div>
            <div class="flex justify-end items-center gap-6">
                <div class=" ">
                    <?php wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'container_id' => 'primary-menu',
                            'container_class' => '',
                            'menu_class' => 'flex justify-end gap-6',
                            'li_class' => 'text-white text-xl font-bold rounded-full bg-primary p-3 px-8',
                            'fallback_cb' => false
                        )
                    ); ?>

                </div>


                <!-- Menu burger -->
                <div class="relative  flex justify-center items-center  z-50 bg-primary rounded-full w-12 h-12" aria-expanded="false" aria-controls="offcanvas">
                    <div id="burger-icon" class="burger-menu justify-items-start">
                        <span class="bg-white block"></span>
                        <span class="bg-white block"></span>
                        <span class="bg-white block"></span>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<!-- Overlay et menu offcanvas -->
<div id="overlay" class="fixed inset-0 z-30 hidden backdrop-blur-sm bg-white/30"></div>
<div id="offcanvas" class="fixed z-40 w-[500px] h-full top-0 -right-[500px]  bg-white flex flex-col  p-8 pt-64 transition-all drop-shadow-md bg-light-gray">
    <?php wp_nav_menu(
        array(
            'theme_location' => 'offcanvas',
            'container_id' => 'offcanvas-menu',
            'container_class' => '',
            'menu_class' => '',
            'li_class' => 'mb-6',
            'walker' => new DC24_Accordion_Menu_Walker(),
            'fallback_cb' => false
        )
    ); ?>
</div>
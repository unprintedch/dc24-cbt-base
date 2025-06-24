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
$logo_id = get_field('logo', 'option');

// Récupérer les données de l'image si l'ID existe
$logo = null;
if ($logo_id) {
    $logo = wp_get_attachment_image_src($logo_id, 'full');
    $logo_alt = get_post_meta($logo_id, '_wp_attachment_image_alt', true);
}

$topbar_text = get_field('header_topbar_text', 'options');
$topbar_phone = get_field('header_topbar_phone', 'options');
$topbar_email = get_field('header_topbar_email', 'options');

?>

<?php if ($is_admin) : ?>
    <div class="admin-view-only flex items-center justify-center bg-slate-200 p-12 hover:bg-slate-300 transition-all">
        <h3>Custom header</h3>

    </div>
    <?php return; ?>
<?php endif; ?>


<div id="menu-container" <?php echo esc_attr($anchor); ?> class="alignfull top-0 h-36 px-6 inset-0">
    <div class="alignfull">

        <div class="container bg-primary ">
            <div class="flex">

                <?php if ($topbar_text) : ?>
                    <div class="grid-x topbar-col align-middle">
                        <?php echo $topbar_text; ?>
                    </div>
                <?php endif; ?>

                <?php if ($topbar_phone) : ?>
                    <a href="tel:<?php echo $topbar_phone; ?>" class="grid-x topbar-col align-middle">
                        <i class="fas fa-phone"></i>
                        <?php echo $topbar_phone; ?>
                    </a>
                <?php endif; ?>

                <?php if ($topbar_email) : ?>
                    <a href="mailto:<?php echo $topbar_email; ?>" class="grid-x topbar-col align-middle">
                        <i class="fas fa-envelope"></i>
                        <?php echo $topbar_email; ?>
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </div>


    <div class="flex justify-between items-center container pt-8">


        <!-- Logo -->
        <div class="flex-shrink-0">
            <?php if ($logo) : ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="block " aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
                    <img
                        src="<?php echo esc_url($logo[0]); ?>"
                        alt="<?php echo esc_attr($logo_alt ?: get_bloginfo('name')); ?>"
                        width="<?php echo esc_attr($logo[1]); ?>"
                        height="<?php echo esc_attr($logo[2]); ?>"
                        class="h-24 w-auto max-w-[300px] object-contain"
                        loading="eager">
                </a>
            <?php else : ?>
                <!-- Fallback : nom du site -->
                <a href="<?php echo esc_url(home_url('/')); ?>" class="text-2xl font-bold text-primary hover:text-gray-700 transition-colors">
                    <?php echo esc_html(get_bloginfo('name')); ?>
                </a>
            <?php endif; ?>
        </div>

        <!-- Menu burger -->
        <div class="flex justify-end relative z-50" aria-expanded="false" aria-controls="offcanvas">
            <div id="burger-icon" class="burger-menu justify-items-start">
                <span class="bg-primary block"></span>
                <span class="bg-primary block"></span>
                <span class="bg-primary block"></span>
            </div>
        </div>

        <!-- Overlay et menu offcanvas -->
        <div id="overlay" class="fixed inset-0 z-30 hidden backdrop-blur-sm bg-white/30"></div>
        <div id="offcanvas" class="fixed z-40 w-[500px] h-full top-0 -right-[500px] bg-white flex flex-col items-center justify-center p-8 pt-20 transition-all">
            <?php wp_nav_menu(
                array(
                    'container_id'    => 'offcanvas-menu',
                    'container_class' => '',
                    'menu_class'      => 'gap-16 items-baseline flex flex-col',
                    'li_class'        => 'font-display uppercase text-[45px] ',
                    'fallback_cb'     => false
                )
            ); ?>
        </div>
    </div>
</div>
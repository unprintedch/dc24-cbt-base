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

$post_id = get_the_ID();
$classes = " ";

$is_admin = is_admin();

// $title = get_field("title", $block['id']);
// $subtitle = get_field("subtitle", $block['id']);
// $link = get_field("link", $block['id']);
// $slides = get_field("slides", $block['id']);



?>

<?php if ($is_admin) : ?>
    <div class="admin-view-only flex items-center justify-center bg-slate-200 p-12 hover:bg-slate-300 transition-all ">
        <!-- Content to be shown only in admin -->
        <h3>Custom header.</h3>
    </div>
<?php
    return;
endif; ?>


<div <?php echo esc_attr($anchor); ?> class="<?php echo $classes ?> bg-primary dc24-navigation  alignfull top-0 h-36 px-6 ">
    <div class="flex justify-between items-baseline container pt-8">
        <?php wp_nav_menu(
            array(
                'container_id'    => 'primary',
                'container_class' => 'font-normal  hidden lg:flex',
                'menu_class'      => 'menu dropdown  gap-16 items-baseline flex',
                'li_class'        => 'font-medium uppercase  uppercase text-[13px]',
                'fallback_cb'     => false
            )
        ); ?>


        <div class="lg:hidden flex justify-start ">
            <div class="burger-menu justify-items-start">
                <span class="bg-white"></span>
                <span class="bg-white"></span>
                <span class="bg-white"></span>
            </div>
        </div>
        <div class="">
            <div class="flex gap-6 items-start">
               
            </div>
        </div>
    </div>
</div>
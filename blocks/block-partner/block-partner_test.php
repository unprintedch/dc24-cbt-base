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
?>

<?php if ($is_admin) : ?>
    <div class="admin-view-only flex items-center justify-center bg-slate-200 p-12 hover:bg-slate-300 transition-all">
        <!-- Content to be shown only in admin -->
        <h2>Grille des partnaires.</h2>
    </div>
<?php
    return;
endif;

?>
<div class="px-12 flex">
    <div class="w-3/12 flex flex-col gap-6 dc24-filters p-6">
        <div class="flex gap-4">
            <?php //echo facetwp_display('facet', 'categories');  ?>
        </div>
        <div class="flex gap-4">
            <?php //echo facetwp_display('facet', 'tri'); 
            ?>
        </div>
    </div>
    <div class="w-9/12">
        <?php echo facetwp_display('facet', 'partner_map'); ?>
    </div>
</div>

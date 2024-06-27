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
        <h2>List content accordion.</h2>
    </div>
<?php
    return;
endif; ?>


<?php
// get the block id
$block_id = $block['id'];

$items = get_field("items", $block_id);

?>



<?php
// get the block id
$block_id = $block['id'];

// Check if the repeater field has rows
if (have_rows('items', $block_id)) {
    while (have_rows('items', $block_id)) {
        the_row();

        // Get sub-fields of the current row
        $title = get_sub_field('titre');
        $subtitle = get_sub_field('subtitle');
        $intro = get_sub_field('intro');

?>
        <details class="wp-block-details is-style-big-details is-layout-flow wp-block-details-is-layout-flow">
            <summary>
                <div>
                    <h5 class="font-semibold text-[35px]"><?php echo esc_html($title); ?></h5>
                    <p class="text-[#808080] text-[20px] font-semibold"><?php echo esc_html($subtitle); ?></p>
                </div>
            </summary>
            <p class="text-[15px] text-[#808080]"><?php echo $intro; ?></p>

            <div class="grid lg:grid-cols-3 gap-6">
                <?php
                // Check if nested repeater field 'lists' has rows
                if (have_rows('lists')) {
                    while (have_rows('lists')) {
                        the_row();
                        // Get sub-fields of the current list item
                        $list_title = get_sub_field('title_list');
                        $texte_liste = get_sub_field('texte_liste');
                ?>
                        <div class="pb-8">
                            <p class="font-semibold"><?php echo $list_title; ?></p>
                            <div class="is-list-small text-[12px]"><?php echo $texte_liste; ?></div>
                        </div>

                    <?php
                    } ?>
            </div>
        <?php } ?>
        </details>
<?php }
}
?>
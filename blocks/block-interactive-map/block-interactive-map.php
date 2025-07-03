<?php

/**
 * Plan Interactif Block template.
 *
 * @param array $block The block settings and attributes.
 */

declare(strict_types=1);

// Support custom "anchor" values.
$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'interactive-map-block';
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
        <h3>Plan Interactif</h3>
    </div>
    <?php return; ?>
<?php endif; ?>

<style>
    .interactive-map-block {}

    .interactive-map-block svg {
        width: 100%;
        height: auto;
        max-width: 100%;
    }

    /* Effet de hover sur les zones */
    .interactive-map-block svg g[data-name*="ZONE_"]:hover {
        cursor: pointer;
        transition: all 0.3s ease;
    }



    /* Animation d'échelle au hover */
    .interactive-map-block svg g[data-name*="ZONE_"]:hover {
        transform: scale(1.01);
        transform-origin: bottom left;
        transition: all 0.3s ease;
    }
</style>

    <div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?> alignfull flex justify-center">
        <div class="rounded-lg overflow-hidden">
            <?php 
            $svg_path = get_template_directory() . '/assets/images/GM_plan.svg';
            if (file_exists($svg_path)) {
                echo file_get_contents($svg_path);
            } else {
                echo '<p>SVG file not found</p>';
            }
            ?>
        </div>
    </div>
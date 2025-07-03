<?php

/**
 * Accordion Block template.
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
$class_name = 'accordion-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

$is_admin = is_admin();
$block_id = 'accordion-' . $block['id'];
$title = get_field('title');
$icon = get_field('icon');
$allow_multiple = get_field('allow_multiple');
?>

<?php if ($is_admin) : ?>
    <div class="admin-view-only flex items-center justify-center bg-slate-200 p-12 hover:bg-slate-300 transition-all">
        <h2>Accordion Block</h2>
    </div>
    <?php return; ?>
<?php endif; ?>

<style>
.accordion-block {
    margin: 2rem 0;
}

.accordion-block .accordion-toggle {
    width: 100%;
    padding: 1.5rem;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
    text-align: left;
}

.accordion-block .accordion-toggle:hover {
    background-color: #f9fafb;
}

.accordion-block .accordion-toggle[aria-expanded="true"] {
    border-color: var(--wp--preset--color--primary);
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}

.accordion-block .accordion-icon {
    flex-shrink: 0;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--wp--preset--color--primary);
    transition: transform 0.3s ease;
}

.accordion-block .accordion-toggle[aria-expanded="true"] .accordion-icon {
    transform: rotate(45deg);
}

.accordion-block .accordion-title {
    flex: 1;
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--wp--preset--color--primary);
}

.accordion-block .accordion-content {
    border: 1px solid #e5e7eb;
    border-top: none;
    border-bottom-left-radius: 0.5rem;
    border-bottom-right-radius: 0.5rem;
    background: white;
    padding: 1.5rem;
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>" id="<?php echo esc_attr($block_id); ?>" data-allow-multiple="<?php echo $allow_multiple ? 'true' : 'false'; ?>">
    <button class="accordion-toggle" aria-expanded="false">
        <?php if ($icon): ?>
            <span class="accordion-icon"><?php echo $icon; ?></span>
        <?php else: ?>
            <span class="accordion-icon">
                <svg width="20" height="20" viewBox="0 0 20 20">
                    <path d="M10 3L10 17M3 10L17 10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </span>
        <?php endif; ?>
        <span class="accordion-title"><?php echo esc_html($title); ?></span>
    </button>
    <div class="accordion-content" hidden>
        <?php echo $block['innerContent'][0] ?? ''; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const accordionBlocks = document.querySelectorAll('.accordion-block');
    
    accordionBlocks.forEach(function(accordionBlock) {
        const allowMultiple = accordionBlock.getAttribute('data-allow-multiple') === 'true';
        const toggle = accordionBlock.querySelector('.accordion-toggle');
        const content = accordionBlock.querySelector('.accordion-content');
        
        toggle.addEventListener('click', function() {
            const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
            
            if (!allowMultiple && !isExpanded) {
                // Fermer tous les autres accordions
                document.querySelectorAll('.accordion-block').forEach(function(otherBlock) {
                    if (otherBlock !== accordionBlock) {
                        const otherToggle = otherBlock.querySelector('.accordion-toggle');
                        const otherContent = otherBlock.querySelector('.accordion-content');
                        
                        otherToggle.setAttribute('aria-expanded', 'false');
                        otherContent.hidden = true;
                    }
                });
            }
            
            // Basculer l'état actuel
            if (isExpanded) {
                toggle.setAttribute('aria-expanded', 'false');
                content.hidden = true;
            } else {
                toggle.setAttribute('aria-expanded', 'true');
                content.hidden = false;
            }
        });
    });
});
</script>
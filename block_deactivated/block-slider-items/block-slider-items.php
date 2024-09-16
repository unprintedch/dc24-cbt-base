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

$slides = get_field("slides", $block['id']);



?>

<?php if ($is_admin) : ?>
    <div class="admin-view-only flex items-center justify-center bg-slate-200 p-12 hover:bg-slate-300 transition-all">
        <!-- Content to be shown only in admin -->
        <h2>Slider items content.</h2>
    </div>
<?php
    return;
endif; ?>


<div <?php echo esc_attr($anchor); ?> class="<?php echo esc_attr($class_name); ?> px-[3.38rem]  relative z-20 overflow-hidden">


    <!-- Slider main container -->
    <div class="swiper-items">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper  mb-12">
            <?php foreach ($slides as $slide) :
                $image_id = $slide["image"];
                $title = $slide["content"]["title"] ?? "";
                $subtitle_1 =   $slide["content"]["subtitle_1"] ?? "";
                $subtitle_2 =  $slide["content"]["subtitle_2"] ?? "";
                $link =  $slide["content"]["link"];
            ?>
                <div class="swiper-slide group">
                    <?php if (isset($link["url"])) : ?>
                        <a class="flex gap-4 py-6 no-underline" href="<?php echo $link["url"] ?>">
                        <?php else : ?> 
                            <div class="flex gap-4 py-6">
                            <?php endif; ?>
                            <div class=" w-32 h-32 relative overflow-hidden rounded-lg group-hover:scale-105 transition-all shadow-md ">
                                <img class="w-full h-full absolute top-0 left-0" src="<?php echo esc_url(wp_get_attachment_image_url($image_id, 'full')); ?>" alt="">
                            </div>
                            <div class="flex flex-col justify-between items-start">
                                <div>
                                    <h5 class="font-medium text-[25px]"><?php echo $title ?></h5>
                                    <p class=" text-gray-warm "><?php echo $subtitle_1 ?></p>
                                    <p class="text-primary text-md"><?php echo $subtitle_2 ?></p>
                                </div>
                                <?php if (isset($link["url"])) : ?>
                                    <div class="inline text-gray-warm rounded-lg bg-gray-light pt-[10px] pb-[6px] pr-4 pl-4 text-xs uppercase">
                                        <?php echo $link["title"] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if (isset($link["url"])) : ?>
                        </a>
                    <?php else : ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    </div>
    <!-- If we need navigation buttons -->
    <div class="flex relative w-[160px] items-center gap-3 pb-4 text-primary pt-6 bottom-6 left-7">
        <div class="dc24-swiper-button-prev-items flex items-center"><i class="fa-thin fa-chevron-left"></i></div>
        <div class="dc24-swiper-pagination-primary  relative "></div>
        <div class="dc24-swiper-button-next-items flex items-center"><i class="fa-thin fa-chevron-right"></i></div>
    </div>
</div>
<!-- If we need scrollbar -->

</div>
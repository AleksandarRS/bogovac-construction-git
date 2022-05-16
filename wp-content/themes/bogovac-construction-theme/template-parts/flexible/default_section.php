<?php
$section_background_color = get_sub_field('section_background_color');
$section_background_image = get_sub_field('section_background_image');

$section_main_title = get_sub_field('section_main_title');
$section_description = get_sub_field('section_description');
?>
<section class="_-section">
    <div class="_-section-wrapper section-wrapper relative"<?php if ( $section_background_color ) : ?> style="background-color:<?php echo $section_background_color; ?>"<?php endif; ?>>
        <?php  if ( $section_background_image ) : ?>
            <div class="_-section-background-image section-background-image" style="background-image: url(<?php echo esc_url($section_background_image['url']); ?>);" role="img" aria-label="<?php echo esc_attr($section_background_image['alt']); ?>"></div>
        <?php endif; ?>
        <div class="_-section-wrapper-inner">
            <div class="container">
                <div class="row _-row">
                    <?php if ( $section_main_title ) : ?>
                        <header class="entry-header main-header col-md-12">
                            <h1 class="main-title"><?php echo $section_main_title; ?></h1>
                        </header>
                    <?php endif; ?>
                    <?php  if ( $section_description ) : ?>
                        <div class="entry-content section-description col-md-12">
                            <?php echo $section_description; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

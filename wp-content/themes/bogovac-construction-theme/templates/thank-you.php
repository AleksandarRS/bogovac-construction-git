<?php
/**
 * Template Name: Thank you TPL
 */

get_header(); ?>
<?php
	$add_page_title = get_field('add_page_title');
	$add_page_text_description = get_field('add_page_text_description');
?>
  <div id="primary" class="content-area">
    <main id="main" class="site-main">
		<section class="thank-you-section">
			<div class="thank-you-section-wrapper section-wrapper relative">
				<div class="thank-you-section-wrapper-inner">
					<div class="container">
						<div class="row thank-you-row">
							<?php if ( $add_page_title ) : ?>
								<header class="entry-header main-header col-md-12">
									<i class="icon icon-check-ok"></i>
									<h3 class="main-title main-title-tpl-title"><?php echo $add_page_title; ?></h3>
								</header>
							<?php endif; ?>
							<?php  if ( $add_page_text_description ) : ?>
								<div class="entry-content section-description col-md-12">
									<?php echo $add_page_text_description; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</section>
    </main><!-- #main -->
  </div><!-- #primary -->
<?php
get_footer();

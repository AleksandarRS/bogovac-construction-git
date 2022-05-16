<?php
/**
 * Template Name: Forms TPL
 */

get_header(); ?>
<div class="container">
	<div class="row">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<section class="form-section">
					<?php while ( have_posts() ) : ?>

						<?php the_post(); ?>

						<?php get_template_part( 'template-parts/content', 'page-form' ); ?>

					<?php endwhile; // End of the loop. ?>
				</section>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- .row -->
</div><!-- .container -->
<?php
get_footer();

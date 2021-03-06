<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package bogovac
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<!-- <header class="entry-header"> -->
		<?php // the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	<!-- </header> --> <!-- .entry-header -->

	<div class="entry-content entry-content-page">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bogovac' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content entry-content-page -->

	<footer class="entry-footer">
		<?php edit_post_link( esc_html__( 'Edit', 'bogovac' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->


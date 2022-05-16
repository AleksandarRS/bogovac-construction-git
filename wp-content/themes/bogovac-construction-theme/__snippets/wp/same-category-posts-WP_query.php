<?php 
/**
 * Display posts of a same category on a single page. 
 * DON'T forget to change $post_type na $taxonomy.
 *
 * @return void
 */

$custom_taxterms = wp_get_object_terms( 
	$post->ID, 
	'property-category', 
	array( 'fields' => 'ids' ) 
);
$args = array(
	'post_type'      => 'property',
	'post_status'    => 'publish',
	'posts_per_page' => 3,
	'orderby'        => 'rand',
	'order'          => 'ASC',
	'tax_query'      => array( array(
		'taxonomy' => 'property-category',
		'field'    => 'id',
		'terms'    => $custom_taxterms
	)),
	'post__not_in'   => array( $post->ID ),
);

$related_items = new WP_Query( $args );

if ( $related_items->have_posts() ) :
	echo '<ul>';
	while ( $related_items->have_posts() ) : $related_items->the_post();
	?>
		<?php get_template_part('template-parts/content', 'property') ?>
	<?php
	endwhile;
	echo '</ul>';
endif;

wp_reset_postdata();
?>
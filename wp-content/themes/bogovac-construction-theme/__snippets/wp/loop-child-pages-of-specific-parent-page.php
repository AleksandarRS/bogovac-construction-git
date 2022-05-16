<?php
    $args = array(
        'post_type'      => 'page', //write slug of post type
        'posts_per_page' => -1,
        'post_parent'    => '16', //place here id of your parent page
        'order'          => 'ASC',
        'orderby'        => 'menu_order'
    );
    $childrens = new WP_Query( $args );
    if ( $childrens->have_posts() ) : ?>
        <?php while ( $childrens->have_posts() ) : $childrens->the_post(); ?>
            <div class="children" id="child-<?php the_ID(); ?>">
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <p><?php the_content(); ?></p>
            </div>
        <?php endwhile;
    endif;
    wp_reset_query();
?>
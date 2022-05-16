<?php   
    //WP PAGE
    //////////////////////////////
    // Get terms for post
    $terms = get_the_terms( $post->ID , 'case-study-category' );
    // Loop over each item since it's an array
    if ( $terms != null ){
    foreach( $terms as $term ) { ?>
    <a href="<?php echo get_category_link($term->term_id); ?>"><span class="term-name"><?php print $term->name ; ?></span></a>
    <?php unset($term);
} } ?>

<?php
    //index post page
    //////////////////////////////
    $categories = get_the_category();
    foreach($categories as $category) {
        if ( ! empty( $categories ) ) {
            echo '<span class="term-name"><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></span>';
        }
    }
?>
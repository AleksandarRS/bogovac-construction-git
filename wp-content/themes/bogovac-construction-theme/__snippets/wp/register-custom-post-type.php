<?php

function bogovac_register_post_type() {
    $singular = 'Custom post type name'; // Book
	$plural = 'Custom post type names';  // Books
	
    $slug = str_replace( ' ', '-', strtolower( $singular ) );

    $labels = array(
        'name' 			      => __( $plural, 'bogovac' ),
        'singular_name' 	  => __( $singular, 'bogovac' ),
        'add_new' 		      => _x( 'Add New', 'bogovac', 'bogovac' ),
        'add_new_item'  	  => __( 'Add New ' . $singular, 'bogovac' ),
        'edit'		          => __( 'Edit', 'bogovac' ),
        'edit_item'	          => __( 'Edit ' . $singular, 'bogovac' ),
        'new_item'	          => __( 'New ' . $singular, 'bogovac' ),
        'view' 			      => __( 'View ' . $singular, 'bogovac' ),
        'view_item' 		  => __( 'View ' . $singular, 'bogovac' ),
        'search_term'   	  => __( 'Search ' . $plural, 'bogovac' ),
        'parent' 		      => __( 'Parent ' . $singular, 'bogovac' ),
        'not_found'           => __( 'No ' . $plural .' found', 'bogovac' ),
        'not_found_in_trash'  => __( 'No ' . $plural .' in Trash', 'bogovac' ),
    );

    $args = array(
        'labels'              => $labels,
        'hierarchical'        => false,
        'public'              => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'has_archive'         => true,
        'rewrite'             => array('slug' => $slug),
        'menu_icon'           => '',
        'supports'            => array( 'title', 'thumbnail', 'editor' )
    );

    register_post_type( $slug, $args );
}

add_action( 'init', 'bogovac_register_post_type' );
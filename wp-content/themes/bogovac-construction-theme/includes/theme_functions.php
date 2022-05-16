<?php 
// Disables the block editor from managing widgets in the Gutenberg plugin.
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false', 100 );

// Disables the block editor from managing widgets. renamed from wp_use_widgets_block_editor
add_filter( 'use_widgets_block_editor', '__return_false' );

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Options',
		'menu_title'	=> 'Theme Options',
		'menu_slug' 	=> 'theme-general-options',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
}

?>
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

// creaate formidable entry before user submits form
function create_entry_before_submit(){

	$entry_data = ( isset($_POST['entry']) )? $_POST['entry']:false;
	$form_id = ( isset($_POST['form_id']) )? $_POST['form_id']:false;

	if( $entry_data ):

		// prepare data
		$formated_data = array();

		foreach( $entry_data as $key_item => $entry_data_item ):

			$item_id = $item_id_old = $item_value = false;

			foreach( $entry_data_item as $key_subitem => $entry_data_subitem ):

				if( isset($entry_data_subitem['name']) ):

					$name_arr = explode('[',$entry_data_subitem['name']);
					$name_arr_count = count($name_arr);

					$item_id = ( isset($name_arr[1]) )? rtrim($name_arr[1], ']'):false;

					if( $name_arr_count == 3 ):

						$item_value_separator = ( $item_id_old == $item_id )? ', ':'';
						$item_value .= ( isset($entry_data_subitem['value']) )? $item_value_separator.$entry_data_subitem['value']:false;
						
					else:
						$item_value = ( isset($entry_data_subitem['value']) )? $entry_data_subitem['value']:false;
					endif;

					$formated_data[$item_id] = $item_value;
					$item_id_old = $item_id;
					
				endif;
			
			endforeach;
			
		endforeach;

		$entry_id = ( isset($_COOKIE['sell_form_entry_id']) && $_COOKIE['sell_form_entry_id'] )? $_COOKIE['sell_form_entry_id']:false;

		// update entry
		if( $entry_id ):

			foreach( $formated_data as $key => $formated_data_item ):
					
				$field_id = $key;
				$field_value = $formated_data_item;

				$added = FrmEntryMeta::add_entry_meta( $entry_id, $field_id, null, $field_value );

				if( !$added ):
					FrmEntryMeta::update_entry_meta( $entry_id, $field_id, null, $field_value );
				endif;

			endforeach;

		// create entry
		else:

			$entry_id = FrmEntry::create(array(
				'form_id' => $form_id,
				'item_key' => 'entry',
				'item_meta' => $formated_data,
			));
		
			if( $entry_id ):
				setcookie('sell_form_entry_id', $entry_id, time()+1800, '/');
			endif;

		endif;

	endif;

    die();
}

add_action('wp_ajax_create_entry_before_submit', 'create_entry_before_submit');
add_action('wp_ajax_nopriv_create_entry_before_submit', 'create_entry_before_submit');

function sell_form_after_create_entry($entry_id, $form_id){
	$entry_id_custom = ( isset($_COOKIE['sell_form_entry_id']) && $_COOKIE['sell_form_entry_id'] )? $_COOKIE['sell_form_entry_id']:false;

	if( $entry_id_custom ):
		FrmEntry::destroy( $entry_id_custom );
		unset($_COOKIE['sell_form_entry_id']);
		setcookie('sell_form_entry_id', null, time()-3600, '/');
	endif;
}

add_action('frm_after_create_entry', 'sell_form_after_create_entry', 30, 2);
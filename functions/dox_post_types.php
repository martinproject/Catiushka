<?php

/* Post Type Actions */
add_action('init', 'dox_post_type_auto');


/* Auto Post Type*/
function dox_post_type_auto() {

	global $dox_options;
	
	$auto_args = array(
		'public' => true,
		'capability_type' => 'post',
		'query_var' => $dox_options['ad_set']['type']['base'],
		'menu_position' => 5,

		'rewrite' => array(
			'slug' => $dox_options['ad_set']['type']['base'],
			'with_front' => false,
		),

		'supports' => array(
			'title',
			'editor',
			'author',
			'thumbnail',
			'custom-fields'
		),
		
		'labels' => array(
			'name' => sprintf( __('%ss', 'autotrader'), $dox_options['ad_set']['type']['name'] ),
			'singular_name' => sprintf( __('%ss', 'autotrader'), $dox_options['ad_set']['type']['name'] ),
			'add_new' => sprintf( __('Add New %s', 'autotrader'), $dox_options['ad_set']['type']['name'] ),
			'add_new_item' => sprintf( __('Add New %s', 'autotrader'), $dox_options['ad_set']['type']['name'] ),
			'edit_item' => sprintf( __('Edit %s', 'autotrader'), $dox_options['ad_set']['type']['name'] ),
			'view_item' => sprintf( __('View %s', 'autotrader'), $dox_options['ad_set']['type']['name'] ),
			'search_items' => sprintf( __('Search %s', 'autotrader'), $dox_options['ad_set']['type']['name'] ),
			'not_found' => sprintf( __('No %s Found', 'autotrader'), $dox_options['ad_set']['type']['name'] ),
			'not_found_in_trash' => sprintf( __('No %s Found In Trash', 'autotrader'), $dox_options['ad_set']['type']['name'] ),			
		),
			
		'taxonomies' => array( 
			$dox_options['ad_set']['location']['query'],
			$dox_options['ad_set']['model']['query'],
			$dox_options['ad_set']['year']['query'],
			$dox_options['ad_set']['color']['query'],
			$dox_options['ad_set']['fuelType']['query'],
			$dox_options['ad_set']['bodyType']['query'],
			$dox_options['ad_set']['features']['query'],
			$dox_options['ad_set']['transmission']['query'],
			$dox_options['ad_set']['condition']['query']
		),
			
	);
	
	if ($dox_options['ad_set']['type']['base'] != '') {

		/* Registering post type */
		register_post_type( $dox_options['ad_set']['type']['base'], $auto_args );
		flush_rewrite_rules();
	}
}

?>
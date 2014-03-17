<?php

/* Taxonomy Actions */
add_action( 'init', 'dox_tax_location' );
add_action( 'init', 'dox_tax_make_model' );
add_action( 'init', 'dox_tax_year' );
add_action( 'init', 'dox_tax_colour' );
add_action( 'init', 'dox_tax_fuel_type' );
add_action( 'init', 'dox_tax_body_type' );
add_action( 'init', 'dox_tax_features' );
add_action( 'init', 'dox_tax_transmission' );
add_action( 'init', 'dox_tax_condition' );

/* Location */
function dox_tax_location() {

	global $dox_options;
	
	/* Taxonomy arguments. */
	$location_args = array(
		'hierarchical' => true,
		'query_var' => $dox_options['ad_set']['location']['query'],
		'show_tagcloud' => true,
		
		'rewrite' => array(
			'slug' => $dox_options['ad_set']['location']['slug'],
			'with_front' => false
		),
			
		'labels' => array(
			'name' => sprintf( __('%ss', 'autotrader'), $dox_options['ad_set']['location']['name'] ),
			'singular_name' => sprintf( __('%ss', 'autotrader'), $dox_options['ad_set']['location']['name'] ),
			'edit_item' => sprintf( __('Edit %s', 'autotrader'), $dox_options['ad_set']['location']['name'] ),
			'update_item' => sprintf( __('Update %s', 'autotrader'), $dox_options['ad_set']['location']['name'] ),
			'add_new_item' => sprintf( __('Add New %s', 'autotrader'), $dox_options['ad_set']['location']['name'] ),
			'new_item_name' => sprintf( __('New %s', 'autotrader'), $dox_options['ad_set']['location']['name'] ),
			'all_items' => sprintf( __('All %s', 'autotrader'), $dox_options['ad_set']['location']['name'] ),
			'search_items' => sprintf( __('Search %s', 'autotrader'), $dox_options['ad_set']['location']['name'] ),
			'popular_items' => sprintf( __('Popular %ss', 'autotrader'), $dox_options['ad_set']['location']['name'] ),
			'parent_item' => sprintf( __('Parent %s', 'autotrader'), $dox_options['ad_set']['location']['name'] ),
			'parent_item_colon' => sprintf( __('Parent %s', 'autotrader'), $dox_options['ad_set']['location']['name'] ),		
		),
	);
	
	/* Registering taxonomy */
	if ( $dox_options['ad_set']['location']['base'] != '' && $dox_options['ad_set']['location']['show'] == 'true' ) {
		register_taxonomy( $dox_options['ad_set']['location']['query'], array( $dox_options['ad_set']['location']['query'] ), $location_args );
	}
	
}	

/* Style/Make/Model */
function dox_tax_make_model() {

	global $dox_options;
	
	/* Taxonomy arguments. */
	$make_model_args = array(
		'hierarchical' => true,
		'query_var' => $dox_options['ad_set']['model']['query'],
		'show_tagcloud' => true,
		
		'rewrite' => array(
			'slug' => $dox_options['ad_set']['model']['slug'],
			'with_front' => false
		),
			
		'labels' => array(
			'name' => sprintf( __('%ss', 'autotrader'), $dox_options['ad_set']['model']['name'] ),
			'singular_name' => sprintf( __('%ss', 'autotrader'), $dox_options['ad_set']['model']['name'] ),
			'edit_item' => sprintf( __('Edit %s', 'autotrader'), $dox_options['ad_set']['model']['name'] ),
			'update_item' => sprintf( __('Update %s', 'autotrader'), $dox_options['ad_set']['model']['name'] ),
			'add_new_item' => sprintf( __('Add New %s', 'autotrader'), $dox_options['ad_set']['model']['name'] ),
			'new_item_name' => sprintf( __('New %s', 'autotrader'), $dox_options['ad_set']['model']['name'] ),
			'all_items' => sprintf( __('All %s', 'autotrader'), $dox_options['ad_set']['model']['name'] ),
			'search_items' => sprintf( __('Search %s', 'autotrader'), $dox_options['ad_set']['model']['name'] ),
			'popular_items' => sprintf( __('Popular %ss', 'autotrader'), $dox_options['ad_set']['model']['name'] ),
			'parent_item' => sprintf( __('Parent %s', 'autotrader'), $dox_options['ad_set']['model']['name'] ),
			'parent_item_colon' => sprintf( __('Parent %s', 'autotrader'), $dox_options['ad_set']['model']['name'] ),	
		),
	);
	
	/* Registering taxonomy */
	if ( $dox_options['ad_set']['model']['base'] != '' && $dox_options['ad_set']['model']['show'] == 'true' ) {
		register_taxonomy( $dox_options['ad_set']['model']['query'], array( $dox_options['ad_set']['model']['query'] ), $make_model_args );	
	}
	
}	

/* Years */
function dox_tax_year() {

	global $dox_options;
	
	/* Taxonomy arguments. */
	$year_args = array(
		'hierarchical' => true,
		'query_var' => $dox_options['ad_set']['year']['query'],
		'show_tagcloud' => true,
		
		'rewrite' => array(
			'slug' => $dox_options['ad_set']['year']['slug'],
			'with_front' => false
		),
			
		'labels' => array(
			'name' => sprintf( __('%ss', 'autotrader'), $dox_options['ad_set']['year']['name'] ),
			'singular_name' => sprintf( __('%ss', 'autotrader'), $dox_options['ad_set']['year']['name'] ),
			'edit_item' => sprintf( __('Edit %s', 'autotrader'), $dox_options['ad_set']['year']['name'] ),
			'update_item' => sprintf( __('Update %s', 'autotrader'), $dox_options['ad_set']['year']['name'] ),
			'add_new_item' => sprintf( __('Add New %s', 'autotrader'), $dox_options['ad_set']['year']['name'] ),
			'new_item_name' => sprintf( __('New %s', 'autotrader'), $dox_options['ad_set']['year']['name'] ),
			'all_items' => sprintf( __('All %s', 'autotrader'), $dox_options['ad_set']['year']['name'] ),
			'search_items' => sprintf( __('Search %s', 'autotrader'), $dox_options['ad_set']['year']['name'] ),
			'popular_items' => sprintf( __('Popular %ss', 'autotrader'), $dox_options['ad_set']['year']['name'] ),
			'parent_item' => sprintf( __('Parent %s', 'autotrader'), $dox_options['ad_set']['year']['name'] ),
			'parent_item_colon' => sprintf( __('Parent %s', 'autotrader'), $dox_options['ad_set']['year']['name'] ),	
		),
	);
	
	/* Registering taxonomy */
	if ( $dox_options['ad_set']['year']['base'] != '' && $dox_options['ad_set']['year']['show'] == 'true' ) {
		register_taxonomy( $dox_options['ad_set']['year']['query'], array( $dox_options['ad_set']['year']['query'] ), $year_args );	
	}
	
}

/* Colours */
function dox_tax_colour() {

	global $dox_options;
	
	/* Taxonomy arguments. */
	$colour_args = array(
		'hierarchical' => true,
		'query_var' => $dox_options['ad_set']['color']['query'],
		'show_tagcloud' => true,
		
		'rewrite' => array(
			'slug' => $dox_options['ad_set']['color']['slug'],
			'with_front' => false
		),
			
		'labels' => array(
			'name' => sprintf( __('%ss', 'autotrader'), $dox_options['ad_set']['color']['name'] ),
			'singular_name' => sprintf( __('%ss', 'autotrader'), $dox_options['ad_set']['color']['name'] ),
			'edit_item' => sprintf( __('Edit %s', 'autotrader'), $dox_options['ad_set']['color']['name'] ),
			'update_item' => sprintf( __('Update %s', 'autotrader'), $dox_options['ad_set']['color']['name'] ),
			'add_new_item' => sprintf( __('Add New %s', 'autotrader'), $dox_options['ad_set']['color']['name'] ),
			'new_item_name' => sprintf( __('New %s', 'autotrader'), $dox_options['ad_set']['color']['name'] ),
			'all_items' => sprintf( __('All %s', 'autotrader'), $dox_options['ad_set']['color']['name'] ),
			'search_items' => sprintf( __('Search %s', 'autotrader'), $dox_options['ad_set']['color']['name'] ),
			'popular_items' => sprintf( __('Popular %ss', 'autotrader'), $dox_options['ad_set']['color']['name'] ),
			'parent_item' => sprintf( __('Parent %s', 'autotrader'), $dox_options['ad_set']['color']['name'] ),
			'parent_item_colon' => sprintf( __('Parent %s', 'autotrader'), $dox_options['ad_set']['color']['name'] ),	
		),
	);
	
	/* Registering taxonomy */
	if ( $dox_options['ad_set']['color']['base'] != '' && $dox_options['ad_set']['color']['show'] == 'true' ) {
		register_taxonomy( $dox_options['ad_set']['color']['query'], array( $dox_options['ad_set']['color']['query'] ), $colour_args );	
	}
	
}

/* Fuel Type */
function dox_tax_fuel_type() {

	global $dox_options;

	/* Taxonomy arguments. */
	$fuel_type_args = array(
		'hierarchical' => true,
		'query_var' => $dox_options['ad_set']['fuelType']['query'],
		'show_tagcloud' => true,
		
		'rewrite' => array(
			'slug' => $dox_options['ad_set']['fuelType']['slug'],
			'with_front' => false
		),
			
		'labels' => array(
			'name' => sprintf( __('%ss', 'autotrader'), $dox_options['ad_set']['fuelType']['name'] ),
			'singular_name' => sprintf( __('%ss', 'autotrader'), $dox_options['ad_set']['fuelType']['name'] ),
			'edit_item' => sprintf( __('Edit %s', 'autotrader'), $dox_options['ad_set']['fuelType']['name'] ),
			'update_item' => sprintf( __('Update %s', 'autotrader'), $dox_options['ad_set']['fuelType']['name'] ),
			'add_new_item' => sprintf( __('Add New %s', 'autotrader'), $dox_options['ad_set']['fuelType']['name'] ),
			'new_item_name' => sprintf( __('New %s', 'autotrader'), $dox_options['ad_set']['fuelType']['name'] ),
			'all_items' => sprintf( __('All %s', 'autotrader'), $dox_options['ad_set']['fuelType']['name'] ),
			'search_items' => sprintf( __('Search %s', 'autotrader'), $dox_options['ad_set']['fuelType']['name'] ),
			'popular_items' => sprintf( __('Popular %ss', 'autotrader'), $dox_options['ad_set']['fuelType']['name'] ),
			'parent_item' => sprintf( __('Parent %s', 'autotrader'), $dox_options['ad_set']['fuelType']['name'] ),
			'parent_item_colon' => sprintf( __('Parent %s', 'autotrader'), $dox_options['ad_set']['fuelType']['name'] ),		
		),
	);
	
	/* Registering taxonomy */
	if ( $dox_options['ad_set']['fuelType']['base'] != '' && $dox_options['ad_set']['fuelType']['show'] == 'true' ) {
		register_taxonomy( $dox_options['ad_set']['fuelType']['query'], array( $dox_options['ad_set']['fuelType']['query'] ), $fuel_type_args );	
	}
	
}

/* Body Type */
function dox_tax_body_type() {

	global $dox_options;
	
	/* Taxonomy arguments. */
	$body_type_args = array(
		'hierarchical' => true,
		'query_var' => $dox_options['ad_set']['bodyType']['query'],
		'show_tagcloud' => true,
		
		'rewrite' => array(
			'slug' => $dox_options['ad_set']['bodyType']['slug'],
			'with_front' => false
		),
			
		'labels' => array(
			'name' => sprintf( __('%ss', 'autotrader'), $dox_options['ad_set']['bodyType']['name'] ),
			'singular_name' => sprintf( __('%ss', 'autotrader'), $dox_options['ad_set']['bodyType']['name'] ),
			'edit_item' => sprintf( __('Edit %s', 'autotrader'), $dox_options['ad_set']['bodyType']['name'] ),
			'update_item' => sprintf( __('Update %s', 'autotrader'), $dox_options['ad_set']['bodyType']['name'] ),
			'add_new_item' => sprintf( __('Add New %s', 'autotrader'), $dox_options['ad_set']['bodyType']['name'] ),
			'new_item_name' => sprintf( __('New %s', 'autotrader'), $dox_options['ad_set']['bodyType']['name'] ),
			'all_items' => sprintf( __('All %s', 'autotrader'), $dox_options['ad_set']['bodyType']['name'] ),
			'search_items' => sprintf( __('Search %s', 'autotrader'), $dox_options['ad_set']['bodyType']['name'] ),
			'popular_items' => sprintf( __('Popular %ss', 'autotrader'), $dox_options['ad_set']['bodyType']['name'] ),
			'parent_item' => sprintf( __('Parent %s', 'autotrader'), $dox_options['ad_set']['bodyType']['name'] ),
			'parent_item_colon' => sprintf( __('Parent %s', 'autotrader'), $dox_options['ad_set']['bodyType']['name'] ),	
		),
	);
	
	/* Registering taxonomy */
	if ( $dox_options['ad_set']['bodyType']['base'] != '' && $dox_options['ad_set']['bodyType']['show'] == 'true' ) {
		register_taxonomy( $dox_options['ad_set']['bodyType']['query'], array( $dox_options['ad_set']['bodyType']['query'] ), $body_type_args );	
	}
	
}

/* Features */
function dox_tax_features() {

	global $dox_options;
	
	/* Taxonomy arguments. */
	$features_args = array(
		'hierarchical' => true,
		'query_var' => $dox_options['ad_set']['features']['query'],
		'show_tagcloud' => true,
		
		'rewrite' => array(
			'slug' => $dox_options['ad_set']['features']['slug'],
			'with_front' => false
		),
			
		'labels' => array(
			'name' => sprintf( __('%ss', 'autotrader'), $dox_options['ad_set']['features']['name'] ),
			'singular_name' => sprintf( __('%ss', 'autotrader'), $dox_options['ad_set']['features']['name'] ),
			'edit_item' => sprintf( __('Edit %s', 'autotrader'), $dox_options['ad_set']['features']['name'] ),
			'update_item' => sprintf( __('Update %s', 'autotrader'), $dox_options['ad_set']['features']['name'] ),
			'add_new_item' => sprintf( __('Add New %s', 'autotrader'), $dox_options['ad_set']['features']['name'] ),
			'new_item_name' => sprintf( __('New %s', 'autotrader'), $dox_options['ad_set']['features']['name'] ),
			'all_items' => sprintf( __('All %s', 'autotrader'), $dox_options['ad_set']['features']['name'] ),
			'search_items' => sprintf( __('Search %s', 'autotrader'), $dox_options['ad_set']['features']['name'] ),
			'popular_items' => sprintf( __('Popular %ss', 'autotrader'), $dox_options['ad_set']['features']['name'] ),
			'parent_item' => sprintf( __('Parent %s', 'autotrader'), $dox_options['ad_set']['features']['name'] ),
			'parent_item_colon' => sprintf( __('Parent %s', 'autotrader'), $dox_options['ad_set']['features']['name'] ),	
		),
	);
	
	/* Registering taxonomy */
	if ( $dox_options['ad_set']['features']['base'] != '' && $dox_options['ad_set']['features']['show'] == 'true' ) {
		register_taxonomy( $dox_options['ad_set']['features']['query'], array( $dox_options['ad_set']['features']['query'] ), $features_args );	
	}
	
}

/* Transmissions */
function dox_tax_transmission() {

	global $dox_options;
	
	/* Taxonomy arguments. */
	$transmission_args = array(
		'hierarchical' => true,
		'query_var' => $dox_options['ad_set']['transmission']['query'],
		'show_tagcloud' => true,
		
		'rewrite' => array(
			'slug' => $dox_options['ad_set']['transmission']['slug'],
			'with_front' => false
		),
			
		'labels' => array(
			'name' => sprintf( __('%ss', 'autotrader'), $dox_options['ad_set']['transmission']['name'] ),
			'singular_name' => sprintf( __('%ss', 'autotrader'), $dox_options['ad_set']['transmission']['name'] ),
			'edit_item' => sprintf( __('Edit %s', 'autotrader'), $dox_options['ad_set']['transmission']['name'] ),
			'update_item' => sprintf( __('Update %s', 'autotrader'), $dox_options['ad_set']['transmission']['name'] ),
			'add_new_item' => sprintf( __('Add New %s', 'autotrader'), $dox_options['ad_set']['transmission']['name'] ),
			'new_item_name' => sprintf( __('New %s', 'autotrader'), $dox_options['ad_set']['transmission']['name'] ),
			'all_items' => sprintf( __('All %s', 'autotrader'), $dox_options['ad_set']['transmission']['name'] ),
			'search_items' => sprintf( __('Search %s', 'autotrader'), $dox_options['ad_set']['transmission']['name'] ),
			'popular_items' => sprintf( __('Popular %ss', 'autotrader'), $dox_options['ad_set']['transmission']['name'] ),
			'parent_item' => sprintf( __('Parent %s', 'autotrader'), $dox_options['ad_set']['transmission']['name'] ),
			'parent_item_colon' => sprintf( __('Parent %s', 'autotrader'), $dox_options['ad_set']['transmission']['name'] ),	
		),
	);
	
	/* Registering taxonomy */
	if ( $dox_options['ad_set']['transmission']['base'] != '' && $dox_options['ad_set']['transmission']['show'] == 'true' ) {
		register_taxonomy( $dox_options['ad_set']['transmission']['query'], array( $dox_options['ad_set']['transmission']['query'] ), $transmission_args );	
	}
}

/* Conditions */
function dox_tax_condition() {

	/*
	*	Conditions: New Car, Used Car, Rental Car, Featured
	*/
	
	global $dox_options;
	
	/* Taxonomy arguments. */
	$condition_args = array(
		'hierarchical' => true,
		'query_var' => $dox_options['ad_set']['condition']['query'],
		'show_tagcloud' => true,
		
		'rewrite' => array(
			'slug' => $dox_options['ad_set']['condition']['slug'],
			'with_front' => false
		),
			
		'labels' => array(
			'name' => sprintf( __('%ss', 'autotrader'), $dox_options['ad_set']['condition']['name'] ),
			'singular_name' => sprintf( __('%ss', 'autotrader'), $dox_options['ad_set']['condition']['name'] ),
			'edit_item' => sprintf( __('Edit %s', 'autotrader'), $dox_options['ad_set']['condition']['name'] ),
			'update_item' => sprintf( __('Update %s', 'autotrader'), $dox_options['ad_set']['condition']['name'] ),
			'add_new_item' => sprintf( __('Add New %s', 'autotrader'), $dox_options['ad_set']['condition']['name'] ),
			'new_item_name' => sprintf( __('New %s', 'autotrader'), $dox_options['ad_set']['condition']['name'] ),
			'all_items' => sprintf( __('All %s', 'autotrader'), $dox_options['ad_set']['condition']['name'] ),
			'search_items' => sprintf( __('Search %s', 'autotrader'), $dox_options['ad_set']['condition']['name'] ),
			'popular_items' => sprintf( __('Popular %ss', 'autotrader'), $dox_options['ad_set']['condition']['name'] ),
			'parent_item' => sprintf( __('Parent %s', 'autotrader'), $dox_options['ad_set']['condition']['name'] ),
			'parent_item_colon' => sprintf( __('Parent %s', 'autotrader'), $dox_options['ad_set']['condition']['name'] ),	
		),
	);
	
	/* Registering taxonomy */
	if ( $dox_options['ad_set']['condition']['base'] != '' && $dox_options['ad_set']['condition']['show'] == 'true' ) {
		register_taxonomy( $dox_options['ad_set']['condition']['query'], array( $dox_options['ad_set']['condition']['query'] ), $condition_args );	
	}
}

?>
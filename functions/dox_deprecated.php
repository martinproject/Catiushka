<?php
/**
 * This function is using for deprecated functions
 * and backward compatibilities
 */
 
 add_action( 'init', 'dox_x_featured_ad_option' );
 
 function dox_x_featured_ad_option()
 {
	global $wpdb;
	
	$query = "SELECT p.post_id AS PID, p.meta_key as MKEY, p.meta_value as MVALUE FROM $wpdb->postmeta AS p
				WHERE meta_key = 'auto_featured'";
	
	$post_meta = $wpdb->get_results($query);

	if ( ! $post_meta ) $post_meta = array();
	
	foreach($post_meta as $meta) {
		$status = false;
		$status = add_post_meta($meta->PID, 'featured_ad', $meta->MVALUE, true);
		if ($status == true) delete_post_meta($meta->PID, $meta->MKEY);
	}
 }


?>
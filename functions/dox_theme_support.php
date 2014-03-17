<?php
/**
 * 
 */
 
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'automatic-feed-links' );
	
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'full', 620, 0, true );
	add_image_size( 'blog', 620, 240, true );	
	add_image_size( 'single', 380, 253, true );
	add_image_size( 'featured', 300, 200, true );
	add_image_size( 'main', 220, 146, true );	
	add_image_size( 'slide', 140, 93, true );
	add_image_size( 'small', 90, 60, true );
	add_image_size( 'tiny', 60, 40, true );
	
}

?>
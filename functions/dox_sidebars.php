<?php
/**
 * 
 */
 
function dox_widgets_init() {
	if ( function_exists('register_sidebar') ) {
		
		register_sidebar(array(
			'name' => 'Top Panel',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="title">',
			'after_title' => '</h3>',
		));	
		
		register_sidebar(array(
			'name' => 'Top Panel (Logged Users)',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="title">',
			'after_title' => '</h3>',
		));	

		register_sidebar(array(
			'name' => 'Right Sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="title">',
			'after_title' => '</h3>',
		));	

		register_sidebar(array(
			'name' => 'Blog Sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="title">',
			'after_title' => '</h3>',
		));	
		
		register_sidebar(array(
			'name' => 'Footer Left',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="title">',
			'after_title' => '</h3>',
		));
		
		register_sidebar(array(
			'name' => 'Footer Center',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="title">',
			'after_title' => '</h3>',
		));		

		register_sidebar(array(
			'name' => 'Footer Right',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="title">',
			'after_title' => '</h3>',
		));
		
	}
}

add_action( 'init', 'dox_widgets_init' );

?>
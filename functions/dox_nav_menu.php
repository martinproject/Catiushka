<?php
/**
 * 
 */
 
 
add_action( 'init', 'dox_register_menus' );

function dox_register_menus() {
	register_nav_menus( array( 'nav-menu' => __( 'Nav Menu', 'autotrader' ), 
							   'footer-menu' => __( 'Footer Menu', 'autotrader' ) 
							) );
}


?>
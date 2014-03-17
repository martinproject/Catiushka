<?php
/**
* 
*/
 
/**
* Loading css styles
*/
add_action('wp_print_styles', 'dox_load_styles');

function dox_load_styles() {
	
	global $dox_options;
	
	/* Reset */
	$style = get_template_directory_uri().'/styles/reset.css';
	wp_register_style('dox_css_reset', $style);
	wp_enqueue_style( 'dox_css_reset');
	
	/* Grid */
	$style = get_template_directory_uri().'/styles/grid.css';
	wp_register_style('dox_css_grid', $style);
	wp_enqueue_style( 'dox_css_grid');
	
	/* Google Font */
	$style = 'http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic&subset=latin,cyrillic-ext,greek,latin-ext,vietnamese';	
	wp_register_style( 'dox_google_font', $style );	
	wp_enqueue_style( 'dox_google_font');
	
	/* Main */
	$style = get_template_directory_uri().'/style.css';
	wp_register_style('dox_css_main', $style);
	wp_enqueue_style( 'dox_css_main');	
	
	/* PrettyPhoto */
	$style = get_template_directory_uri().'/styles/prettyphoto.css';
	wp_register_style('dox_css_prettyphoto', $style);
	wp_enqueue_style( 'dox_css_prettyphoto');		
	
	
	/* Default Colors */
	if (!isset($dox_options['color']['enable'])) {
		$style = get_template_directory_uri().'/styles/default.css';
		wp_register_style('dox_css_default', $style);
		wp_enqueue_style( 'dox_css_default');
	} 
	/* Custom Colors */
	else {
		wp_enqueue_style('dox_css_custom', get_template_directory_uri().'/styles/custom.php', false, '', 'screen');
	}
	
}

/**
* Loading javascripts
*/
if (!is_admin()) add_action('wp_print_scripts', 'dox_load_js');

function dox_load_js() {
	
	global $dox_options;
	
	wp_enqueue_script('dox_superfish', get_template_directory_uri() . '/js/superfish.js', array('jquery'), false, false);	
	wp_enqueue_script('dox_easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array('jquery'), '1.3.0', false);
	wp_enqueue_script('dox_gridnav', get_template_directory_uri() . '/js/jquery.gridnav.js', array('jquery'), false, false);
	wp_enqueue_script('dox_prettyphoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array('jquery'), false, false);
	wp_enqueue_script('dox_slidingform', get_template_directory_uri() . '/js/sliding.form.js', array('jquery'), false, false);
	if ( is_singular() ) { wp_enqueue_script('dox_twitter', 'http://platform.twitter.com/widgets.js', false, false, false); }
	
	if ( $dox_options['map']['enable'] == 'true' && ( is_page_template('template-post-an-ad.php') || is_page_template('template-edit-an-ad.php') || is_page_template('template-dealer-form.php') ) ) {
		wp_enqueue_script('dox_google_map_api', 'https://maps.googleapis.com/maps/api/js?sensor=false', false, false, false);
		wp_enqueue_script('dox_google_map_load', get_template_directory_uri() . '/js/google_map_load.js', false, false, false);
	}
	
}


?>
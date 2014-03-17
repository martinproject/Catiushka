<?php if (!function_exists ('add_action')) exit('No direct script access allowed');

define( 'THEME_NAME', 'Autotrader Theme' );
define( 'THEME_VERSION', '1.1.4' );
define( 'DOX_THEME_OPTIONS', 'dox_theme_options' );
define( 'DOX_OPTIONS_PAGE', 'dox_options_page' );
define( 'DOX_FEATURED_AD', 'on' );
define( 'DOX_STATUS_FEE_COMPLETED', 'FEE_COMPLETED' );
define( 'DOX_STATUS_FEE_PENDING', 'FEE_PENDING' );
define( 'DOX_STATUS_FEE_VOIDED', 'FEE_VOIDED' );
define( 'DOX_STATUS_FEATURED_COMPLETED', 'FEATURED_COMPLETED' );
define( 'DOX_STATUS_FEATURED_PENDING', 'FEATURED_PENDING' );
define( 'DOX_STATUS_FEATURED_PENDING_WF', 'FEATURED_PENDING_WF' ); // WF (WITH FEE): Fee paid, featured pending
define( 'DOX_STATUS_FEATURED_VOIDED', 'FEATURED_VOIDED' );

global $dox_options;

class DOX_Admin {
	
	private $pagehook;
	
	function DOX_Admin()
	{
		$this->__construct();
	}
  
	function __construct() 
	{
		add_action('admin_menu', array(&$this, 'admin_menu'));
		add_action('admin_init', array(&$this, 'admin_init'));
	}
	
	function admin_init() {
		register_setting( DOX_OPTIONS_PAGE, DOX_THEME_OPTIONS, array(&$this, 'validate_options') );
	}
	
	function admin_menu() {
		$this->init_theme_options();
		$this->pagehook = add_menu_page(THEME_NAME, esc_html__('AutoTrader', 'autotrader'), 'manage_options', DOX_OPTIONS_PAGE, array(&$this, 'load_options_page'));
		add_action('load-'.$this->pagehook, array(&$this, 'on_load_page'));
	}
	
	function init_theme_options() {
		global $dox_options;
		
		if( isset($dox_options['general']['reset_options']) && $dox_options['general']['reset_options'] == 'true' ) { $this->delete_options(); }
		if (! $this->get_options()) { $this->load_default_options(); }
		
	}
	
	function delete_options() {
		delete_option(DOX_THEME_OPTIONS);
	}
	
	function get_options() {
		return get_option(DOX_THEME_OPTIONS);
	}
	
	function load_default_options() {
		
		$options = array (
			'general' => array (
						'reset_options' => '',
						'logo_url' => '',
						'favicon_url' => '',
						'default_img_url' => '',
						'default_img_id' => '',
						'contact_email' => '',
						'contact_page' => '',
						'analytics_code' => ''
						),
			'home' => array (
						'featured_ad_nr' => '9',
						'latest_ad_nr' => '12',
						'browse_make' => array(
									'query' => 'auto_make_model',
									'number' => '13',
									'orderby' => 'count',
									'order' => 'DESC' ),
									
						'browse_body_type' => array(
									'query' => 'auto_body_type',
									'number' => '6',
									'orderby' => 'count',
									'order' => 'DESC' ),
									
						'browse_fuel_type' => array(
									'query' => 'auto_fuel_type',
									'number' => '5',
									'orderby' => 'count',
									'order' => 'DESC' ),
									
						'browse_year' => array(
									'query' => 'auto_year',
									'number' => '12',
									'orderby' => 'count',
									'order' => 'DESC' ),
									
						'browse_color' => array(
									'query' => 'auto_colour',
									'number' => '5',
									'orderby' => 'count',
									'order' => 'DESC' ),
									
						'browse_location' => array(
									'query' => 'auto_location',
									'number' => '13',
									'orderby' => 'count',
									'order' => 'DESC' ),
									
						),
			'blog' => array (
						'excerpt' => '350'
						),						
			'ad' => array (	
						'free_ad' => 'true',
						'currency' => 'USD',
						'ad_fee' => '1',
						'featured_ad' => 'true',
						'featured_cost' => '5',
						'submit_page' => '',
						'profile_page' => '',
						'dashboard_page' => '',
						'dealer_page' => '',
						'edit_page' => '',
						'search_page' => '',
						'search_results_page' => '',
						'watchlist_page' => '',
						'terms' =>	'',
						'show_empty_features' =>	'true'
						),
			'ad_set' => array (
						'type' => array(
							'name' => 'Auto',
							'base' => 'auto'
							),
						'condition' => array(
							'name' => 'Condition',
							'base' => 'condition',
							'query' => 'auto_condition',
							'slug' => 'auto/condition',
							'show' => 'true',
							'list' => '',
							'search' => '',
							'required' => 'true'							
							),
						'model' => array(
							'name' => 'Make',
							'sub' => 'Model',
							'base' => 'make_model',
							'query' => 'auto_make_model',
							'slug' => 'auto/make_model',
							'show' => 'true',
							'list' => 'true',
							'search' => 'true',
							'required' => 'true'
							),
						'location' => array(
							'name' => 'Location',
							'sub' => 'City',
							'base' => 'location',
							'query' => 'auto_location',
							'slug' => 'auto/location',
							'show' => 'true',
							'list' => 'true',
							'search' => 'true',
							'required' => 'true'
							),
						'year' => array(
							'name' => 'Year',
							'base' => 'year',
							'query' => 'auto_year',
							'slug' => 'auto/year',
							'show' => 'true',
							'list' => 'true',
							'search' => '',
							'required' => 'true'
							),
						'color' => array(
							'name' => 'Colour',
							'base' => 'colour',
							'query' => 'auto_colour',
							'slug' => 'auto/colour',
							'show' => 'true',
							'list' => '',
							'search' => '',
							'required' => 'true'
							),
						'fuelType' => array(
							'name' => 'Fuel Type',
							'base' => 'fuel_type',
							'query' => 'auto_fuel_type',
							'slug' => 'auto/fuel_type',
							'show' => 'true',
							'list' => '',
							'search' => '',
							'required' => 'true'
							),
						'bodyType' => array(
							'name' => 'Body Type',
							'base' => 'body_type',
							'query' => 'auto_body_type',
							'slug' => 'auto/body_type',
							'show' => 'true',
							'list' => '',
							'search' => '',
							'required' => 'true'
							),
						'transmission' => array(
							'name' => 'Transmission',
							'base' => 'transmission',
							'query' => 'auto_transmission',
							'slug' => 'auto/transmission',
							'show' => 'true',
							'list' => '',
							'search' => '',
							'required' => 'true'
							),
						'features' => array(
							'name' => 'Feature',
							'base' => 'features',
							'query' => 'auto_features',
							'slug' => 'auto/features',
							'show' => 'true'
							),
						'cylinders' => array(
							'name' => 'Cylinders',
							'base' => 'cylinders',
							'query' => 'auto_cylinders',
							'slug' => 'auto/cylinders',
							'show' => 'true',
							'list' => '',
							'search' => '',
							'required' => 'true'
							),
						'doors' => array(
							'name' => 'Doors',
							'base' => 'doors',
							'query' => 'auto_doors',
							'slug' => 'auto/doors',
							'show' => 'true',
							'list' => '',
							'search' => '',							
							'required' => 'true'
							),	
						'mileage' => array(
							'name' => 'Mileage',
							'base' => 'mileage',
							'query' => 'auto_mileage',
							'slug' => 'auto/mileage',
							'show' => 'true',
							'list' => 'true',
							'search' => '',
							'required' => 'true'
							),
						'price' => array(
							'name' => 'Price',
							'base' => 'price',
							'query' => 'auto_price',
							'slug' => 'auto/price',
							'show' => 'true',
							'list' => 'true',
							'search' => 'true',
							'required' => 'true'
							)						
						),						
			'paypal' => array (
						'enable' =>	'true',
						'live' => '',
						'email' => '',
						'return_page' => ''
						),						
			'footer' => array (
						'notice' =>	'',
						'address' => '',
						'phone' => '',
						'email' => '',
						'twitter' => '',
						'facebook' => ''
						),
			'recaptcha' => array (
						'enable' =>	'',
						'public_key' => '',
						'private_key' => '',
						'theme' => 'clean',
						'lang' => 'en'
						),
			'map' => array (
						'enable' =>	'true',
						'lat' => '0.0',
						'long' => '0.0',
						'zoom' => '12'
						),						
			'color' => array (
						'enable' =>	'',
						'general' => array (
								'color' => '676767',
								'background' => 'f8f8f8',
								'sectionTitle' => '828282',
								'sectionTitleBorder' => 'e1e1e1',
								'pageTitleBorder' => 'cccccc',
								'link' => '444444',
								'linkHover' => 'ff4a4a',
								'formElementColor' => '646464',
								'formElementBorder' => 'cccccc',
								'buttonColor' => 'f8f8f8',
								'buttonBackground' => 'ff4a4a',
								'buttonHoverColor' => 'f8f8f8',
								'buttonHoverBackground' => '666666',
								'textShadow' => '646464',
								'textShadowOpacity' => '0.1'
								),
						'topPanel' => array (
								'color' => 'ffffff',
								'background' => 'ff4a4a',
								'title' => 'ffffff',
								'titleBorder' => 'ffffff',
								'link' => 'ffffff',
								'linkHover' => 'ffffff',
								'formElementColor' => '646464',
								'formElementBorder' => 'dddddd',
								'buttonColor' => 'f8f8f8',
								'buttonBackground' => '666666',
								'buttonHoverColor' => 'f8f8f8',
								'buttonHoverBackground' => 'ff2a2a'								
								),
						'header' => array (
								'background' => 'efefef',
								'backgroundRGB' => '8d8d8d',
								'backgroundA' => '0.1',
								'borderTop' => 'ff4a4a',
								'borderBottom' => 'e4e4e4',
								'navLink' => '888888',
								'navLinkHover' => 'ff4a4a',
								'navBackground' => 'efefef',
								'navBorder' => 'd8d8d8'								
								),
						'home' => array (
								'slideNavBackground' => 'ffcfcf',
								'slideNavHoverBackground' => 'ff9999',
								'browseCatTitle' => 'ff7777',
								'browseCatBorder' => 'e2e2e2',
								'searchBackground' => 'f6f6f6',
								'searchBorder' => 'e8e8e8',
								'imageZoomBackground' => 'ff9999',
								'imageZoomBackgroundRGB' => 'ff4a4a',	
								'imageZoomBackgroundA' => '0.6'
								),
						'content' => array (
								'link' => '676767',
								'linkHover' => 'ff4a4a',						
								'thumbContainerBackground' => 'f2f2f2',
								'itemBorder' => 'e2e2e2',
								'featuresBlockBackground' => 'f6f6f6',
								'pagerBackground' => 'e8f3ff',
								'pagerBorder' => 'cce6ff',
								'pagerItemBorder' => 'f6f6f6',
								'pagerLink' => 'ff7777',
								'metaColor' => '999999',
								'blockquoteBorder' => 'cccccc',
								'widgetTitleBorder' => 'bbbbbb',
								'widgetPostItemBorder' => 'cccccc'							
								),
						'footer' => array (
								'color' => 'dddddd',
								'background' => 'efefef',
								'backgroundRGB' => '8d8d8d',
								'backgroundA' => '0.2',
								'borderTop' => 'ff4a4a',					
								'infoBackground' => '666666',
								'infoBackgroundRGB' => '000000',
								'infoBackgroundA' => '0.7',
								'link' => 'dddddd',
								'linkHover' => 'ff7777',
								'itemBorder' => 'c2c2c2',								
								'bottomColor' => 'eeeeee',						
								'bottomLink' => 'eeeeee',
								'bottomBackground' => '555555',
								'bottomBackgroundRGB' => '000000',
								'bottomBackgroundA' => '0.75',								
								),
						'listing' => array (
								'border' => 'dddddd',
								'buttonColor' => 'ffffff',						
								'buttonBackground' => 'ff7777',								
								'pagerColor' => 'ff4a4a',
								'pagerBackground' => 'ffe4e4',
								'pagerBorder' => 'ffcece',
								'pagerItemBorder' => 'f6f6f6',
								'pagerLink' => 'ff4a4a'							
								),
						'grid' => array (
								'link' => 'ff7777',
								'linkHover' => '333333',						
								'background' => 'f8f8f8',
								'headerBackground' => 'e8f3ff',					
								'headerBorder' => 'cce6ff',
								'gridItemBackground' => 'f6f6f6',
								'gridItemBackgroundAlt' => 'e8f3ff',								
								'gridItemBorder' => 'e9e9e9',						
								'pagerBorder' => 'f6f6f6'						
								),
						'form' => array (
								'link' => 'ff7777',
								'linkHover' => '333333',						
								'background' => 'f6f6f6',
								'itemBorder' => 'e2e2e2',					
								'navBackground' => 'e8f3ff',
								'navBorder' => 'cce6ff',								
								'selectedBackground' => 'cee6ff',						
								'selectedBorder' => '9dceff',
								'errorBackground' => 'ffc1c1',						
								'errorBorder' => 'ff8484',
								'passedBackground' => 'a5eba0',						
								'passedBorder' => '67de61',
								'errorColor' => 'ff7777'								
								),
						'alert' => array (
								'labelRed' => 'ff6b6b',
								'successColor' => '11470e',						
								'successBorder' => '3fd636',
								'successBackground' => '67de61',					
								'errorColor' => '8b0000',						
								'errorBorder' => 'ff6b6b',
								'errorBackground' => 'ff8484',
								'warningColor' => 'ab9305',						
								'warningBorder' => 'fbe87b',
								'warningBackground' => 'fcee9e'								
								)								
						)					
		);
		
		add_option(DOX_THEME_OPTIONS, $options );
	}
	
	function validate_options($data) {

	
		$data['ad']['ad_fee'] = (float)esc_attr($data['ad']['ad_fee']);
		$data['ad']['featured_cost'] = (float) esc_attr($data['ad']['featured_cost']);
		
		if ( (float) $data['ad']['ad_fee'] > (float) $data['ad']['featured_cost'] ) (float) $data['ad']['featured_cost'] = (float) $data['ad']['ad_fee'];
		
		$data['ad_set']['type']['base'] = sanitize_title(esc_attr($data['ad_set']['type']['base']));
		
		$data['ad_set']['condition']['base'] = sanitize_title(esc_attr($data['ad_set']['condition']['base']));
		
		if (!empty($data['ad_set']['type']['base']) && !empty($data['ad_set']['condition']['base'])) { 
			$data['ad_set']['condition']['query'] = $data['ad_set']['type']['base'].'_'.$data['ad_set']['condition']['base'];
			$data['ad_set']['condition']['slug'] = $data['ad_set']['type']['base'].'/'.$data['ad_set']['condition']['base'];
		}
		
		$data['ad_set']['model']['base'] = sanitize_title(esc_attr($data['ad_set']['model']['base']));
		
		if (!empty($data['ad_set']['type']['base']) && !empty($data['ad_set']['model']['base'])) { 
			$data['ad_set']['model']['query'] = $data['ad_set']['type']['base'].'_'.$data['ad_set']['model']['base'];
			$data['ad_set']['model']['slug'] = $data['ad_set']['type']['base'].'/'.$data['ad_set']['model']['base'];
		}
		
		$data['ad_set']['location']['base'] = sanitize_title(esc_attr($data['ad_set']['location']['base']));
		
		if (!empty($data['ad_set']['type']['base']) && !empty($data['ad_set']['location']['base'])) { 
			$data['ad_set']['location']['query'] = $data['ad_set']['type']['base'].'_'.$data['ad_set']['location']['base'];
			$data['ad_set']['location']['slug'] = $data['ad_set']['type']['base'].'/'.$data['ad_set']['location']['base'];
		}
		
		$data['ad_set']['year']['base'] = sanitize_title(esc_attr($data['ad_set']['year']['base']));
		
		if (!empty($data['ad_set']['type']['base']) && !empty($data['ad_set']['year']['base'])) { 
			$data['ad_set']['year']['query'] = $data['ad_set']['type']['base'].'_'.$data['ad_set']['year']['base'];
			$data['ad_set']['year']['slug'] = $data['ad_set']['type']['base'].'/'.$data['ad_set']['year']['base'];
		}
		
		$data['ad_set']['color']['base'] = sanitize_title(esc_attr($data['ad_set']['color']['base']));
		
		if (!empty($data['ad_set']['type']['base']) && !empty($data['ad_set']['color']['base'])) { 
			$data['ad_set']['color']['query'] = $data['ad_set']['type']['base'].'_'.$data['ad_set']['color']['base'];
			$data['ad_set']['color']['slug'] = $data['ad_set']['type']['base'].'/'.$data['ad_set']['color']['base'];
		}
		
		$data['ad_set']['fuelType']['base'] = sanitize_title(esc_attr($data['ad_set']['fuelType']['base']));
		
		if (!empty($data['ad_set']['type']['base']) && !empty($data['ad_set']['fuelType']['base'])) { 
			$data['ad_set']['fuelType']['query'] = $data['ad_set']['type']['base'].'_'.$data['ad_set']['fuelType']['base'];
			$data['ad_set']['fuelType']['slug'] = $data['ad_set']['type']['base'].'/'.$data['ad_set']['fuelType']['base'];
		}
		
		$data['ad_set']['bodyType']['base'] = sanitize_title(esc_attr($data['ad_set']['bodyType']['base']));
		
		if (!empty($data['ad_set']['type']['base']) && !empty($data['ad_set']['bodyType']['base'])) { 
			$data['ad_set']['bodyType']['query'] = $data['ad_set']['type']['base'].'_'.$data['ad_set']['bodyType']['base'];
			$data['ad_set']['bodyType']['slug'] = $data['ad_set']['type']['base'].'/'.$data['ad_set']['bodyType']['base'];
		}
		
		$data['ad_set']['transmission']['base'] = sanitize_title(esc_attr($data['ad_set']['transmission']['base']));
		
		if (!empty($data['ad_set']['type']['base']) && !empty($data['ad_set']['transmission']['base'])) { 
			$data['ad_set']['transmission']['query'] = $data['ad_set']['type']['base'].'_'.$data['ad_set']['transmission']['base'];
			$data['ad_set']['transmission']['slug'] = $data['ad_set']['type']['base'].'/'.$data['ad_set']['transmission']['base'];
		}
		
		$data['ad_set']['features']['base'] = sanitize_title(esc_attr($data['ad_set']['features']['base']));
		
		if (!empty($data['ad_set']['type']['base']) && !empty($data['ad_set']['features']['base'])) { 
			$data['ad_set']['features']['query'] = $data['ad_set']['type']['base'].'_'.$data['ad_set']['features']['base'];
			$data['ad_set']['features']['slug'] = $data['ad_set']['type']['base'].'/'.$data['ad_set']['features']['base'];
		}
		
		$data['ad_set']['cylinders']['base'] = sanitize_title(esc_attr($data['ad_set']['cylinders']['base']));
		
		if (!empty($data['ad_set']['type']['base']) && !empty($data['ad_set']['cylinders']['base'])) { 
			$data['ad_set']['cylinders']['query'] = $data['ad_set']['type']['base'].'_'.$data['ad_set']['cylinders']['base'];
			$data['ad_set']['cylinders']['slug'] = $data['ad_set']['type']['base'].'/'.$data['ad_set']['cylinders']['base'];
		}
		
		$data['ad_set']['doors']['base'] = sanitize_title(esc_attr($data['ad_set']['doors']['base']));
		
		if (!empty($data['ad_set']['type']['base']) && !empty($data['ad_set']['doors']['base'])) { 
			$data['ad_set']['doors']['query'] = $data['ad_set']['type']['base'].'_'.$data['ad_set']['doors']['base'];
			$data['ad_set']['doors']['slug'] = $data['ad_set']['type']['base'].'/'.$data['ad_set']['doors']['base'];
		}
		
		$data['ad_set']['mileage']['base'] = sanitize_title(esc_attr($data['ad_set']['mileage']['base']));
		
		if (!empty($data['ad_set']['type']['base']) && !empty($data['ad_set']['mileage']['base'])) { 
			$data['ad_set']['mileage']['query'] = $data['ad_set']['type']['base'].'_'.$data['ad_set']['mileage']['base'];
			$data['ad_set']['mileage']['slug'] = $data['ad_set']['type']['base'].'/'.$data['ad_set']['mileage']['base'];
		}

		$data['ad_set']['price']['base'] = sanitize_title(esc_attr($data['ad_set']['price']['base']));
		
		if (!empty($data['ad_set']['type']['base']) && !empty($data['ad_set']['price']['base'])) { 
			$data['ad_set']['price']['query'] = $data['ad_set']['type']['base'].'_'.$data['ad_set']['price']['base'];
			$data['ad_set']['price']['slug'] = $data['ad_set']['type']['base'].'/'.$data['ad_set']['price']['base'];
		}
		
		
		return $data;
	}	

	function on_load_page() {
	
		wp_register_style('dox_admin_css', get_template_directory_uri().'/styles/admin.css');
		wp_enqueue_style('dox_admin_css');	

		/* Colorpicker */
		wp_register_style('dox_css_colorpicker', get_template_directory_uri().'/styles/colorpicker.css');
		wp_enqueue_style( 'dox_css_colorpicker');		
		
		wp_enqueue_script('dox_colorpicker', get_template_directory_uri() . '/js/colorpicker.js', array('jquery'), false, false);

		wp_enqueue_script('common');
		wp_enqueue_script('wp-lists');
		wp_enqueue_script('postbox');	
		
		wp_enqueue_style('thickbox');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('media-upload');
		wp_enqueue_script('admin-scripts');


	
		add_meta_box('dox_general_opt_metabox', esc_html__('General Settings', 'autotrader'), array(&$this, 'general_opt_contentbox'), $this->pagehook, 'normal', 'core');
		add_meta_box('dox_homepage_opt_metabox', esc_html__('HomePage Settings', 'autotrader'), array(&$this, 'homepage_opt_contentbox'), $this->pagehook, 'normal', 'core');
		add_meta_box('dox_blog_opt_metabox', esc_html__('Blog Options', 'autotrader'), array(&$this, 'blog_opt_contentbox'), $this->pagehook, 'normal', 'core');
		add_meta_box('dox_ad_set_metabox', esc_html__('Ad Settings', 'autotrader'), array(&$this, 'ad_set_contentbox'), $this->pagehook, 'normal', 'core');
		add_meta_box('dox_ad_opt_metabox', esc_html__('Ad Options', 'autotrader'), array(&$this, 'ad_opt_contentbox'), $this->pagehook, 'normal', 'core');		
		add_meta_box('dox_paypal_opt_metabox', esc_html__('Paypal Settings', 'autotrader'), array(&$this, 'paypal_opt_contentbox'), $this->pagehook, 'normal', 'core');
		add_meta_box('dox_footer_opt_metabox', esc_html__('Footer Settings', 'autotrader'), array(&$this, 'footer_opt_contentbox'), $this->pagehook, 'normal', 'core');
		add_meta_box('dox_recaptcha_opt_metabox', esc_html__('reCaptcha Options', 'autotrader'), array(&$this, 'recaptcha_opt_contentbox'), $this->pagehook, 'normal', 'core');
		add_meta_box('dox_map_opt_metabox', esc_html__('Map Options', 'autotrader'), array(&$this, 'map_opt_contentbox'), $this->pagehook, 'normal', 'core');
		add_meta_box('dox_color_opt_metabox', esc_html__('Color Options', 'autotrader'), array(&$this, 'color_opt_contentbox'), $this->pagehook, 'normal', 'core');
	}
	
	function load_options_page() {
		global $dox_options, $screen_layout_columns;
		
		if ( $_REQUEST['settings-updated'] ) echo '<div id="message" class="updated fade"><p><strong>'.esc_html__('Theme settings saved.','autotrader').'</strong></p></div>';		
?>
		<!-- Page Start -->
		<div id="autotrader_options_container" class="wrap">
			<div id="icon-options-general" class="icon32"></div>
			<h2><?php printf( __('Autotrader Theme Settings <small><em>(version %1$s)</em></small>', 'autotrader'), THEME_VERSION ); ?></h2>
			
			<form method="post" action="options.php">
<?php
				settings_fields( DOX_OPTIONS_PAGE );
				$dox_options = $this->get_options();
				
				wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false );
				wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false );				
?>
				<div id="poststuff" class="metabox-holder<?php echo 2 == $screen_layout_columns ? ' has-right-sidebar' : ''; ?>">
					<div id="post-body" class="has-sidebar">
						<div id="post-body-content" class="has-sidebar-content">	
<?php		
							do_meta_boxes($this->pagehook, 'normal', $dox_options); 
							do_meta_boxes($this->pagehook, 'additional', $dox_options);
?>
							<fieldset style="margin:2px 0 0;"><legend class="screen-reader-text"><span><?php esc_attr_e('Reset Settings', 'autotrader') ?></span></legend>
							<label for="dox_theme_options[general][reset_options]">
								<input name="dox_theme_options[general][reset_options]" type="checkbox" id="dox_theme_options[general][reset_options]" value="true" />
								<?php esc_attr_e('Reset Settings', 'autotrader') ?>
							</label>
							</fieldset>
							<p class="submit">
								<input type="hidden" id="autotrader_submit" value="1" name="autotrader_submit"/>
								<input class="button-primary" type="submit" name="submit" value="<?php esc_attr_e('Save Changes', 'autotrader') ?>" />
							</p>
						</div>
					</div>
					<br class="clear"/>
				</div>
			</form>

		</div><!-- Page End -->
		<script type="text/javascript">
		    //<![CDATA[
		    jQuery(document).ready( function($) {
			    // close postboxes that should be closed
			    $('.if-js-closed').removeClass('if-js-closed').addClass('closed');
			    // postboxes setup
			    postboxes.add_postbox_toggles('<?php echo $this->pagehook; ?>');
				
				$('.colorbox').ColorPicker({
					onSubmit: function(hsb, hex, rgb, el) {
						$(el).val(hex);
						$(el).next('.colorshow').css('background','#'+hex);						
						$(el).ColorPickerHide();
					},
					onBeforeShow: function () {
						$(this).ColorPickerSetColor(this.value);						
					}
				})
				.bind('keyup', function(){
					$(this).ColorPickerSetColor(this.value);
				});
				
				$('.nav-tab-wrapper a').click(function() {
					
					$old = $('.nav-tab-active').attr('href');
					$('div > .'+$old).hide();					
					
					$('.nav-tab-wrapper > a').each(function(){
						$(this).removeClass('nav-tab-active');
					});
					$(this).addClass('nav-tab-active');
					
					$curr = $(this).attr('href');
					$('div > .'+ $curr).show();
					
					return false;
					
				});
				
				
				$('.upload-button').click(function() {
					formfield = $(this).prev('input').attr('id');
					uploader(formfield);
					return false;
				});
				
				function uploader(formfield){
				
					var tbframe_interval;
					
					tb_show('', 'media-upload.php?type=image&amp;TB_iframe=1');
					tbframe_interval = setInterval(function() { jQuery('#TB_iframeContent').contents().find('.savesend .button').val('Use This Image'); }, 2000);

					  window.original_send_to_editor = window.send_to_editor;
					  window.send_to_editor = function(html) {
						if (formfield) {
						  clearInterval(tbframe_interval);						
						  $('#'+formfield).val($(html).attr('href'));
						  
							if (formfield == 'default_img_url') 
							{	
								if($(html).attr("href").match(/attachment_id=([0-9]+)/)[1]) 
									var $attach_id = $(html).attr("href").match(/attachment_id=([0-9]+)/)[1];
									
								$('#default_img_id').val($attach_id);
							}
						  
						  tb_remove();
						} else {
						  window.original_send_to_editor(html);
						}
					  }					
				}
				
		    });
		    //]]>
		</script>
<?php		
	}
	
	function general_opt_contentbox( $options ) {
?>		
		<ul>
			<li>
				<label for="dox_theme_options[general][logo_url]"><?php esc_html_e('Logo URL', 'autotrader'); ?></label>
				<input name="dox_theme_options[general][logo_url]" id="logo_url_input" type="text" class="all-options" value="<?php echo esc_attr($options['general']['logo_url']); ?>" />
				<input id="logo_url_button" type="button" value="<?php esc_attr_e('Upload Logo', 'autotrader'); ?>" class="button-secondary upload-button" />
				<span class="description"><?php esc_html_e('Click to "File URL" button', 'autotrader'); ?></span>
			</li>
			<li>
				<label for="dox_theme_options[general][favicon_url]"><?php esc_html_e('Favicon URL', 'autotrader'); ?></label>
				<input name="dox_theme_options[general][favicon_url]" id="favicon_url_input" type="text" class="all-options" value="<?php echo esc_attr($options['general']['favicon_url']); ?>" />
				<input id="favicon_url_button" type="button" value="<?php esc_attr_e('Upload Favicon', 'autotrader'); ?>" class="button-secondary upload-button" />
				<span class="description"><?php esc_html_e('Click to "File URL" button', 'autotrader'); ?></span>
			</li>
			<li>
				<label for="dox_theme_options[general][default_img_url]"><?php esc_html_e('Default Image URL', 'autotrader'); ?></label>
				<input name="dox_theme_options[general][default_img_url]" id="default_img_url" type="text" class="all-options" value="<?php echo esc_attr($options['general']['default_img_url']); ?>" />
				<input id="default_img_url_button" type="button" value="<?php esc_attr_e('Upload', 'autotrader'); ?>" class="button-secondary upload-button" />
				<input type="hidden" id="default_img_id" value="<?php echo esc_attr($options['general']['default_img_id']); ?>" name="dox_theme_options[general][default_img_id]"/>
				<span class="description"><?php esc_html_e('Click to "Attachment Post URL" button', 'autotrader'); ?></span>
			</li>			
			<li>
				<label for="dox_theme_options[general][contact_email]"><?php esc_html_e('Contact Email', 'autotrader'); ?></label>
				<input name="dox_theme_options[general][contact_email]" id="dox_theme_options[general][contact_email]" type="text" class="all-options" value="<?php echo esc_attr($options['general']['contact_email']); ?>" />
				<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
			</li>
			<li>
				<label for="dox_theme_options[general][contact_page]"><?php esc_html_e('Contact Page', 'autotrader'); ?></label>
				<?php wp_dropdown_pages( 'name=dox_theme_options[general][contact_page]&sort_column=post_title&selected='.$options['general']['contact_page'] ); ?>
			</li>
			<li>
				<label for="dox_theme_options[general][analytics_code]"><?php esc_html_e('Google Analytics Code', 'autotrader'); ?></label>
				<textarea id="dox_theme_options[general][analytics_code]" name="dox_theme_options[general][analytics_code]" cols="40" rows="5"><?php echo $options['general']['analytics_code']; ?></textarea>
				<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
			</li>
			<li>
				<p class="submit">
					<input type="hidden" id="autotrader_submit" value="1" name="autotrader_submit"/>
					<input class="button-primary" type="submit" name="submit" value="<?php esc_attr_e('Save Changes', 'autotrader') ?>" />
				</p>
				<div class="clear"></div>
			</li>			
		</ul>
<?php
	}	
	
	function homepage_opt_contentbox( $options ) {

?>
		<ul>		
			<li>
				<label for="dox_theme_options[home][featured_ad_nr]"><?php esc_html_e('Featured Ad Number', 'autotrader'); ?></label>
				<input name="dox_theme_options[home][featured_ad_nr]" id="dox_theme_options[home][featured_ad_nr]" type="text" class="small-text" value="<?php echo esc_attr($options['home']['featured_ad_nr']); ?>" />
				<span class="description"><?php esc_html_e('The number of ads which shown on home featured ads slider', 'autotrader'); ?></span>
			</li>
			<li>
				<label for="dox_theme_options[home][latest_ad_nr]"><?php esc_html_e('Latest Ad Number', 'autotrader'); ?></label>
				<input name="dox_theme_options[home][latest_ad_nr]" id="dox_theme_options[home][latest_ad_nr]" type="text" class="small-text" value="<?php echo esc_attr($options['home']['latest_ad_nr']); ?>" />
				<span class="description"><?php esc_html_e('The number of ads which shown on home latest ads slider', 'autotrader'); ?></span>
			</li>
			<li class="marginT30">
				<label for="dox_theme_options[home][browse_make][query]"><?php esc_html_e('Browse Make Category', 'autotrader'); ?></label>
				<select name="dox_theme_options[home][browse_make][query]" id="dox_theme_options[home][browse_make][query]">
				<?php echo dox_get_browse_cat($options['home']['browse_make']['query']); ?>
				</select>
				<input name="dox_theme_options[home][browse_make][number]" id="dox_theme_options[home][browse_make][number]" type="text" class="small-text" value="<?php echo esc_attr($options['home']['browse_make']['number']); ?>" />				
				<select name="dox_theme_options[home][browse_make][orderby]" id="dox_theme_options[home][browse_make][orderby]">
					<option value="count" <?php if ( 'count' == $options['home']['browse_make']['orderby'] ) echo 'selected="selected"'; ?>><?php _e('Count','autotrader'); ?></option>
					<option value="name" <?php if ( 'name' == $options['home']['browse_make']['orderby'] ) echo 'selected="selected"'; ?>><?php _e('Name','autotrader'); ?></option>
					<option value="ID" <?php if ( 'ID' == $options['home']['browse_make']['orderby'] ) echo 'selected="selected"'; ?>><?php _e('ID','autotrader'); ?></option>				
				</select>
				<select name="dox_theme_options[home][browse_make][order]" id="dox_theme_options[home][browse_make][order]">
					<option value="DESC" <?php if ( 'DESC' == $options['home']['browse_make']['order'] ) echo 'selected="selected"'; ?>><?php _e('Descending','autotrader'); ?></option>
					<option value="ASC" <?php if ( 'ASC' == $options['home']['browse_make']['order'] ) echo 'selected="selected"'; ?>><?php _e('Ascending','autotrader'); ?></option>			
				</select>					
			</li>

			<li>
				<label for="dox_theme_options[home][browse_body_type][query]"><?php esc_html_e('Browse Body Type Category', 'autotrader'); ?></label>
				<select name="dox_theme_options[home][browse_body_type][query]" id="dox_theme_options[home][browse_body_type][query]">
				<?php echo dox_get_browse_cat($options['home']['browse_body_type']['query']); ?>
				</select>
				<input name="dox_theme_options[home][browse_body_type][number]" id="dox_theme_options[home][browse_body_type][number]" type="text" class="small-text" value="<?php echo esc_attr($options['home']['browse_body_type']['number']); ?>" />				
				<select name="dox_theme_options[home][browse_body_type][orderby]" id="dox_theme_options[home][browse_body_type][orderby]">
					<option value="count" <?php if ( 'count' == $options['home']['browse_body_type']['orderby'] ) echo 'selected="selected"'; ?>><?php _e('Count','autotrader'); ?></option>
					<option value="name" <?php if ( 'name' == $options['home']['browse_body_type']['orderby'] ) echo 'selected="selected"'; ?>><?php _e('Name','autotrader'); ?></option>
					<option value="ID" <?php if ( 'ID' == $options['home']['browse_body_type']['orderby'] ) echo 'selected="selected"'; ?>><?php _e('ID','autotrader'); ?></option>				
				</select>
				<select name="dox_theme_options[home][browse_body_type][order]" id="dox_theme_options[home][browse_body_type][order]">
					<option value="DESC" <?php if ( 'DESC' == $options['home']['browse_body_type']['order'] ) echo 'selected="selected"'; ?>><?php _e('Descending','autotrader'); ?></option>
					<option value="ASC" <?php if ( 'ASC' == $options['home']['browse_body_type']['order'] ) echo 'selected="selected"'; ?>><?php _e('Ascending','autotrader'); ?></option>			
				</select>					
			</li>	

			<li>
				<label for="dox_theme_options[home][browse_fuel_type][query]"><?php esc_html_e('Browse Fuel Type Category', 'autotrader'); ?></label>
				<select name="dox_theme_options[home][browse_fuel_type][query]" id="dox_theme_options[home][browse_fuel_type][query]">
				<?php echo dox_get_browse_cat($options['home']['browse_fuel_type']['query']); ?>
				</select>
				<input name="dox_theme_options[home][browse_fuel_type][number]" id="dox_theme_options[home][browse_fuel_type][number]" type="text" class="small-text" value="<?php echo esc_attr($options['home']['browse_fuel_type']['number']); ?>" />				
				<select name="dox_theme_options[home][browse_fuel_type][orderby]" id="dox_theme_options[home][browse_fuel_type][orderby]">
					<option value="count" <?php if ( 'count' == $options['home']['browse_fuel_type']['orderby'] ) echo 'selected="selected"'; ?>><?php _e('Count','autotrader'); ?></option>
					<option value="name" <?php if ( 'name' == $options['home']['browse_fuel_type']['orderby'] ) echo 'selected="selected"'; ?>><?php _e('Name','autotrader'); ?></option>
					<option value="ID" <?php if ( 'ID' == $options['home']['browse_fuel_type']['orderby'] ) echo 'selected="selected"'; ?>><?php _e('ID','autotrader'); ?></option>				
				</select>
				<select name="dox_theme_options[home][browse_fuel_type][order]" id="dox_theme_options[home][browse_fuel_type][order]">
					<option value="DESC" <?php if ( 'DESC' == $options['home']['browse_fuel_type']['order'] ) echo 'selected="selected"'; ?>><?php _e('Descending','autotrader'); ?></option>
					<option value="ASC" <?php if ( 'ASC' == $options['home']['browse_fuel_type']['order'] ) echo 'selected="selected"'; ?>><?php _e('Ascending','autotrader'); ?></option>			
				</select>					
			</li>	

			<li>
				<label for="dox_theme_options[home][browse_year][query]"><?php esc_html_e('Browse Year Category', 'autotrader'); ?></label>
				<select name="dox_theme_options[home][browse_year][query]" id="dox_theme_options[home][browse_year][query]">
				<?php echo dox_get_browse_cat($options['home']['browse_year']['query']); ?>
				</select>
				<input name="dox_theme_options[home][browse_year][number]" id="dox_theme_options[home][browse_year][number]" type="text" class="small-text" value="<?php echo esc_attr($options['home']['browse_year']['number']); ?>" />				
				<select name="dox_theme_options[home][browse_year][orderby]" id="dox_theme_options[home][browse_year][orderby]">
					<option value="count" <?php if ( 'count' == $options['home']['browse_year']['orderby'] ) echo 'selected="selected"'; ?>><?php _e('Count','autotrader'); ?></option>
					<option value="name" <?php if ( 'name' == $options['home']['browse_year']['orderby'] ) echo 'selected="selected"'; ?>><?php _e('Name','autotrader'); ?></option>
					<option value="ID" <?php if ( 'ID' == $options['home']['browse_year']['orderby'] ) echo 'selected="selected"'; ?>><?php _e('ID','autotrader'); ?></option>				
				</select>
				<select name="dox_theme_options[home][browse_year][order]" id="dox_theme_options[home][browse_year][order]">
					<option value="DESC" <?php if ( 'DESC' == $options['home']['browse_year']['order'] ) echo 'selected="selected"'; ?>><?php _e('Descending','autotrader'); ?></option>
					<option value="ASC" <?php if ( 'ASC' == $options['home']['browse_year']['order'] ) echo 'selected="selected"'; ?>><?php _e('Ascending','autotrader'); ?></option>			
				</select>					
			</li>	

			<li>
				<label for="dox_theme_options[home][browse_color][query]"><?php esc_html_e('Browse Color Category', 'autotrader'); ?></label>
				<select name="dox_theme_options[home][browse_color][query]" id="dox_theme_options[home][browse_color][query]">
				<?php echo dox_get_browse_cat($options['home']['browse_color']['query']); ?>
				</select>
				<input name="dox_theme_options[home][browse_color][number]" id="dox_theme_options[home][browse_color][number]" type="text" class="small-text" value="<?php echo esc_attr($options['home']['browse_color']['number']); ?>" />				
				<select name="dox_theme_options[home][browse_color][orderby]" id="dox_theme_options[home][browse_color][orderby]">
					<option value="count" <?php if ( 'count' == $options['home']['browse_color']['orderby'] ) echo 'selected="selected"'; ?>><?php _e('Count','autotrader'); ?></option>
					<option value="name" <?php if ( 'name' == $options['home']['browse_color']['orderby'] ) echo 'selected="selected"'; ?>><?php _e('Name','autotrader'); ?></option>
					<option value="ID" <?php if ( 'ID' == $options['home']['browse_color']['orderby'] ) echo 'selected="selected"'; ?>><?php _e('ID','autotrader'); ?></option>				
				</select>
				<select name="dox_theme_options[home][browse_color][order]" id="dox_theme_options[home][browse_color][order]">
					<option value="DESC" <?php if ( 'DESC' == $options['home']['browse_color']['order'] ) echo 'selected="selected"'; ?>><?php _e('Descending','autotrader'); ?></option>
					<option value="ASC" <?php if ( 'ASC' == $options['home']['browse_color']['order'] ) echo 'selected="selected"'; ?>><?php _e('Ascending','autotrader'); ?></option>			
				</select>					
			</li>	

			<li>
				<label for="dox_theme_options[home][browse_location][query]"><?php esc_html_e('Browse Location Category', 'autotrader'); ?></label>
				<select name="dox_theme_options[home][browse_location][query]" id="dox_theme_options[home][browse_location][query]">
				<?php echo dox_get_browse_cat($options['home']['browse_location']['query']); ?>
				</select>
				<input name="dox_theme_options[home][browse_location][number]" id="dox_theme_options[home][browse_location][number]" type="text" class="small-text" value="<?php echo esc_attr($options['home']['browse_location']['number']); ?>" />				
				<select name="dox_theme_options[home][browse_location][orderby]" id="dox_theme_options[home][browse_location][orderby]">
					<option value="count" <?php if ( 'count' == $options['home']['browse_location']['orderby'] ) echo 'selected="selected"'; ?>><?php _e('Count','autotrader'); ?></option>
					<option value="name" <?php if ( 'name' == $options['home']['browse_location']['orderby'] ) echo 'selected="selected"'; ?>><?php _e('Name','autotrader'); ?></option>
					<option value="ID" <?php if ( 'ID' == $options['home']['browse_location']['orderby'] ) echo 'selected="selected"'; ?>><?php _e('ID','autotrader'); ?></option>				
				</select>
				<select name="dox_theme_options[home][browse_location][order]" id="dox_theme_options[home][browse_location][order]">
					<option value="DESC" <?php if ( 'DESC' == $options['home']['browse_location']['order'] ) echo 'selected="selected"'; ?>><?php _e('Descending','autotrader'); ?></option>
					<option value="ASC" <?php if ( 'ASC' == $options['home']['browse_location']['order'] ) echo 'selected="selected"'; ?>><?php _e('Ascending','autotrader'); ?></option>			
				</select>					
			</li>	
			
			<li>
				<p class="submit">
					<input type="hidden" id="autotrader_submit" value="1" name="autotrader_submit"/>
					<input class="button-primary" type="submit" name="submit" value="<?php esc_attr_e('Save Changes', 'autotrader') ?>" />
				</p>
				<div class="clear"></div>
			</li>			
		</ul>
<?php
	}	
	
	function blog_opt_contentbox( $options ) {

?>
		<ul>		
			<li>
				<label for="dox_theme_options[blog][excerpt]"><?php esc_html_e('Featured Ad Number', 'autotrader'); ?></label>
				<input name="dox_theme_options[blog][excerpt]" id="dox_theme_options[blog][excerpt]" type="text" class="small-text" value="<?php echo esc_attr($options['blog']['excerpt']); ?>" />
				<span class="description"><?php esc_html_e('The number of displayed characters at blog page.', 'autotrader'); ?></span>
			</li>
			<li>
				<p class="submit">
					<input type="hidden" id="autotrader_submit" value="1" name="autotrader_submit"/>
					<input class="button-primary" type="submit" name="submit" value="<?php esc_attr_e('Save Changes', 'autotrader') ?>" />
				</p>
				<div class="clear"></div>
			</li>			
		</ul>		
<?php
	}	
	
	function ad_set_contentbox( $options ) {

?>
		<ul>				
			<li>
				<label for="dox_theme_options[ad][submit_page]"><?php esc_html_e('Submit Page', 'autotrader'); ?></label>
				<?php wp_dropdown_pages( 'name=dox_theme_options[ad][submit_page]&sort_column=post_title&selected='.$options['ad']['submit_page'] ); ?>
			</li>
			<li>
				<label for="dox_theme_options[ad][profile_page]"><?php esc_html_e('User Profile Page', 'autotrader'); ?></label>
				<?php wp_dropdown_pages( 'name=dox_theme_options[ad][profile_page]&sort_column=post_title&selected='.$options['ad']['profile_page'] ); ?>
			</li>			
			<li>
				<label for="dox_theme_options[ad][dashboard_page]"><?php esc_html_e('User Dashboard Page', 'autotrader'); ?></label>
				<?php wp_dropdown_pages( 'name=dox_theme_options[ad][dashboard_page]&sort_column=post_title&selected='.$options['ad']['dashboard_page'] ); ?>
			</li>
			<li>
				<label for="dox_theme_options[ad][dealer_page]"><?php esc_html_e('Dealer Form Page', 'autotrader'); ?></label>
				<?php wp_dropdown_pages( 'name=dox_theme_options[ad][dealer_page]&sort_column=post_title&selected='.$options['ad']['dealer_page'] ); ?>
			</li>
			<li>
				<label for="dox_theme_options[ad][edit_page]"><?php esc_html_e('Edit Ad Page', 'autotrader'); ?></label>
				<?php wp_dropdown_pages( 'name=dox_theme_options[ad][edit_page]&sort_column=post_title&selected='.$options['ad']['edit_page'] ); ?>
			</li>
			<li>
				<label for="dox_theme_options[ad][search_page]"><?php esc_html_e('Search Page', 'autotrader'); ?></label>
				<?php wp_dropdown_pages( 'name=dox_theme_options[ad][search_page]&sort_column=post_title&selected='.$options['ad']['search_page'] ); ?>
			</li>
			<li>
				<label for="dox_theme_options[ad][search_results_page]"><?php esc_html_e('Search Results Page', 'autotrader'); ?></label>
				<?php wp_dropdown_pages( 'name=dox_theme_options[ad][search_results_page]&sort_column=post_title&selected='.$options['ad']['search_results_page'] ); ?>
			</li>
			<li>
				<label for="dox_theme_options[ad][watchlist_page]"><?php esc_html_e('Watchlist Page', 'autotrader'); ?></label>
				<?php wp_dropdown_pages( 'name=dox_theme_options[ad][watchlist_page]&sort_column=post_title&selected='.$options['ad']['watchlist_page'] ); ?>
			</li>			
			<li>
				<label for="dox_theme_options[ad][currency]"><?php esc_html_e('Price Currency', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad][currency]" id="dox_theme_options[ad][currency]" type="text" class="small-text" style="float:left;margin-right:30px;" value="<?php echo esc_attr($options['ad']['currency']); ?>" />
				<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
				
				<label for="dox_theme_options[ad][free_ad]">
					<input name="dox_theme_options[ad][free_ad]" type="checkbox" id="dox_theme_options[ad][free_ad]" value="true" <?php if ($options['ad']['free_ad'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Enable Free Ads', 'autotrader') ?>
				</label>
				
				<label for="dox_theme_options[ad][featured_ad]">
					<input name="dox_theme_options[ad][featured_ad]" type="checkbox" id="dox_theme_options[ad][featured_ad]" value="true" <?php if ($options['ad']['featured_ad'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Enable Featured Ads', 'autotrader') ?>
				</label>
				
				<div class="clear"></div>				
			</li>
			<li>
				<label for="dox_theme_options[ad][ad_fee]"><?php esc_html_e('Ad Fee', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad][ad_fee]" id="dox_theme_options[ad][ad_fee]" type="text" class="small-text" value="<?php echo esc_attr($options['ad']['ad_fee']); ?>" />
				<span class="description"><?php echo esc_attr($options['ad']['currency']); ?></span>
			</li>				
			<li>
				<label for="dox_theme_options[ad][featured_cost]"><?php esc_html_e('Featured Ad Price', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad][featured_cost]" id="dox_theme_options[ad][featured_cost]" type="text" class="small-text" value="<?php echo esc_attr($options['ad']['featured_cost']); ?>" />
				<span class="description"><?php echo esc_attr($options['ad']['currency']); ?></span>
			</li>			
			<li>
				<label for="dox_theme_options[ad][terms]"><?php esc_html_e('Terms & Condtions', 'autotrader'); ?></label>
				<textarea id="dox_theme_options[ad][terms]" name="dox_theme_options[ad][terms]" cols="60" rows="8"><?php echo esc_attr($options['ad']['terms']); ?></textarea>
			</li>
			<li>
				<label for="dox_theme_options[ad][show_empty_features]" class="wideLabel">
					<input name="dox_theme_options[ad][show_empty_features]" type="checkbox" id="dox_theme_options[ad][show_empty_features]" value="true" <?php if ($options['ad']['show_empty_features'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show empty features at ad details page', 'autotrader') ?>
				</label>
				
				<div class="clear"></div>				
			</li>			
			<li>
				<p class="submit">
					<input type="hidden" id="autotrader_submit" value="1" name="autotrader_submit"/>
					<input class="button-primary" type="submit" name="submit" value="<?php esc_attr_e('Save Changes', 'autotrader') ?>" />
				</p>
				<div class="clear"></div>
			</li>			
		</ul>
<?php
	}	

	function ad_opt_contentbox( $options ) {

?>
		<ul>
			<li>
				<label for="dox_theme_options[ad_set][type][name]"><?php esc_html_e('Post Name', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][type][name]" id="dox_theme_options[ad_set][type][name]" type="text" class="all-options" value="<?php echo esc_attr($options['ad_set']['type']['name']); ?>" />
			</li>
			<li>
				<label for="dox_theme_options[ad_set][type][base]"><?php esc_html_e('Post Name Base URL', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][type][base]" id="dox_theme_options[ad_set][type][base]" type="text" class="medium-text" value="<?php if (!empty($options['ad_set']['type']['base'])) echo sanitize_title(esc_attr($options['ad_set']['type']['base'])); else echo sanitize_title(esc_attr($options['ad_set']['type']['name'])); ?>" />
			</li>
			
			<li class="marginT30">
				<label for="dox_theme_options[ad_set][condition][name]"><?php esc_html_e('Condition Name', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][condition][name]" id="dox_theme_options[ad_set][condition][name]" type="text" class="all-options fLeft" value="<?php echo esc_attr($options['ad_set']['condition']['name']); ?>" />
			
				<label for="dox_theme_options[ad_set][condition][show]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][condition][show]" type="checkbox" id="dox_theme_options[ad_set][condition][show]" value="true" <?php if (isset($options['ad_set']['condition']['show']) && $options['ad_set']['condition']['show'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show Field', 'autotrader') ?>
				</label>
				<div class="clear"></div>				
			</li>
			<li>
				<label for="dox_theme_options[ad_set][condition][base]"><?php esc_html_e('Condition Name Base URL', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][condition][base]" id="dox_theme_options[ad_set][condition][base]" type="text" class="medium-text fLeft" value="<?php if (!empty($options['ad_set']['condition']['base'])) echo sanitize_title(esc_attr($options['ad_set']['condition']['base'])); else echo sanitize_title(esc_attr($options['ad_set']['condition']['name'])); ?>" />
				
				<label for="dox_theme_options[ad_set][condition][required]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][condition][required]" type="checkbox" id="dox_theme_options[ad_set][condition][required]" value="true" <?php if (isset($options['ad_set']['condition']['required']) && $options['ad_set']['condition']['required'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Required Field', 'autotrader') ?>
				</label>

				<label for="dox_theme_options[ad_set][condition][list]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][condition][list]" type="checkbox" id="dox_theme_options[ad_set][condition][list]" value="true" <?php if (isset($options['ad_set']['condition']['list']) && $options['ad_set']['condition']['list'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on lists', 'autotrader') ?>
				</label>
				
				<label for="dox_theme_options[ad_set][condition][search]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][condition][search]" type="checkbox" id="dox_theme_options[ad_set][condition][search]" value="true" <?php if (isset($options['ad_set']['condition']['search']) && $options['ad_set']['condition']['search'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on searchbox', 'autotrader') ?>
				</label>				
				
				<div class="clear"></div>
			</li>
			
			<li class="marginT30">
				<label for="dox_theme_options[ad_set][model][name]"><?php esc_html_e('Make Name', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][model][name]" id="dox_theme_options[ad_set][model][name]" type="text" class="all-options fLeft" value="<?php echo esc_attr($options['ad_set']['model']['name']); ?>" />
				
				<label for="dox_theme_options[ad_set][model][show]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][model][show]" type="checkbox" id="dox_theme_options[ad_set][model][show]" value="true" <?php if (isset($options['ad_set']['model']['show']) && $options['ad_set']['model']['show'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show Field', 'autotrader') ?>
				</label>
				<div class="clear"></div>
			</li>
			<li>
				<label for="dox_theme_options[ad_set][model][sub]"><?php esc_html_e('Model Name', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][model][sub]" id="dox_theme_options[ad_set][model][sub]" type="text" class="all-options" value="<?php echo esc_attr($options['ad_set']['model']['sub']); ?>" />
			</li>			
			<li>
				<label for="dox_theme_options[ad_set][model][base]"><?php esc_html_e('Model Name Base URL', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][model][base]" id="dox_theme_options[ad_set][model][base]" type="text" class="medium-text fLeft" value="<?php if (!empty($options['ad_set']['model']['base'])) echo sanitize_title(esc_attr($options['ad_set']['model']['base'])); else echo sanitize_title(esc_attr($options['ad_set']['model']['name'])); ?>" />
				
				<label for="dox_theme_options[ad_set][model][required]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][model][required]" type="checkbox" id="dox_theme_options[ad_set][model][required]"  class="ad-set-label"value="true" <?php if (isset($options['ad_set']['model']['required']) && $options['ad_set']['model']['required'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Required Field', 'autotrader') ?>
				</label>

				<label for="dox_theme_options[ad_set][model][list]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][model][list]" type="checkbox" id="dox_theme_options[ad_set][model][list]" value="true" <?php if (isset($options['ad_set']['model']['list']) && $options['ad_set']['model']['list'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on lists', 'autotrader') ?>
				</label>

				<label for="dox_theme_options[ad_set][model][search]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][model][search]" type="checkbox" id="dox_theme_options[ad_set][model][search]" value="true" <?php if (isset($options['ad_set']['model']['search']) && $options['ad_set']['model']['search'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on searchbox', 'autotrader') ?>
				</label>	
				
				<div class="clear"></div>
			</li>
			
			<li class="marginT30">
				<label for="dox_theme_options[ad_set][location][name]"><?php esc_html_e('Location Name', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][location][name]" id="dox_theme_options[ad_set][location][name]" type="text" class="all-options fLeft" value="<?php echo esc_attr($options['ad_set']['location']['name']); ?>" />
				
				<label for="dox_theme_options[ad_set][location][show]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][location][show]" type="checkbox" id="dox_theme_options[ad_set][location][show]" value="true" <?php if (isset($options['ad_set']['location']['show']) && $options['ad_set']['location']['show'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show Field', 'autotrader') ?>
				</label>
				<div class="clear"></div>			
			</li>
			<li>
				<label for="dox_theme_options[ad_set][location][sub]"><?php esc_html_e('City Name', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][location][sub]" id="dox_theme_options[ad_set][location][sub]" type="text" class="all-options" value="<?php echo esc_attr($options['ad_set']['location']['sub']); ?>" />
			</li>			
			<li>
				<label for="dox_theme_options[ad_set][location][base]"><?php esc_html_e('Location Name Base URL', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][location][base]" id="dox_theme_options[ad_set][location][base]" type="text" class="medium-text fLeft" value="<?php if (!empty($options['ad_set']['location']['base'])) echo sanitize_title(esc_attr($options['ad_set']['location']['base'])); else echo sanitize_title(esc_attr($options['ad_set']['location']['name'])); ?>" />
				
				<label for="dox_theme_options[ad_set][location][required]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][location][required]" type="checkbox" id="dox_theme_options[ad_set][location][required]" value="true" <?php if (isset($options['ad_set']['location']['required']) && $options['ad_set']['location']['required'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Required Field', 'autotrader') ?>
				</label>

				<label for="dox_theme_options[ad_set][location][list]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][location][list]" type="checkbox" id="dox_theme_options[ad_set][location][list]" value="true" <?php if (isset($options['ad_set']['location']['list']) && $options['ad_set']['location']['list'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on lists', 'autotrader') ?>
				</label>

				<label for="dox_theme_options[ad_set][location][search]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][location][search]" type="checkbox" id="dox_theme_options[ad_set][location][search]" value="true" <?php if (isset($options['ad_set']['location']['search']) && $options['ad_set']['location']['search'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on searchbox', 'autotrader') ?>
				</label>	
				
				<div class="clear"></div>
			</li>
			
			
			<li class="marginT30">
				<label for="dox_theme_options[ad_set][year][name]"><?php esc_html_e('Year Name', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][year][name]" id="dox_theme_options[ad_set][year][name]" type="text" class="all-options fLeft" value="<?php echo esc_attr($options['ad_set']['year']['name']); ?>" />
				
				<label for="dox_theme_options[ad_set][year][show]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][year][show]" type="checkbox" id="dox_theme_options[ad_set][year][show]" value="true" <?php if (isset($options['ad_set']['year']['show']) && $options['ad_set']['year']['show'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show Field', 'autotrader') ?>
				</label>
				<div class="clear"></div>
			</li>
			<li>
				<label for="dox_theme_options[ad_set][year][base]"><?php esc_html_e('Year Name Base URL', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][year][base]" id="dox_theme_options[ad_set][year][base]" type="text" class="medium-text fLeft" value="<?php if (!empty($options['ad_set']['year']['base'])) echo sanitize_title(esc_attr($options['ad_set']['year']['base'])); else echo sanitize_title(esc_attr($options['ad_set']['year']['name'])); ?>" />
				
				<label for="dox_theme_options[ad_set][year][required]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][year][required]" type="checkbox" id="dox_theme_options[ad_set][year][required]" value="true" <?php if (isset($options['ad_set']['year']['required']) && $options['ad_set']['year']['required'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Required Field', 'autotrader') ?>
				</label>

				<label for="dox_theme_options[ad_set][year][list]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][year][list]" type="checkbox" id="dox_theme_options[ad_set][year][list]" value="true" <?php if (isset($options['ad_set']['year']['list']) && $options['ad_set']['year']['list'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on lists', 'autotrader') ?>
				</label>

				<label for="dox_theme_options[ad_set][year][search]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][year][search]" type="checkbox" id="dox_theme_options[ad_set][year][search]" value="true" <?php if (isset($options['ad_set']['year']['search']) && $options['ad_set']['year']['search'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on searchbox', 'autotrader') ?>
				</label>	
				
				<div class="clear"></div>
			</li>
			
			<li class="marginT30">
				<label for="dox_theme_options[ad_set][color][name]"><?php esc_html_e('Color Name', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][color][name]" id="dox_theme_options[ad_set][color][name]" type="text" class="all-options fLeft" value="<?php echo esc_attr($options['ad_set']['color']['name']); ?>" />
				
				<label for="dox_theme_options[ad_set][color][show]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][color][show]" type="checkbox" id="dox_theme_options[ad_set][color][show]" value="true" <?php if (isset($options['ad_set']['color']['show']) && $options['ad_set']['color']['show'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show Field', 'autotrader') ?>
				</label>
				<div class="clear"></div>
			</li>
			<li>
				<label for="dox_theme_options[ad_set][color][base]"><?php esc_html_e('Color Name Base URL', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][color][base]" id="dox_theme_options[ad_set][color][base]" type="text" class="medium-text fLeft" value="<?php if (!empty($options['ad_set']['color']['base'])) echo sanitize_title(esc_attr($options['ad_set']['color']['base'])); else echo sanitize_title(esc_attr($options['ad_set']['color']['name'])); ?>" />
				
				<label for="dox_theme_options[ad_set][color][required]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][color][required]" type="checkbox" id="dox_theme_options[ad_set][color][required]" value="true" <?php if (isset($options['ad_set']['color']['required']) && $options['ad_set']['color']['required'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Required Field', 'autotrader') ?>
				</label>

				<label for="dox_theme_options[ad_set][color][list]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][color][list]" type="checkbox" id="dox_theme_options[ad_set][color][list]" value="true" <?php if (isset($options['ad_set']['color']['list']) && $options['ad_set']['color']['list'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on lists', 'autotrader') ?>
				</label>

				<label for="dox_theme_options[ad_set][color][search]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][color][search]" type="checkbox" id="dox_theme_options[ad_set][color][search]" value="true" <?php if (isset($options['ad_set']['color']['search']) && $options['ad_set']['color']['search'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on searchbox', 'autotrader') ?>
				</label>	
				
				<div class="clear"></div>
			</li>
			
			<li class="marginT30">
				<label for="dox_theme_options[ad_set][fuelType][name]"><?php esc_html_e('Fuel Type Name', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][fuelType][name]" id="dox_theme_options[ad_set][fuelType][name]" type="text" class="all-options fLeft" value="<?php echo esc_attr($options['ad_set']['fuelType']['name']); ?>" />
				
				<label for="dox_theme_options[ad_set][fuelType][show]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][fuelType][show]" type="checkbox" id="dox_theme_options[ad_set][fuelType][show]" value="true" <?php if (isset($options['ad_set']['fuelType']['show']) && $options['ad_set']['fuelType']['show'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show Field', 'autotrader') ?>
				</label>
				<div class="clear"></div>
			</li>
			<li>
				<label for="dox_theme_options[ad_set][fuelType][base]"><?php esc_html_e('Fuel Type Name Base URL', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][fuelType][base]" id="dox_theme_options[ad_set][fuelType][base]" type="text" class="medium-text fLeft" value="<?php if (!empty($options['ad_set']['fuelType']['base'])) echo sanitize_title(esc_attr($options['ad_set']['fuelType']['base'])); else echo sanitize_title(esc_attr($options['ad_set']['fuelType']['name'])); ?>" />
				
				<label for="dox_theme_options[ad_set][fuelType][required]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][fuelType][required]" type="checkbox" id="dox_theme_options[ad_set][fuelType][required]" value="true" <?php if (isset($options['ad_set']['fuelType']['required']) && $options['ad_set']['fuelType']['required'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Required Field', 'autotrader') ?>
				</label>

				<label for="dox_theme_options[ad_set][fuelType][list]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][fuelType][list]" type="checkbox" id="dox_theme_options[ad_set][fuelType][list]" value="true" <?php if (isset($options['ad_set']['fuelType']['list']) && $options['ad_set']['fuelType']['list'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on lists', 'autotrader') ?>
				</label>

				<label for="dox_theme_options[ad_set][fuelType][search]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][fuelType][search]" type="checkbox" id="dox_theme_options[ad_set][fuelType][search]" value="true" <?php if (isset($options['ad_set']['fuelType']['search']) && $options['ad_set']['fuelType']['search'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on searchbox', 'autotrader') ?>
				</label>	
				
				<div class="clear"></div>
			</li>
			
			<li class="marginT30">
				<label for="dox_theme_options[ad_set][bodyType][name]"><?php esc_html_e('Body Type Name', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][bodyType][name]" id="dox_theme_options[ad_set][bodyType][name]" type="text" class="all-options fLeft" value="<?php echo esc_attr($options['ad_set']['bodyType']['name']); ?>" />
				
				<label for="dox_theme_options[ad_set][bodyType][show]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][bodyType][show]" type="checkbox" id="dox_theme_options[ad_set][bodyType][show]" value="true" <?php if (isset($options['ad_set']['bodyType']['show']) && $options['ad_set']['bodyType']['show'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show Field', 'autotrader') ?>
				</label>
				<div class="clear"></div>
			</li>
			<li>
				<label for="dox_theme_options[ad_set][bodyType][base]"><?php esc_html_e('Body Type Name Base URL', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][bodyType][base]" id="dox_theme_options[ad_set][bodyType][base]" type="text" class="medium-text fLeft" value="<?php if (!empty($options['ad_set']['bodyType']['base'])) echo sanitize_title(esc_attr($options['ad_set']['bodyType']['base'])); else echo sanitize_title(esc_attr($options['ad_set']['bodyType']['name'])); ?>" />
				
				<label for="dox_theme_options[ad_set][bodyType][required]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][bodyType][required]" type="checkbox" id="dox_theme_options[ad_set][bodyType][required]" value="true" <?php if (isset($options['ad_set']['bodyType']['required']) && $options['ad_set']['bodyType']['required'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Required Field', 'autotrader') ?>
				</label>

				<label for="dox_theme_options[ad_set][bodyType][list]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][bodyType][list]" type="checkbox" id="dox_theme_options[ad_set][bodyType][list]" value="true" <?php if (isset($options['ad_set']['bodyType']['list']) && $options['ad_set']['bodyType']['list'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on lists', 'autotrader') ?>
				</label>

				<label for="dox_theme_options[ad_set][bodyType][search]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][bodyType][search]" type="checkbox" id="dox_theme_options[ad_set][bodyType][search]" value="true" <?php if (isset($options['ad_set']['bodyType']['search']) && $options['ad_set']['bodyType']['search'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on searchbox', 'autotrader') ?>
				</label>	
				
				<div class="clear"></div>
			</li>
			
			<li class="marginT30">
				<label for="dox_theme_options[ad_set][transmission][name]"><?php esc_html_e('Transmission Name', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][transmission][name]" id="dox_theme_options[ad_set][transmission][name]" type="text" class="all-options fLeft" value="<?php echo esc_attr($options['ad_set']['transmission']['name']); ?>" />
				
				<label for="dox_theme_options[ad_set][transmission][show]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][transmission][show]" type="checkbox" id="dox_theme_options[ad_set][transmission][show]" value="true" <?php if (isset($options['ad_set']['transmission']['show']) && $options['ad_set']['transmission']['show'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show Field', 'autotrader') ?>
				</label>
				<div class="clear"></div>
			</li>
			<li>
				<label for="dox_theme_options[ad_set][transmission][base]"><?php esc_html_e('Transmission Name Base URL', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][transmission][base]" id="dox_theme_options[ad_set][transmission][base]" type="text" class="medium-text fLeft" value="<?php if (!empty($options['ad_set']['transmission']['base'])) echo sanitize_title(esc_attr($options['ad_set']['transmission']['base'])); else echo sanitize_title(esc_attr($options['ad_set']['transmission']['name'])); ?>" />
				
				<label for="dox_theme_options[ad_set][transmission][required]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][transmission][required]" type="checkbox" id="dox_theme_options[ad_set][transmission][required]" value="true" <?php if (isset($options['ad_set']['transmission']['required']) && $options['ad_set']['transmission']['required'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Required Field', 'autotrader') ?>
				</label>

				<label for="dox_theme_options[ad_set][transmission][list]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][transmission][list]" type="checkbox" id="dox_theme_options[ad_set][transmission][list]" value="true" <?php if (isset($options['ad_set']['transmission']['list']) && $options['ad_set']['transmission']['list'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on lists', 'autotrader') ?>
				</label>

				<label for="dox_theme_options[ad_set][transmission][search]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][transmission][search]" type="checkbox" id="dox_theme_options[ad_set][transmission][search]" value="true" <?php if (isset($options['ad_set']['transmission']['search']) && $options['ad_set']['transmission']['search'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on searchbox', 'autotrader') ?>
				</label>	
				
				<div class="clear"></div>
			</li>
			
			<li class="marginT30">
				<label for="dox_theme_options[ad_set][features][name]"><?php esc_html_e('Features Name', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][features][name]" id="dox_theme_options[ad_set][features][name]" type="text" class="all-options fLeft" value="<?php echo esc_attr($options['ad_set']['features']['name']); ?>" />
				
				<label for="dox_theme_options[ad_set][features][show]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][features][show]" type="checkbox" id="dox_theme_options[ad_set][features][show]" value="true" <?php if (isset($options['ad_set']['features']['show']) && $options['ad_set']['features']['show'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show Field', 'autotrader') ?>
				</label>
				<div class="clear"></div>
			</li>
			<li>
				<label for="dox_theme_options[ad_set][features][base]"><?php esc_html_e('Features Name Base URL', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][features][base]" id="dox_theme_options[ad_set][features][base]" type="text" class="medium-text fLeft" value="<?php if (!empty($options['ad_set']['features']['base'])) echo sanitize_title(esc_attr($options['ad_set']['features']['base'])); else echo sanitize_title(esc_attr($options['ad_set']['features']['name'])); ?>" />
				<div class="clear"></div>
			</li>
			
			<li class="marginT30">
				<label for="dox_theme_options[ad_set][cylinders][name]"><?php esc_html_e('Cylinders Name', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][cylinders][name]" id="dox_theme_options[ad_set][cylinders][name]" type="text" class="all-options fLeft" value="<?php echo esc_attr($options['ad_set']['cylinders']['name']); ?>" />
				
				<label for="dox_theme_options[ad_set][cylinders][show]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][cylinders][show]" type="checkbox" id="dox_theme_options[ad_set][cylinders][show]" value="true" <?php if (isset($options['ad_set']['cylinders']['show']) && $options['ad_set']['cylinders']['show'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show Field', 'autotrader') ?>
				</label>
				<div class="clear"></div>
			</li>
			<li>
				<label for="dox_theme_options[ad_set][cylinders][base]"><?php esc_html_e('Cylinders Name Base URL', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][cylinders][base]" id="dox_theme_options[ad_set][cylinders][base]" type="text" class="medium-text fLeft" value="<?php if (!empty($options['ad_set']['cylinders']['base'])) echo sanitize_title(esc_attr($options['ad_set']['cylinders']['base'])); else echo sanitize_title(esc_attr($options['ad_set']['cylinders']['name'])); ?>" />
				
				<label for="dox_theme_options[ad_set][cylinders][required]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][cylinders][required]" type="checkbox" id="dox_theme_options[ad_set][cylinders][required]" value="true" <?php if (isset($options['ad_set']['cylinders']['required']) && $options['ad_set']['cylinders']['required'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Required Field', 'autotrader') ?>
				</label>	

				<label for="dox_theme_options[ad_set][cylinders][list]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][cylinders][list]" type="checkbox" id="dox_theme_options[ad_set][cylinders][list]" value="true" <?php if (isset($options['ad_set']['cylinders']['list']) && $options['ad_set']['cylinders']['list'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on lists', 'autotrader') ?>
				</label>

				<label for="dox_theme_options[ad_set][cylinders][search]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][cylinders][search]" type="checkbox" id="dox_theme_options[ad_set][cylinders][search]" value="true" <?php if (isset($options['ad_set']['cylinders']['search']) && $options['ad_set']['cylinders']['search'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on searchbox', 'autotrader') ?>
				</label>	
				
				<div class="clear"></div>
			</li>
			
			<li class="marginT30">
				<label for="dox_theme_options[ad_set][doors][name]"><?php esc_html_e('Doors Name', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][doors][name]" id="dox_theme_options[ad_set][doors][name]" type="text" class="all-options fLeft" value="<?php echo esc_attr($options['ad_set']['doors']['name']); ?>" />
				
				<label for="dox_theme_options[ad_set][doors][show]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][doors][show]" type="checkbox" id="dox_theme_options[ad_set][doors][show]" value="true" <?php if (isset($options['ad_set']['doors']['show']) && $options['ad_set']['doors']['show'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show Field', 'autotrader') ?>
				</label>
				<div class="clear"></div>
			</li>
			<li>
				<label for="dox_theme_options[ad_set][doors][base]"><?php esc_html_e('Doors Name Base URL', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][doors][base]" id="dox_theme_options[ad_set][doors][base]" type="text" class="medium-text fLeft" value="<?php if (!empty($options['ad_set']['doors']['base'])) echo sanitize_title(esc_attr($options['ad_set']['doors']['base'])); else echo sanitize_title(esc_attr($options['ad_set']['doors']['name'])); ?>" />
				
				<label for="dox_theme_options[ad_set][doors][required]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][doors][required]" type="checkbox" id="dox_theme_options[ad_set][doors][required]" value="true" <?php if (isset($options['ad_set']['doors']['required']) && $options['ad_set']['doors']['required'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Required Field', 'autotrader') ?>
				</label>

				<label for="dox_theme_options[ad_set][doors][list]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][doors][list]" type="checkbox" id="dox_theme_options[ad_set][doors][list]" value="true" <?php if (isset($options['ad_set']['doors']['list']) && $options['ad_set']['doors']['list'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on lists', 'autotrader') ?>
				</label>

				<label for="dox_theme_options[ad_set][doors][search]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][doors][search]" type="checkbox" id="dox_theme_options[ad_set][doors][search]" value="true" <?php if (isset($options['ad_set']['doors']['search']) && $options['ad_set']['doors']['search'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on searchbox', 'autotrader') ?>
				</label>	
				
				<div class="clear"></div>
			</li>
			
			<li class="marginT30">
				<label for="dox_theme_options[ad_set][mileage][name]"><?php esc_html_e('Mileage Name', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][mileage][name]" id="dox_theme_options[ad_set][mileage][name]" type="text" class="all-options fLeft" value="<?php echo esc_attr($options['ad_set']['mileage']['name']); ?>" />
				
				<label for="dox_theme_options[ad_set][mileage][show]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][mileage][show]" type="checkbox" id="dox_theme_options[ad_set][mileage][show]" value="true" <?php if (isset($options['ad_set']['mileage']['show']) && $options['ad_set']['mileage']['show'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show Field', 'autotrader') ?>
				</label>
				<div class="clear"></div>				
			</li>
			<li>
				<label for="dox_theme_options[ad_set][mileage][base]"><?php esc_html_e('Mileage Name Base URL', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][mileage][base]" id="dox_theme_options[ad_set][mileage][base]" type="text" class="medium-text fLeft" value="<?php if (!empty($options['ad_set']['mileage']['base'])) echo sanitize_title(esc_attr($options['ad_set']['mileage']['base'])); else echo sanitize_title(esc_attr($options['ad_set']['mileage']['name'])); ?>" />
				
				<label for="dox_theme_options[ad_set][mileage][required]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][mileage][required]" type="checkbox" id="dox_theme_options[ad_set][mileage][required]" value="true" <?php if (isset($options['ad_set']['mileage']['required']) && $options['ad_set']['mileage']['required'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Required Field', 'autotrader') ?>
				</label>

				<label for="dox_theme_options[ad_set][mileage][list]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][mileage][list]" type="checkbox" id="dox_theme_options[ad_set][mileage][list]" value="true" <?php if (isset($options['ad_set']['mileage']['list']) && $options['ad_set']['mileage']['list'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on lists', 'autotrader') ?>
				</label>

				<label for="dox_theme_options[ad_set][mileage][search]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][mileage][search]" type="checkbox" id="dox_theme_options[ad_set][mileage][search]" value="true" <?php if (isset($options['ad_set']['mileage']['search']) && $options['ad_set']['mileage']['search'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on searchbox', 'autotrader') ?>
				</label>	
				
				<div class="clear"></div>
			</li>
			
			<li class="marginT30">
				<label for="dox_theme_options[ad_set][price][name]"><?php esc_html_e('Price Name', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][price][name]" id="dox_theme_options[ad_set][price][name]" type="text" class="all-options fLeft" value="<?php echo esc_attr($options['ad_set']['price']['name']); ?>" />
							
				<label for="dox_theme_options[ad_set][price][show]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][price][show]" type="checkbox" id="dox_theme_options[ad_set][price][show]" value="true" <?php if (isset($options['ad_set']['price']['show']) && $options['ad_set']['price']['show'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show Field', 'autotrader') ?>
				</label>
				<div class="clear"></div>
			</li>
			<li>
				<label for="dox_theme_options[ad_set][price][base]"><?php esc_html_e('Price Name Base URL', 'autotrader'); ?></label>
				<input name="dox_theme_options[ad_set][price][base]" id="dox_theme_options[ad_set][price][base]" type="text" class="medium-text fLeft" value="<?php if (!empty($options['ad_set']['price']['base'])) echo sanitize_title(esc_attr($options['ad_set']['price']['base'])); else echo sanitize_title(esc_attr($options['ad_set']['price']['name'])); ?>" />
				
				<label for="dox_theme_options[ad_set][price][required]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][price][required]" type="checkbox" id="dox_theme_options[ad_set][price][required]" value="true" <?php if (isset($options['ad_set']['price']['required']) && $options['ad_set']['price']['required'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Required Field', 'autotrader') ?>
				</label>

				<label for="dox_theme_options[ad_set][price][list]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][price][list]" type="checkbox" id="dox_theme_options[ad_set][price][list]" value="true" <?php if (isset($options['ad_set']['price']['list']) && $options['ad_set']['price']['list'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on lists', 'autotrader') ?>
				</label>		
				
				<label for="dox_theme_options[ad_set][price][search]" class="ad-set-label">
					<input name="dox_theme_options[ad_set][price][search]" type="checkbox" id="dox_theme_options[ad_set][price][search]" value="true" <?php if (isset($options['ad_set']['price']['search']) && $options['ad_set']['price']['search'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Show on searchbox', 'autotrader') ?>
				</label>	
				
				<div class="clear"></div>
			</li>			
			<li>
				<p class="submit">
					<input type="hidden" id="autotrader_submit" value="1" name="autotrader_submit"/>
					<input class="button-primary" type="submit" name="submit" value="<?php esc_attr_e('Save Changes', 'autotrader') ?>" />
				</p>
				<div class="clear"></div>
			</li>			
		</ul>
<?php
	}
	
	function paypal_opt_contentbox( $options ) {

?>
		<ul>
			<li>
				<label for="dox_theme_options[paypal][enable]">
					<input name="dox_theme_options[paypal][enable]" type="checkbox" id="dox_theme_options[paypal][enable]" value="true" <?php if ($options['paypal']['enable'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Enable Paypal Payments', 'autotrader') ?>
				</label>
				<div class="clear"></div>
			</li>
			<li>
				<label for="dox_theme_options[paypal][live]">
					<input name="dox_theme_options[paypal][live]" type="checkbox" id="dox_theme_options[paypal][live]" value="true" <?php if (isset($options['paypal']['live']) && $options['paypal']['live'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Enable Paypal Live Payments', 'autotrader') ?>
				</label>
				<div class="clear"></div>
			</li>
			<li>
				<label for="dox_theme_options[paypal][email]"><?php esc_html_e('Paypal Email', 'autotrader'); ?></label>
				<input name="dox_theme_options[paypal][email]" id="dox_theme_options[paypal][email]" type="text" class="all-options" value="<?php echo esc_attr($options['paypal']['email']); ?>" />
				<span class="description"><?php esc_html_e('This account will take payments.', 'autotrader'); ?></span>
			</li>			
			<li>
				<label for="dox_theme_options[paypal][return_page]"><?php esc_html_e('Return Page', 'autotrader'); ?></label>
				<?php wp_dropdown_pages( 'name=dox_theme_options[paypal][return_page]&sort_column=post_title&selected='.$options['paypal']['return_page'] ); ?>
				<span class="description"><?php esc_html_e('After payment, Paypal will redirect user to this page', 'autotrader'); ?></span>
			</li>
			<li>
				<p class="submit">
					<input type="hidden" id="autotrader_submit" value="1" name="autotrader_submit"/>
					<input class="button-primary" type="submit" name="submit" value="<?php esc_attr_e('Save Changes', 'autotrader') ?>" />
				</p>
				<div class="clear"></div>
			</li>			
		</ul>
		
<?php
	}	
	
	function footer_opt_contentbox( $options ) {

?>
		<ul>		
			<li>
				<label for="dox_theme_options[footer][address]"><?php esc_html_e('Address', 'autotrader'); ?></label>
				<input name="dox_theme_options[footer][address]" id="dox_theme_options[footer][address]" type="text" class="regular-text" value="<?php echo esc_attr($options['footer']['address']); ?>" />
			</li>
			<li>
				<label for="dox_theme_options[footer][phone]"><?php esc_html_e('Phone Number', 'autotrader'); ?></label>
				<input name="dox_theme_options[footer][phone]" id="dox_theme_options[footer][phone]" type="text" class="all-options" value="<?php echo esc_attr($options['footer']['phone']); ?>" />
			</li>
			<li>
				<label for="dox_theme_options[footer][email]"><?php esc_html_e('E-mail Address', 'autotrader'); ?></label>
				<input name="dox_theme_options[footer][email]" id="dox_theme_options[footer][email]" type="text" class="all-options" value="<?php echo esc_attr($options['footer']['email']); ?>" />
			</li>
			<li>
				<label for="dox_theme_options[footer][twitter]"><?php esc_html_e('Twitter Username', 'autotrader'); ?></label>
				<input name="dox_theme_options[footer][twitter]" id="dox_theme_options[footer][twitter]" type="text" class="all-options" value="<?php echo esc_attr($options['footer']['twitter']); ?>" />
			</li>
			<li>
				<label for="dox_theme_options[footer][facebook]"><?php esc_html_e('Facebook Username', 'autotrader'); ?></label>
				<input name="dox_theme_options[footer][facebook]" id="dox_theme_options[footer][facebook]" type="text" class="all-options" value="<?php echo esc_attr($options['footer']['facebook']); ?>" />
			</li>
			<li>
				<label for="dox_theme_options[footer][notice]"><?php esc_html_e('Footer Notice', 'autotrader'); ?></label>
				<input name="dox_theme_options[footer][notice]" id="dox_theme_options[footer][notice]" type="text" class="regular-text" value="<?php echo esc_attr($options['footer']['notice']); ?>" />
			</li>	
			<li>
				<p class="submit">
					<input type="hidden" id="autotrader_submit" value="1" name="autotrader_submit"/>
					<input class="button-primary" type="submit" name="submit" value="<?php esc_attr_e('Save Changes', 'autotrader') ?>" />
				</p>
				<div class="clear"></div>
			</li>			
		</ul>
<?php
	}	
	
	function recaptcha_opt_contentbox( $options ) {

?>
		<ul>
			<li>
				<label for="dox_theme_options[recaptcha][enable]">
					<input name="dox_theme_options[recaptcha][enable]" type="checkbox" id="dox_theme_options[recaptcha][enable]" value="true" <?php if (isset($options['recaptcha']['enable']) && $options['recaptcha']['enable'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Enable reCaptcha', 'autotrader') ?>
				</label>
				<div class="clear"></div>
			</li>
		
			<li>
				<label for="dox_theme_options[recaptcha][public_key]"><?php esc_html_e('Public Key', 'autotrader'); ?></label>
				<input name="dox_theme_options[recaptcha][public_key]" id="dox_theme_options[recaptcha][public_key]" type="text" class="regular-text" value="<?php echo esc_attr($options['recaptcha']['public_key']); ?>" />
				<span class="description"><a href="https://www.google.com/recaptcha" target="_blank"><?php esc_attr_e('Get Key', 'autotrader'); ?></a></span>
			</li>
			
			<li>
				<label for="dox_theme_options[recaptcha][private_key]"><?php esc_html_e('Public Key', 'autotrader'); ?></label>
				<input name="dox_theme_options[recaptcha][private_key]" id="dox_theme_options[recaptcha][private_key]" type="text" class="regular-text" value="<?php echo esc_attr($options['recaptcha']['private_key']); ?>" />
			</li>

			<li>
				<label for="dox_theme_options[recaptcha][theme]"><?php esc_html_e('Theme', 'autotrader'); ?></label>
				<select name="dox_theme_options[recaptcha][theme]" id="dox_theme_options[recaptcha][theme]">
					<option value="red" <?php if ( 'red' == $options['recaptcha']['theme'] ) echo 'selected="selected"'; ?>><?php _e('Red','autotrader'); ?></option>
					<option value="white" <?php if ( 'white' == $options['recaptcha']['theme'] ) echo 'selected="selected"'; ?>><?php _e('White','autotrader'); ?></option>
					<option value="blackglass" <?php if ( 'blackglass' == $options['recaptcha']['theme'] ) echo 'selected="selected"'; ?>><?php _e('BlackGlass','autotrader'); ?></option>
					<option value="clean" <?php if ( 'clean' == $options['recaptcha']['theme'] ) echo 'selected="selected"'; ?>><?php _e('Clean','autotrader'); ?></option>					
				</select>
			</li>

			<li>
				<label for="dox_theme_options[recaptcha][lang]"><?php esc_html_e('Language', 'autotrader'); ?></label>
				<select name="dox_theme_options[recaptcha][lang]" id="dox_theme_options[recaptcha][lang]">
					<option value="de" <?php if ( 'de' == $options['recaptcha']['lang'] ) echo 'selected="selected"'; ?>><?php _e('DE','autotrader'); ?></option>
					<option value="en" <?php if ( 'en' == $options['recaptcha']['lang'] ) echo 'selected="selected"'; ?>><?php _e('EN','autotrader'); ?></option>
					<option value="es" <?php if ( 'es' == $options['recaptcha']['lang'] ) echo 'selected="selected"'; ?>><?php _e('ES','autotrader'); ?></option>					
					<option value="fr" <?php if ( 'fr' == $options['recaptcha']['lang'] ) echo 'selected="selected"'; ?>><?php _e('FR','autotrader'); ?></option>
					<option value="nl" <?php if ( 'nl' == $options['recaptcha']['lang'] ) echo 'selected="selected"'; ?>><?php _e('NL','autotrader'); ?></option>
					<option value="pt" <?php if ( 'pt' == $options['recaptcha']['lang'] ) echo 'selected="selected"'; ?>><?php _e('PT','autotrader'); ?></option>
					<option value="ru" <?php if ( 'ru' == $options['recaptcha']['lang'] ) echo 'selected="selected"'; ?>><?php _e('RU','autotrader'); ?></option>
					<option value="tr" <?php if ( 'tr' == $options['recaptcha']['lang'] ) echo 'selected="selected"'; ?>><?php _e('TR','autotrader'); ?></option>
				</select>				
			</li>			
	
			<li>
				<p class="submit">
					<input type="hidden" id="autotrader_submit" value="1" name="autotrader_submit"/>
					<input class="button-primary" type="submit" name="submit" value="<?php esc_attr_e('Save Changes', 'autotrader') ?>" />
				</p>
				<div class="clear"></div>
			</li>			
		</ul>
<?php
	}

	function map_opt_contentbox( $options ) {

?>
		<ul>
			<li>
				<label for="dox_theme_options[map][enable]">
					<input name="dox_theme_options[map][enable]" type="checkbox" id="dox_theme_options[map][enable]" value="true" <?php if (isset($options['map']['enable']) && $options['map']['enable'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Enable Map', 'autotrader') ?>
				</label>
				<div class="clear"></div>
			</li>
		
			<li>
				<label for="dox_theme_options[map][lat]"><?php esc_html_e('Default Latitude', 'autotrader'); ?></label>
				<input name="dox_theme_options[map][lat]" id="dox_theme_options[map][lat]" type="text" class="medium-text" value="<?php echo esc_attr($options['map']['lat']); ?>" />
			</li>
			
			<li>
				<label for="dox_theme_options[map][long]"><?php esc_html_e('Default Longitude', 'autotrader'); ?></label>
				<input name="dox_theme_options[map][long]" id="dox_theme_options[map][long]" type="text" class="medium-text" value="<?php echo esc_attr($options['map']['long']); ?>" />
			</li>
			
			<li>
				<label for="dox_theme_options[map][zoom]"><?php esc_html_e('Default Zoom', 'autotrader'); ?></label>
				<input name="dox_theme_options[map][zoom]" id="dox_theme_options[map][zoom]" type="text" class="small-text" value="<?php echo esc_attr($options['map']['zoom']); ?>" />
			</li>					
	
			<li>
				<p class="submit">
					<input type="hidden" id="autotrader_submit" value="1" name="autotrader_submit"/>
					<input class="button-primary" type="submit" name="submit" value="<?php esc_attr_e('Save Changes', 'autotrader') ?>" />
				</p>
				<div class="clear"></div>
			</li>			
		</ul>
<?php
	}
	
	function color_opt_contentbox( $options ) {

?>
		<ul>
			<li>
				<label for="dox_theme_options[color][enable]">
					<input name="dox_theme_options[color][enable]" type="checkbox" id="dox_theme_options[color][enable]" value="true" <?php if (isset($options['color']['enable']) && $options['color']['enable'] == 'true') echo 'checked="true"'; ?> />
					<?php esc_attr_e('Enable Custom Colors', 'autotrader') ?>
				</label>
				<div class="clear"></div>
			</li>
		</ul>
		
		<div class="color-wrap">
			<h3 class="nav-tab-wrapper">
				<a href="general-tab" class="nav-tab nav-tab-active"><?php esc_html_e('General', 'autotrader'); ?></a>
				<a href="panel-tab" class="nav-tab"><?php esc_html_e('Panel', 'autotrader'); ?></a>
				<a href="header-tab" class="nav-tab"><?php esc_html_e('Header', 'autotrader'); ?></a>
				<a href="content-tab" class="nav-tab"><?php esc_html_e('Content', 'autotrader'); ?></a>
				<a href="footer-tab" class="nav-tab"><?php esc_html_e('Footer', 'autotrader'); ?></a>
				<a href="listing-tab" class="nav-tab"><?php esc_html_e('Listing', 'autotrader'); ?></a>
				<a href="grid-tab" class="nav-tab"><?php esc_html_e('Grid', 'autotrader'); ?></a>
				<a href="form-tab" class="nav-tab"><?php esc_html_e('Form', 'autotrader'); ?></a>
				<a href="alert-tab" class="nav-tab"><?php esc_html_e('Alert', 'autotrader'); ?></a>			
			</h3>
			
			<div class="general-tab dox-tab">
				<ul>
					<li>
						<label for="dox_theme_options[color][general][color]"><?php esc_html_e('General Text Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][general][color]" id="dox_theme_options[color][general][color]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['general']['color']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['general']['color']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][general][background]"><?php esc_html_e('Body Background Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][general][background]" id="dox_theme_options[color][general][background]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['general']['background']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['general']['background']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][general][sectionTitle]"><?php esc_html_e('Section Title', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][general][sectionTitle]" id="dox_theme_options[color][general][sectionTitle]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['general']['sectionTitle']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['general']['sectionTitle']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][general][sectionTitleBorder]"><?php esc_html_e('Section Title Border', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][general][sectionTitleBorder]" id="dox_theme_options[color][general][sectionTitleBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['general']['sectionTitleBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['general']['sectionTitleBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][general][pageTitleBorder]"><?php esc_html_e('Page Title Border', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][general][pageTitleBorder]" id="dox_theme_options[color][general][pageTitleBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['general']['pageTitleBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['general']['pageTitleBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>					
					<li>
						<label for="dox_theme_options[color][general][link]"><?php esc_html_e('Link Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][general][link]" id="dox_theme_options[color][general][link]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['general']['link']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['general']['link']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][general][linkHover]"><?php esc_html_e('Link Hover Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][general][linkHover]" id="dox_theme_options[color][general][linkHover]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['general']['linkHover']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['general']['linkHover']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][general][formElementColor]"><?php esc_html_e('Input Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][general][formElementColor]" id="dox_theme_options[color][general][formElementColor]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['general']['formElementColor']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['general']['formElementColor']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][general][formElementBorder]"><?php esc_html_e('Input Border Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][general][formElementBorder]" id="dox_theme_options[color][general][formElementBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['general']['formElementBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['general']['formElementBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][general][buttonColor]"><?php esc_html_e('Button Text Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][general][buttonColor]" id="dox_theme_options[color][general][buttonColor]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['general']['buttonColor']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['general']['buttonColor']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][general][buttonBackground]"><?php esc_html_e('Button Background Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][general][buttonBackground]" id="dox_theme_options[color][general][buttonBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['general']['buttonBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['general']['buttonBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][general][buttonHoverColor]"><?php esc_html_e('Button Hover Text Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][general][buttonHoverColor]" id="dox_theme_options[color][general][buttonHoverColor]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['general']['buttonHoverColor']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['general']['buttonHoverColor']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][general][buttonHoverBackground]"><?php esc_html_e('Button Hover Background Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][general][buttonHoverBackground]" id="dox_theme_options[color][general][buttonHoverBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['general']['buttonHoverBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['general']['buttonHoverBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][general][textShadow]"><?php esc_html_e('Text Shadow Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][general][textShadow]" id="dox_theme_options[color][general][textShadow]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['general']['textShadow']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['general']['textShadow']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][general][textShadowOpacity]"><?php esc_html_e('Text Shadow Opacity', 'autotrader'); ?></label>
						<input name="dox_theme_options[color][general][textShadowOpacity]" id="dox_theme_options[color][general][textShadowOpacity]" type="text" class="small-text" value="<?php echo esc_attr($options['color']['general']['textShadowOpacity']); ?>" />
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>					
				</ul>				
			</div>
			
			<div class="panel-tab dox-tab" style="display:none">
				<ul>
					<li>
						<label for="dox_theme_options[color][topPanel][color]"><?php esc_html_e('Top Panel Text Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][topPanel][color]" id="dox_theme_options[color][topPanel][color]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['topPanel']['color']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['topPanel']['color']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][topPanel][background]"><?php esc_html_e('Top Panel Background Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][topPanel][background]" id="dox_theme_options[color][topPanel][background]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['topPanel']['background']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['topPanel']['background']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][topPanel][title]"><?php esc_html_e('Title', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][topPanel][title]" id="dox_theme_options[color][topPanel][title]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['topPanel']['title']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['topPanel']['title']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][topPanel][titleBorder]"><?php esc_html_e('Title Border', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][topPanel][titleBorder]" id="dox_theme_options[color][topPanel][titleBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['topPanel']['titleBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['topPanel']['titleBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][topPanel][link]"><?php esc_html_e('Link Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][topPanel][link]" id="dox_theme_options[color][topPanel][link]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['topPanel']['link']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['topPanel']['link']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][topPanel][linkHover]"><?php esc_html_e('Link Hover Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][topPanel][linkHover]" id="dox_theme_options[color][topPanel][linkHover]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['topPanel']['linkHover']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['topPanel']['linkHover']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][topPanel][formElementColor]"><?php esc_html_e('Input Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][topPanel][formElementColor]" id="dox_theme_options[color][topPanel][formElementColor]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['topPanel']['formElementColor']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['topPanel']['formElementColor']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][topPanel][formElementBorder]"><?php esc_html_e('Input Border Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][topPanel][formElementBorder]" id="dox_theme_options[color][topPanel][formElementBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['topPanel']['formElementBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['topPanel']['formElementBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][topPanel][buttonColor]"><?php esc_html_e('Button Text Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][topPanel][buttonColor]" id="dox_theme_options[color][topPanel][buttonColor]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['topPanel']['buttonColor']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['topPanel']['buttonColor']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][topPanel][buttonBackground]"><?php esc_html_e('Button Background Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][topPanel][buttonBackground]" id="dox_theme_options[color][topPanel][buttonBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['topPanel']['buttonBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['topPanel']['buttonBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][topPanel][buttonHoverColor]"><?php esc_html_e('Button Hover Text Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][topPanel][buttonHoverColor]" id="dox_theme_options[color][topPanel][buttonHoverColor]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['topPanel']['buttonHoverColor']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['topPanel']['buttonHoverColor']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][topPanel][buttonHoverBackground]"><?php esc_html_e('Button Hover Background Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][topPanel][buttonHoverBackground]" id="dox_theme_options[color][topPanel][buttonHoverBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['topPanel']['buttonHoverBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['topPanel']['buttonHoverBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>					
				</ul>				
			</div>

			<div class="header-tab dox-tab" style="display:none">
				<ul>
					<li>
						<label for="dox_theme_options[color][header][backgroundRGB]"><?php esc_html_e('Background Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][header][backgroundRGB]" id="dox_theme_options[color][header][backgroundRGB]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['header']['backgroundRGB']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['header']['backgroundRGB']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>					
					<li>
						<label for="dox_theme_options[color][header][backgroundA]"><?php esc_html_e('Background Color Opacity', 'autotrader'); ?></label>
						<input name="dox_theme_options[color][header][backgroundA]" id="dox_theme_options[color][header][backgroundA]" type="text" class="small-text" value="<?php echo esc_attr($options['color']['header']['backgroundA']); ?>" />
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][header][background]"><?php esc_html_e('Background Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][header][background]" id="dox_theme_options[color][header][background]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['header']['background']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['header']['background']); ?>"></div>
						<span class="description"><?php esc_html_e('Background color for browsers which do not support RGBA', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][header][borderTop]"><?php esc_html_e('Border Top Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][header][borderTop]" id="dox_theme_options[color][header][borderTop]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['header']['borderTop']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['header']['borderTop']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>					
					<li>
						<label for="dox_theme_options[color][header][borderBottom]"><?php esc_html_e('Border Bottom Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][header][borderBottom]" id="dox_theme_options[color][header][borderBottom]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['header']['borderBottom']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['header']['borderBottom']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][header][navLink]"><?php esc_html_e('Navigation Link Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][header][navLink]" id="dox_theme_options[color][header][navLink]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['header']['navLink']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['header']['navLink']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][header][navLinkHover]"><?php esc_html_e('Navigation Link Hover Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][header][navLinkHover]" id="dox_theme_options[color][header][navLinkHover]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['header']['navLinkHover']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['header']['navLinkHover']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][header][navBackground]"><?php esc_html_e('Navigation Background Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][header][navBackground]" id="dox_theme_options[color][header][navBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['header']['navBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['header']['navBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][header][navBorder]"><?php esc_html_e('Navigation Border Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][header][navBorder]" id="dox_theme_options[color][header][navBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['header']['navBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['header']['navBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>					
				</ul>			
			</div>
			
			<div class="content-tab dox-tab" style="display:none">
				<ul>
					<li>
						<label for="dox_theme_options[color][content][link]"><?php esc_html_e('Link Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][content][link]" id="dox_theme_options[color][content][link]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['content']['link']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['content']['link']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][content][linkHover]"><?php esc_html_e('Link Hover Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][content][linkHover]" id="dox_theme_options[color][content][linkHover]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['content']['linkHover']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['content']['linkHover']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][content][thumbContainerBackground]"><?php esc_html_e('Thumbnail Bacground Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][content][thumbContainerBackground]" id="dox_theme_options[color][content][thumbContainerBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['content']['thumbContainerBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['content']['thumbContainerBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][content][itemBorder]"><?php esc_html_e('Item Border Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][content][itemBorder]" id="dox_theme_options[color][content][itemBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['content']['itemBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['content']['itemBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][content][featuresBlockBackground]"><?php esc_html_e('Auto Features Background Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][content][featuresBlockBackground]" id="dox_theme_options[color][content][featuresBlockBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['content']['featuresBlockBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['content']['featuresBlockBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][content][pagerBackground]"><?php esc_html_e('Pager Background Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][content][pagerBackground]" id="dox_theme_options[color][content][pagerBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['content']['pagerBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['content']['pagerBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][content][pagerBorder]"><?php esc_html_e('Pager Border Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][content][pagerBorder]" id="dox_theme_options[color][content][pagerBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['content']['pagerBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['content']['pagerBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][content][pagerItemBorder]"><?php esc_html_e('Pager Link Border Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][content][pagerItemBorder]" id="dox_theme_options[color][content][pagerItemBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['content']['pagerItemBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['content']['pagerItemBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][content][pagerLink]"><?php esc_html_e('Pager Text Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][content][pagerLink]" id="dox_theme_options[color][content][pagerLink]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['content']['pagerLink']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['content']['pagerLink']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][content][metaColor]"><?php esc_html_e('Meta Text Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][content][metaColor]" id="dox_theme_options[color][content][metaColor]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['content']['metaColor']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['content']['metaColor']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][content][blockquoteBorder]"><?php esc_html_e('Blockquote Border Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][content][blockquoteBorder]" id="dox_theme_options[color][content][blockquoteBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['content']['blockquoteBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['content']['blockquoteBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][content][widgetTitleBorder]"><?php esc_html_e('Widget Title Border', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][content][widgetTitleBorder]" id="dox_theme_options[color][content][widgetTitleBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['content']['widgetTitleBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['content']['widgetTitleBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][content][widgetPostItemBorder]"><?php esc_html_e('Widget Items Border', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][content][widgetPostItemBorder]" id="dox_theme_options[color][content][widgetPostItemBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['content']['widgetPostItemBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['content']['widgetPostItemBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][home][slideNavBackground]"><?php esc_html_e('Home Navigation Button Background', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][home][slideNavBackground]" id="dox_theme_options[color][home][slideNavBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['home']['slideNavBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['home']['slideNavBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][home][slideNavHoverBackground]"><?php esc_html_e('Home Navigation Button Hover Background', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][home][slideNavHoverBackground]" id="dox_theme_options[color][home][slideNavHoverBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['home']['slideNavHoverBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['home']['slideNavHoverBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][home][browseCatTitle]"><?php esc_html_e('Home Browse Title', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][home][browseCatTitle]" id="dox_theme_options[color][home][browseCatTitle]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['home']['browseCatTitle']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['home']['browseCatTitle']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][home][browseCatBorder]"><?php esc_html_e('Home Browse Title Border', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][home][browseCatBorder]" id="dox_theme_options[color][home][browseCatBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['home']['browseCatBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['home']['browseCatBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][home][searchBackground]"><?php esc_html_e('Home Search Background', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][home][searchBackground]" id="dox_theme_options[color][home][searchBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['home']['searchBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['home']['searchBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][home][searchBorder]"><?php esc_html_e('Home Search Border Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][home][searchBorder]" id="dox_theme_options[color][home][searchBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['home']['searchBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['home']['searchBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][home][imageZoomBackgroundRGB]"><?php esc_html_e('Image Zoom Background', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][home][imageZoomBackgroundRGB]" id="dox_theme_options[color][home][imageZoomBackgroundRGB]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['home']['imageZoomBackgroundRGB']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['home']['imageZoomBackgroundRGB']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][home][imageZoomBackgroundA]"><?php esc_html_e('Image Zoom Background Opacity', 'autotrader'); ?></label>
						<input name="dox_theme_options[color][home][imageZoomBackgroundA]" id="dox_theme_options[color][home][imageZoomBackgroundA]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['home']['imageZoomBackgroundA']); ?>" />
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>					
					<li>
						<label for="dox_theme_options[color][home][imageZoomBackground]"><?php esc_html_e('Image Zoom Background', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][home][imageZoomBackground]" id="dox_theme_options[color][home][imageZoomBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['home']['imageZoomBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['home']['imageZoomBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('Background color for browsers which do not support RGBA', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>										
				</ul>			
			</div>			

			<div class="footer-tab dox-tab" style="display:none">
				<ul>
					<li>
						<label for="dox_theme_options[color][footer][color]"><?php esc_html_e('Text Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][footer][color]" id="dox_theme_options[color][footer][color]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['footer']['color']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['footer']['color']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][footer][backgroundRGB]"><?php esc_html_e('Background Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][footer][backgroundRGB]" id="dox_theme_options[color][footer][backgroundRGB]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['footer']['backgroundRGB']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['footer']['backgroundRGB']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][footer][backgroundA]"><?php esc_html_e('Background Color Opacity', 'autotrader'); ?></label>
						<input name="dox_theme_options[color][footer][backgroundA]" id="dox_theme_options[color][footer][backgroundA]" type="text" class="small-text" value="<?php echo esc_attr($options['color']['footer']['backgroundA']); ?>" />
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][footer][background]"><?php esc_html_e('Background Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][footer][background]" id="dox_theme_options[color][footer][background]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['footer']['background']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['footer']['background']); ?>"></div>
						<span class="description"><?php esc_html_e('Background color for browsers which do not support RGBA', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>					
					<li>
						<label for="dox_theme_options[color][footer][borderTop]"><?php esc_html_e('Border Top Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][footer][borderTop]" id="dox_theme_options[color][footer][borderTop]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['footer']['borderTop']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['footer']['borderTop']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][footer][infoBackgroundRGB]"><?php esc_html_e('Information Block Background Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][footer][infoBackgroundRGB]" id="dox_theme_options[color][footer][infoBackgroundRGB]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['footer']['infoBackgroundRGB']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['footer']['infoBackgroundRGB']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][footer][infoBackgroundA]"><?php esc_html_e('Information Block Background Opacity', 'autotrader'); ?></label>
						<input name="dox_theme_options[color][footer][infoBackgroundA]" id="dox_theme_options[color][footer][infoBackgroundA]" type="text" class="small-text" value="<?php echo esc_attr($options['color']['footer']['infoBackgroundA']); ?>" />
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>					
					<li>
						<label for="dox_theme_options[color][footer][infoBackground]"><?php esc_html_e('Information Block Background', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][footer][infoBackground]" id="dox_theme_options[color][footer][infoBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['footer']['infoBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['footer']['infoBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('Background color for browsers which do not support RGBA', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][footer][link]"><?php esc_html_e('Link Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][footer][link]" id="dox_theme_options[color][footer][link]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['footer']['link']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['footer']['link']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][footer][linkHover]"><?php esc_html_e('Link Hover Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][footer][linkHover]" id="dox_theme_options[color][footer][linkHover]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['footer']['linkHover']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['footer']['linkHover']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][footer][itemBorder]"><?php esc_html_e('Item Border Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][footer][itemBorder]" id="dox_theme_options[color][footer][itemBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['footer']['itemBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['footer']['itemBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>					
					<li>
						<label for="dox_theme_options[color][footer][bottomColor]"><?php esc_html_e('Bottom Block Text Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][footer][bottomColor]" id="dox_theme_options[color][footer][bottomColor]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['footer']['bottomColor']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['footer']['bottomColor']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][footer][bottomLink]"><?php esc_html_e('Bottom Block Link Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][footer][bottomLink]" id="dox_theme_options[color][footer][bottomLink]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['footer']['bottomLink']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['footer']['bottomLink']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][footer][bottomBackgroundRGB]"><?php esc_html_e('Bottom Block Background Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][footer][bottomBackgroundRGB]" id="dox_theme_options[color][footer][bottomBackgroundRGB]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['footer']['bottomBackgroundRGB']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['footer']['bottomBackgroundRGB']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][footer][bottomBackgroundA]"><?php esc_html_e('Bottom Block Background Opacity', 'autotrader'); ?></label>
						<input name="dox_theme_options[color][footer][bottomBackgroundA]" id="dox_theme_options[color][footer][bottomBackgroundA]" type="text" class="small-text" value="<?php echo esc_attr($options['color']['footer']['bottomBackgroundA']); ?>" />
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>					
					<li>
						<label for="dox_theme_options[color][footer][bottomBackground]"><?php esc_html_e('Bottom Block Background', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][footer][bottomBackground]" id="dox_theme_options[color][footer][bottomBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['footer']['bottomBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['footer']['bottomBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('Background color for browsers which do not support RGBA', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>					
				</ul>			
			</div>

			<div class="listing-tab dox-tab" style="display:none">
				<ul>
					<li>
						<label for="dox_theme_options[color][listing][border]"><?php esc_html_e('Border Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][listing][border]" id="dox_theme_options[color][listing][border]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['listing']['border']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['listing']['border']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][listing][buttonColor]"><?php esc_html_e('Button Text Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][listing][buttonColor]" id="dox_theme_options[color][listing][buttonColor]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['listing']['buttonColor']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['listing']['buttonColor']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][listing][buttonBackground]"><?php esc_html_e('Button Background Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][listing][buttonBackground]" id="dox_theme_options[color][listing][buttonBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['listing']['buttonBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['listing']['buttonBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>					
					<li>
						<label for="dox_theme_options[color][listing][pagerColor]"><?php esc_html_e('Pager Text Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][listing][pagerColor]" id="dox_theme_options[color][listing][pagerColor]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['listing']['pagerColor']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['listing']['pagerColor']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][listing][pagerBackground]"><?php esc_html_e('Pager Background Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][listing][pagerBackground]" id="dox_theme_options[color][listing][pagerBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['listing']['pagerBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['listing']['pagerBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][listing][pagerBorder]"><?php esc_html_e('Pager Border Border', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][listing][pagerBorder]" id="dox_theme_options[color][listing][pagerBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['listing']['pagerBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['listing']['pagerBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][listing][pagerItemBorder]"><?php esc_html_e('Pager Link Border Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][listing][pagerItemBorder]" id="dox_theme_options[color][listing][pagerItemBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['listing']['pagerItemBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['listing']['pagerItemBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][listing][pagerLink]"><?php esc_html_e('Pager Link Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][listing][pagerLink]" id="dox_theme_options[color][listing][pagerLink]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['listing']['pagerLink']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['listing']['pagerLink']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>					
				</ul>			
			</div>

			<div class="grid-tab dox-tab" style="display:none">
				<ul>
					<li>
						<label for="dox_theme_options[color][grid][link]"><?php esc_html_e('Link Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][grid][link]" id="dox_theme_options[color][grid][link]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['grid']['link']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['grid']['link']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][grid][linkHover]"><?php esc_html_e('Link Hover Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][grid][linkHover]" id="dox_theme_options[color][grid][linkHover]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['grid']['linkHover']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['grid']['linkHover']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][grid][background]"><?php esc_html_e('Background Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][grid][background]" id="dox_theme_options[color][grid][background]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['grid']['background']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['grid']['background']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>					
					<li>
						<label for="dox_theme_options[color][grid][headerBackground]"><?php esc_html_e('Header Background', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][grid][headerBackground]" id="dox_theme_options[color][grid][headerBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['grid']['headerBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['grid']['headerBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][grid][headerBorder]"><?php esc_html_e('Header Border Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][grid][headerBorder]" id="dox_theme_options[color][grid][headerBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['grid']['headerBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['grid']['headerBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][grid][gridItemBackground]"><?php esc_html_e('Grid Row Background', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][grid][gridItemBackground]" id="dox_theme_options[color][grid][gridItemBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['grid']['gridItemBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['grid']['gridItemBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][grid][gridItemBackgroundAlt]"><?php esc_html_e('Grid Alternate Row Background', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][grid][gridItemBackgroundAlt]" id="dox_theme_options[color][grid][gridItemBackgroundAlt]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['grid']['gridItemBackgroundAlt']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['grid']['gridItemBackgroundAlt']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][grid][gridItemBorder]"><?php esc_html_e('Row Border Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][grid][gridItemBorder]" id="dox_theme_options[color][grid][gridItemBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['grid']['gridItemBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['grid']['gridItemBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][grid][pagerBorder]"><?php esc_html_e('Pager Border Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][grid][pagerBorder]" id="dox_theme_options[color][grid][pagerBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['grid']['pagerBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['grid']['pagerBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>					
				</ul>			
			</div>

			<div class="form-tab dox-tab" style="display:none">
				<ul>
					<li>
						<label for="dox_theme_options[color][form][link]"><?php esc_html_e('Link Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][form][link]" id="dox_theme_options[color][form][link]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['form']['link']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['form']['link']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][form][linkHover]"><?php esc_html_e('Link Hover Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][form][linkHover]" id="dox_theme_options[color][form][linkHover]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['form']['linkHover']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['form']['linkHover']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][form][background]"><?php esc_html_e('Background Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][form][background]" id="dox_theme_options[color][form][background]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['form']['background']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['form']['background']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>					
					<li>
						<label for="dox_theme_options[color][form][itemBorder]"><?php esc_html_e('Form Item Border', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][form][itemBorder]" id="dox_theme_options[color][form][itemBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['form']['itemBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['form']['itemBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][form][navBackground]"><?php esc_html_e('Navigation Background', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][form][navBackground]" id="dox_theme_options[color][form][navBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['form']['navBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['form']['navBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][form][navBorder]"><?php esc_html_e('Navigation Border Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][form][navBorder]" id="dox_theme_options[color][form][navBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['form']['navBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['form']['navBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][form][selectedBackground]"><?php esc_html_e('Selected Tab Background', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][form][selectedBackground]" id="dox_theme_options[color][form][selectedBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['form']['selectedBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['form']['selectedBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][form][selectedBorder]"><?php esc_html_e('Selected Tab Border Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][form][selectedBorder]" id="dox_theme_options[color][form][selectedBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['form']['selectedBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['form']['selectedBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][form][errorBackground]"><?php esc_html_e('Error Tab Background', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][form][errorBackground]" id="dox_theme_options[color][form][errorBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['form']['errorBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['form']['errorBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
										<li>
						<label for="dox_theme_options[color][form][errorBorder]"><?php esc_html_e('Error Tab Border Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][form][errorBorder]" id="dox_theme_options[color][form][errorBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['form']['errorBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['form']['errorBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][form][passedBackground]"><?php esc_html_e('Success Tab Background', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][form][passedBackground]" id="dox_theme_options[color][form][passedBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['form']['passedBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['form']['passedBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][form][passedBorder]"><?php esc_html_e('Success Tab Border Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][form][passedBorder]" id="dox_theme_options[color][form][passedBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['form']['passedBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['form']['passedBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][form][errorColor]"><?php esc_html_e('Error Text Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][form][errorColor]" id="dox_theme_options[color][form][errorColor]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['form']['errorColor']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['form']['errorColor']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>					
				</ul>			
			</div>

			<div class="alert-tab dox-tab" style="display:none">
				<ul>
					<li>
						<label for="dox_theme_options[color][alert][labelRed]"><?php esc_html_e('Error Label Text Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][alert][labelRed]" id="dox_theme_options[color][alert][labelRed]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['alert']['labelRed']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['alert']['labelRed']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][alert][successColor]"><?php esc_html_e('Success Alert Text Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][alert][successColor]" id="dox_theme_options[color][alert][successColor]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['alert']['successColor']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['alert']['successColor']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][alert][successBorder]"><?php esc_html_e('Success Alert Border Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][alert][successBorder]" id="dox_theme_options[color][alert][successBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['alert']['successBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['alert']['successBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][alert][successBackground]"><?php esc_html_e('Success Alert Background', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][alert][successBackground]" id="dox_theme_options[color][alert][successBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['alert']['successBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['alert']['successBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][alert][errorColor]"><?php esc_html_e('Error Alert Text Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][alert][errorColor]" id="dox_theme_options[color][alert][errorColor]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['alert']['errorColor']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['alert']['errorColor']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][alert][errorBorder]"><?php esc_html_e('Error Alert Border Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][alert][errorBorder]" id="dox_theme_options[color][alert][errorBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['alert']['errorBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['alert']['errorBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][alert][errorBackground]"><?php esc_html_e('Error Alert Background', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][alert][errorBackground]" id="dox_theme_options[color][alert][errorBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['alert']['errorBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['alert']['errorBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][alert][warningColor]"><?php esc_html_e('Warning Alert Text Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][alert][warningColor]" id="dox_theme_options[color][alert][warningColor]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['alert']['warningColor']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['alert']['warningColor']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][alert][warningBorder]"><?php esc_html_e('Warning Alert Border Color', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][alert][warningBorder]" id="dox_theme_options[color][alert][warningBorder]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['alert']['warningBorder']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['alert']['warningBorder']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>
					<li>
						<label for="dox_theme_options[color][alert][warningBackground]"><?php esc_html_e('Warning Alert Background', 'autotrader'); ?></label>
						<span class="dash">#</span>
						<input name="dox_theme_options[color][alert][warningBackground]" id="dox_theme_options[color][alert][warningBackground]" type="text" class="small-text colorbox" value="<?php echo esc_attr($options['color']['alert']['warningBackground']); ?>" />
						<div class="colorshow" style="background-color:#<?php echo esc_attr($options['color']['alert']['warningBackground']); ?>"></div>
						<span class="description"><?php esc_html_e('', 'autotrader'); ?></span>
						<div class="clear"></div>
					</li>					
				</ul>			
			</div>			
			
			<div class="clear"></div>
		</div>
		<li>
			<p class="submit">
				<input type="hidden" id="autotrader_submit" value="1" name="autotrader_submit"/>
				<input class="button-primary" type="submit" name="submit" value="<?php esc_attr_e('Save Changes', 'autotrader') ?>" />
			</p>
			<div class="clear"></div>
		</li>
<?php
	}		
	
}

$dox_admin = new DOX_Admin();
$dox_options = $dox_admin->get_options();

?>
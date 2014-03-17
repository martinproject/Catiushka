<?php
/**
 * Theme Functions
 */
 
 
 /**
* Retrieve auto video embed code
*
* @package Autotrader
* @since 1.1.0
*
* @param sting $video_id
* @param sting $video_source
* @param int $width
*
* @return embed_code
*/
function dox_get_video_embed($video_id, $video_source) {
	
	$output = '';
	
	switch ( $video_source ) {
		case 'YOUTUBE':
			$output = dox_get_youtube_code($video_id, 380, 228);
			break;
		case 'VIMEO':
			$output = dox_get_vimeo_code($video_id, 380, 228);
			break;
		case 'VIDDLER':
			$output = dox_get_viddler_code($video_id, 380, 243);
			break;
		default:
			$output = '';
			break;					
	}
	
	return $output;
}

 /**
* Retrieve youtube embed code
*
* @package Autotrader
* @since 1.1.0
*
* @param sting $video_id
* @param int $width
*
* @return embed_code
*/
function dox_get_youtube_code($video_id, $width, $height) {
	
	$output = '';
	$output .= '<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video_id.'" frameborder="0" allowfullscreen></iframe>';
		
	return $output;	
}

 /**
* Retrieve vimeo embed code
*
* @package Autotrader
* @since 1.1.0
*
* @param sting $video_id
* @param int $width
*
* @return embed_code
*/
function dox_get_vimeo_code($video_id, $width, $height) {
	
	$output = '';
	$output .= '<iframe src="http://player.vimeo.com/video/'.$video_id.'" width="'.$width.'" height="'.$height.'" frameborder="0"></iframe>';
		
	return $output;	
}

 /**
* Retrieve viddler embed code
*
* @package Autotrader
* @since 1.1.0
*
* @param sting $video_id
* @param int $width
*
* @return embed_code
*/
function dox_get_viddler_code($video_id, $width, $height) {
	
	$output = '';
	$output .= '<iframe id="viddler-'.$video_id.'" src="http://www.viddler.com/embed/'.$video_id.'/?f=1&offset=0&autoplay=0&disablebranding=0" width="'.$width.'" height="'.$height.' frameborder="0"></iframe>';
		
	return $output;	
}

/**
* Retrieve auto ad photo's thumbs
*
* @package Autotrader
* @since 1.0.0
*
* @param int $post_id
*
* @return html.tags
*/
function dox_get_slide_thumbs($post_id) {

	global $wpdb;
	
	$query = "SELECT p.ID AS ID FROM $wpdb->posts AS p
					WHERE p.post_parent = '$post_id' AND p.post_type = 'attachment' AND p.post_status = 'inherit'";

	$attachments = $wpdb->get_results($query);
	
	$max = count($attachments);
	$result = '';
	$count = 0;
	foreach($attachments as $attachment) {
		
		$count = $count + 1;
		
		if ( $count == 1 ) {
			$result .= '<div class="tj_wrapper"><ul class="tj_gallery">';
		}
		
		$image = wp_get_attachment_image_src( $attachment->ID, 'small' );
		$slide_thumb = $image[0];
		$image = wp_get_attachment_image_src( $attachment->ID, 'full' );
		$main_thumb = $image[0];
		
		$result .= '<li><a href="'.$main_thumb.'" rel="prettyPhoto[gallery]" class="image-zoom slide-thumb-zoom"><img src="'.$slide_thumb.'"/><span class="zoom-icon"></span></a></li>';
		
		if ( $count == $max ) {
			$result .= '</ul></div>';
		}
	}

	echo $result;
}

/**
* Check reCaptcha field
* Ajax function
*
* @package Autotrader
* @since 1.1
*
* @param string $_REQUEST['challenge_field']
* @param string $_REQUEST['response_field']
* @param string $_REQUEST['remote_ip'];
*
* @return json.data
*/
function dox_check_recaptcha() {

	global $dox_options;
	
	$private_key = $dox_options['recaptcha']['private_key'];
	$challenge_field = $_REQUEST['challenge_field'];
	$response_field = $_REQUEST['response_field'];
	$remote_ip = $_REQUEST['remote_ip'];

	if ( !function_exists('_recaptcha_qsencode') ) {
		require_once( TEMPLATEPATH . '/functions/includes/recaptchalib.php');
		
		$response = recaptcha_check_answer ($private_key,
						$remote_ip,
						$challenge_field,
						$response_field);						
	}
	
	
	if ($response->is_valid == 'true') {
			echo json_encode( array("alert" => "alert-success", 
									"message" => __('reCaptcha valid.','autotrader') ) );
	}
	else {
			switch ( $response->error ) {
				case 'invalid-site-private-key':
					$message = __('We weren"t able to verify the private key.','autotrader');
					break;
				case 'invalid-request-cookie':
					$message = __('The challenge parameter of the verify script was incorrect.','autotrader');
					break;
				case 'incorrect-captcha-sol':
					$message = __('The CAPTCHA solution was incorrect.','autotrader');
					break;
				case 'recaptcha-not-reachable':
					$message = __('CAPTCHA error','autotrader');
					break;
				default:
					$message = __('CAPTCHA error','autotrader');
					break;					
			}
			echo json_encode( array("alert" => "alert-error", 
									"message" => $message ) );
	}
	
	// Do not delete..
	die();	
}

add_action('wp_ajax_nopriv_dox_check_recaptcha', 'dox_check_recaptcha');
add_action('wp_ajax_dox_check_recaptcha', 'dox_check_recaptcha');


/**
* Sending e-mail
* Ajax function
*
* @package Autotrader
* @since 1.0.0
*
* @param string $_REQUEST['name']
* @param string $_REQUEST['email']
* @param string $_REQUEST['phone'] optional
* @param string $_REQUEST['message']
* @param string $_REQUEST['title']
* @param string $_REQUEST['mailto']
*
* @return json.data
*/
function dox_send_mail(){

	global $dox_options;

	$error = false;

	$name = trim($_REQUEST['name']);
	$email = trim($_REQUEST['email']);
	$phone = trim($_REQUEST['phone']);
	$title = trim($_REQUEST['title']);
	$message = trim($_REQUEST['message']);
	$mailto = trim($_REQUEST['mailto']);
	
	// if $mailto equals to "to-me", it means the message will go to admin's mail
	if ($mailto == 'to-me') $mailto = $dox_options['general']['contact_email'];
		else { 
			$ad_permalink = get_permalink( intval($mailto) );
			$mailto = get_post_meta(intval($mailto), 'auto_email', true); 
		}
	

	// Data controls
	$output = '';
	if($name === '') {
		$output .= __('Please enter your name.', 'autotrader').'<br>';
		$error = true;
	}
	
	if($email === '')  {
		$output .= __('Please enter e-mail address.', 'autotrader').'<br>';
		$error = true;
	} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", $email)) {
		$output .= __('Please enter a valid email address.', 'autotrader').'<br>';
		$error = true;
	}
		
	if($message === '') {
		$output .= __('Please enter your message.', 'autotrader').'<br>';
		$error = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes($message);
		}
	}
	
	if($error == false) {
	
		$subject = __('[Autotrader Message]', 'autotrader').' '.$title;
		$body = __("Name: ","autotrader").$name;
		$body .= __("\n\nEmail: ","autotrader").$email;
		if ($phone != '') $body .= __("\n\nPhone: ","autotrader").$phone;
		if ($ad_permalink != '') $body .= __("\n\nAd URL: ","autotrader").$ad_permalink;
		$body .= __("\n\nMessage: ","autotrader").$message;
		$headers = __('From: no-reply@inoart.com ', 'autotrader').' <'.$emailto.'>' . "\r\n" . __('Reply-To: ','autotrader') . $email;
		
		$mail_sent = false;
		$mail_sent = mail($mailto, $subject, $body, $headers);

		if ($mail_sent == true) {
			echo json_encode( array("alert" => "alert-success", 
									"message" => __('Your message has been sent succesfully.','autotrader') ) );		
		} else {
			$error = true;
			echo json_encode( array("alert" => "alert-error", 
									"message" => __('Sorry, an error occured while sending your message. Please try again.','autotrader') ) );		
		}
	}
	else
	{
		echo json_encode( array("alert" => "alert-error", 
								"message" => $output ) );
	}
	
	
	// Do not delete..
	die();	
		
}

add_action('wp_ajax_nopriv_dox_send_mail', 'dox_send_mail');
add_action('wp_ajax_dox_send_mail', 'dox_send_mail');


/**
* Show user's ad to everyone (at author template)
* Ajax function
*
* @package Autotrader
* @since 1.0.0
*
* @param int $_REQUEST['user_id']
* @param int $_REQUEST['page_nr']
*
* @return json.data
*/
function dox_show_user_ads() {

	global $dox_options;
	
	$error = false;
		
	$tax_query = array();
	$meta_query = array();
	
	// Get parameters from ajax call
	$user_id  = (int)$_REQUEST['user_id'];	
	$page_nr  = (int)$_REQUEST['page_nr'];


	// Prepare query parameter
	$query = array();
	
	$query['post_type'] = $dox_options['ad_set']['type']['base'];
	$query['author'] = $user_id;
	$query['paged'] = $page_nr;
	$query['orderby'] = "date";
	$query['order'] = "DESC";
	$query['post_status'] = "publish";
		
		
	if ($error == false) {
	
		// Process the query
		$autos = new WP_Query( $query );
		
		if ($autos->have_posts()){
		
			// Prepare output data
			$results = '';
			while ( $autos->have_posts() ) : $autos->the_post(); global $post;
				
				$postterms = dox_get_post_term(get_the_ID());
				$permalink = get_permalink($post->ID);
				$ad_date = get_the_time( get_option('date_format') );
				$postClass = get_post_class(); 
				$postThumb = dox_get_post_image($post->ID, 'default-thumb', 'main' );
				
				if ( $dox_options['ad_set']['model']['show'] == 'true' && $dox_options['ad_set']['model']['list'] == 'true' ) {
					$make = get_term_by( 'id', $postterms[$dox_options['ad_set']['model']['query']][0][0], $dox_options['ad_set']['model']['query'] );
					$model = get_term_by( 'id', $postterms[$dox_options['ad_set']['model']['query']][$postterms[$dox_options['ad_set']['model']['query']][0][0]][0], $dox_options['ad_set']['model']['query'] );
				}
				
				if ( $dox_options['ad_set']['location']['show'] == 'true' && $dox_options['ad_set']['location']['list'] == 'true' ) {
					$location = get_term_by( 'id', $postterms[$dox_options['ad_set']['location']['query']][0][0], $dox_options['ad_set']['location']['query'] );
					$city = get_term_by( 'id', $postterms[$dox_options['ad_set']['location']['query']][$postterms[$dox_options['ad_set']['location']['query']][0][0]][0], $dox_options['ad_set']['location']['query'] );
				}
				
				if ( $dox_options['ad_set']['mileage']['show'] == 'true' && $dox_options['ad_set']['mileage']['list'] == 'true' ) { $mileage = get_post_meta($post->ID, $dox_options['ad_set']['mileage']['query'], true); }
				if ( $dox_options['ad_set']['price']['show'] == 'true' && $dox_options['ad_set']['price']['list'] == 'true' ) { $price = get_post_meta($post->ID, $dox_options['ad_set']['price']['query'], true); }
				if ( $dox_options['ad_set']['year']['show'] == 'true' && $dox_options['ad_set']['year']['list'] == 'true' ) { $autoyear = get_term_by( 'id', $postterms[$dox_options['ad_set']['year']['query']][0][0], $dox_options['ad_set']['year']['query'] ); }
				if ( $dox_options['ad_set']['condition']['show'] == 'true' && $dox_options['ad_set']['condition']['list'] == 'true' ) { $condition = get_term_by( 'id', $postterms[$dox_options['ad_set']['condition']['query']][0][0], $dox_options['ad_set']['condition']['query'] ); }
				if ( $dox_options['ad_set']['color']['show'] == 'true' && $dox_options['ad_set']['color']['list'] == 'true' ) { $color = get_term_by( 'id', $postterms[$dox_options['ad_set']['color']['query']][0][0], $dox_options['ad_set']['color']['query'] ); }
				if ( $dox_options['ad_set']['fuelType']['show'] == 'true' && $dox_options['ad_set']['fuelType']['list'] == 'true' ) { $fuelType = get_term_by( 'id', $postterms[$dox_options['ad_set']['fuelType']['query']][0][0], $dox_options['ad_set']['fuelType']['query'] ); }
				if ( $dox_options['ad_set']['bodyType']['show'] == 'true' && $dox_options['ad_set']['bodyType']['list'] == 'true' ) { $bodyType = get_term_by( 'id', $postterms[$dox_options['ad_set']['bodyType']['query']][0][0], $dox_options['ad_set']['bodyType']['query'] ); }
				if ( $dox_options['ad_set']['doors']['show'] == 'true' && $dox_options['ad_set']['doors']['list'] == 'true' ) { $doors = get_post_meta($post->ID, $dox_options['ad_set']['doors']['query'], true); }
				if ( $dox_options['ad_set']['cylinders']['show'] == 'true' && $dox_options['ad_set']['cylinders']['list'] == 'true' ) { $cylinders = get_post_meta($post->ID, $dox_options['ad_set']['cylinders']['query'], true); }
				if ( $dox_options['ad_set']['transmission']['show'] == 'true' && $dox_options['ad_set']['transmission']['list'] == 'true' ) { $transmission = get_term_by( 'id', $postterms[$dox_options['ad_set']['transmission']['query']][0][0], $dox_options['ad_set']['transmission']['query'] ); }
				

				$results .= '<div class="'.$postClass[0].' '.$postClass[1].' '.$postClass[2].' '.$postClass[3].' custom-post-type" id="post-'.$post->ID.'">';
									
					$results .= '<div class="grid_3 clearfix alpha">';
						$results .= '<a href="'.$permalink.'" class="image-zoom main-thumb-zoom" target="_blank">';
							$results .= $postThumb;
							$results .= '<span class="zoom-icon"></span>';
						$results .= '</a>';
					$results .= '</div>';
					$results .= '<div class="grid_5 clearfix omega">';
						$results .= '<h3><a href="'.$permalink.'">'.$post->post_title.'</a></h3>';
						
						$results .= '<div class="grid_3 clearfix alpha">';
							$results .= '<ul class="features">';						
										if ( $dox_options['ad_set']['model']['show'] == 'true' && $dox_options['ad_set']['model']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['model']['name'].'</span> : '.$make->name.' / '.$model->name.'</li>'; }
										if ( $dox_options['ad_set']['location']['show'] == 'true' && $dox_options['ad_set']['location']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['location']['name'].'</span> : '.$location->name.' / '.$city->name.'</li>'; }							
										if ( $dox_options['ad_set']['mileage']['show'] == 'true' && $dox_options['ad_set']['mileage']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['mileage']['name'].'</span> : '.$mileage.'</li>'; }
										if ( $dox_options['ad_set']['year']['show'] == 'true' && $dox_options['ad_set']['year']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['year']['name'].'</span> : '.$autoyear->name.'</li>'; }
										if ( $dox_options['ad_set']['condition']['show'] == 'true' && $dox_options['ad_set']['condition']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['condition']['name'].'</span> : '.$condition->name.'</li>'; }
										if ( $dox_options['ad_set']['color']['show'] == 'true' && $dox_options['ad_set']['color']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['color']['name'].'</span> : '.$color->name.'</li>'; }
										if ( $dox_options['ad_set']['fuelType']['show'] == 'true' && $dox_options['ad_set']['fuelType']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['fuelType']['name'].'</span> : '.$fuelType->name.'</li>'; }
										if ( $dox_options['ad_set']['bodyType']['show'] == 'true' && $dox_options['ad_set']['bodyType']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['bodyType']['name'].'</span> : '.$bodyType->name.'</li>'; }
										if ( $dox_options['ad_set']['doors']['show'] == 'true' && $dox_options['ad_set']['doors']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['doors']['name'].'</span> : '.$doors.'</li>'; }
										if ( $dox_options['ad_set']['cylinders']['show'] == 'true' && $dox_options['ad_set']['cylinders']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['cylinders']['name'].'</span> : '.$cylinders.'</li>'; }
										if ( $dox_options['ad_set']['transmission']['show'] == 'true' && $dox_options['ad_set']['transmission']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['transmission']['name'].'</span> : '.$transmission->name.'</li>'; }
							$results .= '</ul>';
						$results .= '</div>';
						
						$results .= '<div class="grid_2 clearfix omega">';
							if ( $dox_options['ad_set']['price']['show'] == 'true' && $dox_options['ad_set']['price']['list'] == 'true' ) {
								$results .= '<ul class="price">';
											$results .= '<li><span>'.$dox_options['ad_set']['price']['name'].'</span>'.$price.' '.$dox_options['ad']['currency'].'</li>';
								$results .= '</ul>';
							}
					
							$results .= '<a href="?watchlist='.$post->ID.'" class="watchlist-button button">'.__("Add to Watchlist","autotrader").'</a>';
							$results .= '<a href="'.$permalink.'" class="button" target="_blank">'. __("View Details","autotrader").'</a>';
						$results .= '</div>';
						
					$results .= '</div>';
					
				$results .= '</div>';
				
			endwhile;
			
			$pager = dox_pager($page_nr, $autos->max_num_pages, true);
			
			echo json_encode( array("results" => stripslashes( $results ), 
								    "pager" => $pager) );
		}
		else {
			echo json_encode( array("alert" => "alert-warning", 
									"message" => __('No ad could be found.','autotrader')) );
		}

		// Reset Post Data
		wp_reset_postdata();
	}
	else {
		echo json_encode( array("alert" => "alert-error", 
								"message" => __('Sorry, an error occured.','autotrader')) );			
	}
	
	die();
}

add_action('wp_ajax_nopriv_dox_show_user_ads', 'dox_show_user_ads');
add_action('wp_ajax_dox_show_user_ads', 'dox_show_user_ads');

/**
* Show search results
* Ajax function
*
* @package Autotrader
* @since 1.0.0
*
* @param int $_REQUEST['args']
* @param int $_REQUEST['paged']
* @param string $_REQUEST['order_by'] : date, price
* @param string $_REQUEST['order'] : ASC, DESC
*
* @return json.data
*/
function dox_show_search_results() {	
	
	global $dox_options;
	
	$defaults = array(
		'cylinders_min' => '0',
		'cylinders_max' => '0',		
		'doors_min' => '0',
		'doors_max' => '0',
		'mileage_min' => '0',
		'mileage_max' => '0',		
		'price_min' => '0',
		'price_max' => '0',
		'keyword' => ''
	);

	// get search parameters
	$args = $_REQUEST['args'];
	$args = wp_parse_args( $args, $defaults );
	extract( $args, EXTR_SKIP );

	
	$input_condition = array();
	if ($_REQUEST['condition'] != '') {
		$input_condition = explode(',',$_REQUEST['condition']);
		$input_condition = array_diff($input_condition, array("-1", "0"));
	}
	
	$input_make = array();
	if ($_REQUEST['make'] != '') {
		$input_make = explode(',',$_REQUEST['make']);
		$input_make = array_diff($input_make, array("-1", "0"));
	}
	
	$input_model = array();	
	if ($_REQUEST['model'] != '') {
		$input_model = explode(',',$_REQUEST['model']);
		$input_model = array_diff($input_model, array("-1", "0"));
	}
	
	$input_location = array();
	if ($_REQUEST['location'] != '') {	
		$input_location = explode(',',$_REQUEST['location']);
		$input_location = array_diff($input_location, array("-1", "0"));
	}
	
	$input_city = array();
	if ($_REQUEST['city'] != '') {	
		$input_city = explode(',',$_REQUEST['city']);
		$input_city = array_diff($input_city, array("-1", "0"));
	}	
	
	$input_autoyear = array();
	if ($_REQUEST['autoyear'] != '') {
		$input_autoyear = explode(',',$_REQUEST['autoyear']);
		$input_autoyear = array_diff($input_autoyear, array("-1", "0"));
	}
	
	$input_transmission = array();
	if ($_REQUEST['transmission'] != '') {
		$input_transmission = explode(',',$_REQUEST['transmission']);
		$input_transmission = array_diff($input_transmission, array("-1", "0"));
	}
	
	$input_colour = array();
	if ($_REQUEST['colour'] != '') {	
		$input_colour = explode(',',$_REQUEST['colour']);
		$input_colour = array_diff($input_colour, array("-1", "0"));
	}
	
	$input_fuel_type = array();
	if ($_REQUEST['fuel_type'] != '') {
		$input_fuel_type = explode(',',$_REQUEST['fuel_type']);
		$input_fuel_type = array_diff($input_fuel_type, array("-1", "0"));
	}
	
	$input_body_type = array();
	if ($_REQUEST['body_type'] != '') {
		$input_body_type = explode(',',$_REQUEST['body_type']);
		$input_body_type = array_diff($input_body_type, array("-1", "0"));
	}
	
		
	$paged = (int)$_REQUEST['paged'];
	$order = $_REQUEST['order'];
	$orderby = $_REQUEST['orderby'];

	// initialize error parameter
	$error = false;
	
	
	$tax_query = array();
	$meta_query = array();

	
	// Prepare query parameters
	$query = array();	
	$query['post_type'] = $dox_options['ad_set']['type']['base'];
	$query['post_status'] = "publish";
	$query['order'] = $order;
	$query['paged'] = $paged;
	
	if ($orderby == 'date') {
		$query['orderby'] = $orderby;		
	}
	elseif ($orderby == 'price'){
		$query['orderby'] = "meta_value_num";
		$query['meta_key'] = $dox_options['ad_set']['price']['query'];		
	}
	
	
	$tax = array();
	$meta = array();
	
	$tax_query['relation'] = "AND";	

	
	if (! empty($input_condition)) {
		$tax['taxonomy'] = $dox_options['ad_set']['condition']['query'];
		$tax['field'] = "id";
		$tax['terms'] = $input_condition;
		$tax['operator'] = "IN";
		
		$tax_query[] = $tax;
	}
	
	if (! empty($input_make)) {
		$tax['taxonomy'] = $dox_options['ad_set']['model']['query'];
		$tax['field'] = "id";
		$tax['terms'] = $input_make;
		$tax['operator'] = "IN";
		
		$tax_query[] = $tax;
	}
	
	if (! empty($input_model)) {
		$tax['taxonomy'] = $dox_options['ad_set']['model']['query'];
		$tax['field'] = "id";
		$tax['terms'] = $input_model;
		$tax['operator'] = "IN";
		
		$tax_query[] = $tax;
	}
	
	if (! empty($input_location)) {
		$tax['taxonomy'] = $dox_options['ad_set']['location']['query'];
		$tax['field'] = "id";
		$tax['terms'] = $input_location;
		$tax['operator'] = "IN";
		
		$tax_query[] = $tax;
	}
	
	if (! empty($input_city)) {
		$tax['taxonomy'] = $dox_options['ad_set']['location']['query'];
		$tax['field'] = "id";
		$tax['terms'] = $input_city;
		$tax['operator'] = "IN";
		
		$tax_query[] = $tax;
	}	
	
	if (! empty($input_autoyear)) {
		$tax['taxonomy'] = $dox_options['ad_set']['year']['query'];
		$tax['field'] = "id";
		$tax['terms'] = $input_autoyear;
		$tax['operator'] = "IN";
		
		$tax_query[] = $tax;
	}
	
	if (! empty($input_transmission)) {
		$tax['taxonomy'] = $dox_options['ad_set']['transmission']['query'];
		$tax['field'] = "id";
		$tax['terms'] = $input_transmission;
		$tax['operator'] = "IN";
		
		$tax_query[] = $tax;
	}
	
	if (! empty($input_colour)) {
		$tax['taxonomy'] = $dox_options['ad_set']['color']['query'];
		$tax['field'] = "id";
		$tax['terms'] = $input_colour;
		$tax['operator'] = "IN";
		
		$tax_query[] = $tax;
	}
	
	if (! empty($input_fuel_type)) {
		$tax['taxonomy'] = $dox_options['ad_set']['fuelType']['query'];
		$tax['field'] = "id";
		$tax['terms'] = $input_fuel_type;
		$tax['operator'] = "IN";
		
		$tax_query[] = $tax;
	}
	
	if (! empty($input_body_type)) {
		$tax['taxonomy'] = $dox_options['ad_set']['bodyType']['query'];
		$tax['field'] = "id";
		$tax['terms'] = $input_body_type;
		$tax['operator'] = "IN";
		
		$tax_query[] = $tax;
	}

	if ($cylinders_min > 0) {
		$meta['key'] = $dox_options['ad_set']['cylinders']['query'];
		$meta['value'] = $cylinders_min;
		$meta['type'] = "numeric";
		
		if ($cylinders_max > 0) $meta['compare'] = ">=";
			else $meta['compare'] = "==";
					
		$meta_query[] = $meta;
	}

	if ($cylinders_max > 0) {
		$meta['key'] = $dox_options['ad_set']['cylinders']['query'];
		$meta['value'] = $cylinders_max;
		$meta['type'] = "numeric";
		
		if ($cylinders_min > 0) $meta['compare'] = "<=";
			else $meta['compare'] = "==";
		
		$meta_query[] = $meta;
	}

	if ($doors_min > 0) {
		$meta['key'] = $dox_options['ad_set']['doors']['query'];
		$meta['value'] = $doors_min;
		$meta['type'] = "numeric";
		
		if ($price_max > 0) $meta['compare'] = ">=";
			else $meta['compare'] = "==";
					
		$meta_query[] = $meta;
	}

	if ($doors_max > 0) {
		$meta['key'] = $dox_options['ad_set']['doors']['query'];
		$meta['value'] = $doors_max;
		$meta['type'] = "numeric";
		
		if ($doors_min > 0) $meta['compare'] = "<=";
			else $meta['compare'] = "==";
		
		$meta_query[] = $meta;
	}
	
	if ($mileage_min > 0) {
		$meta['key'] = $dox_options['ad_set']['mileage']['query'];
		$meta['value'] = $mileage_min;
		$meta['type'] = "numeric";
		
		if ($mileage_max > 0) $meta['compare'] = ">=";
			else $meta['compare'] = "==";
					
		$meta_query[] = $meta;
	}

	if ($mileage_max > 0) {
		$meta['key'] = $dox_options['ad_set']['mileage']['query'];
		$meta['value'] = $mileage_max;
		$meta['type'] = "numeric";
		
		if ($mileage_min > 0) $meta['compare'] = "<=";
			else $meta['compare'] = "==";
		
		$meta_query[] = $meta;
	}

	if ($price_min > 0) {
		$meta['key'] = $dox_options['ad_set']['price']['query'];
		$meta['value'] = $price_min;
		$meta['type'] = "numeric";
		
		if ($price_max > 0) $meta['compare'] = ">=";
			else $meta['compare'] = "==";
					
		$meta_query[] = $meta;
	}

	if ($price_max > 0) {
		$meta['key'] = $dox_options['ad_set']['price']['query'];
		$meta['value'] = $price_max;
		$meta['type'] = "numeric";
		
		if ($price_min > 0) $meta['compare'] = "<=";
			else $meta['compare'] = "==";
		
		$meta_query[] = $meta;
	}
	
	if ($keyword != '') {
		$query['s'] = $keyword;
	}	

	
	$query['tax_query'] = $tax_query;
	$query['meta_query'] = $meta_query;	

	if ($error == false) {
	
		// Process the query
		$autos = new WP_Query( $query );
		
		if ($autos->have_posts()){
		
			// Prepare output data
			$results = '';
			while ( $autos->have_posts() ) : $autos->the_post(); global $post;
				
				$postterms = dox_get_post_term(get_the_ID());
				$permalink = get_permalink($post->ID);
				$ad_date = get_the_time( get_option('date_format') );
				$postClass = get_post_class(); 
				$postThumb = dox_get_post_image($post->ID, 'default-thumb', 'main' );
				
				if ( $dox_options['ad_set']['model']['show'] == 'true' && $dox_options['ad_set']['model']['list'] == 'true' ) {
					$make = get_term_by( 'id', $postterms[$dox_options['ad_set']['model']['query']][0][0], $dox_options['ad_set']['model']['query'] );
					$model = get_term_by( 'id', $postterms[$dox_options['ad_set']['model']['query']][$postterms[$dox_options['ad_set']['model']['query']][0][0]][0], $dox_options['ad_set']['model']['query'] );
				}
				
				if ( $dox_options['ad_set']['location']['show'] == 'true' && $dox_options['ad_set']['location']['list'] == 'true' ) {
					$location = get_term_by( 'id', $postterms[$dox_options['ad_set']['location']['query']][0][0], $dox_options['ad_set']['location']['query'] );
					$city = get_term_by( 'id', $postterms[$dox_options['ad_set']['location']['query']][$postterms[$dox_options['ad_set']['location']['query']][0][0]][0], $dox_options['ad_set']['location']['query'] );
				}
				
				if ( $dox_options['ad_set']['mileage']['show'] == 'true' && $dox_options['ad_set']['mileage']['list'] == 'true' ) { $mileage = get_post_meta($post->ID, $dox_options['ad_set']['mileage']['query'], true); }
				if ( $dox_options['ad_set']['price']['show'] == 'true' && $dox_options['ad_set']['price']['list'] == 'true' ) { $price = get_post_meta($post->ID, $dox_options['ad_set']['price']['query'], true); }
				if ( $dox_options['ad_set']['year']['show'] == 'true' && $dox_options['ad_set']['year']['list'] == 'true' ) { $autoyear = get_term_by( 'id', $postterms[$dox_options['ad_set']['year']['query']][0][0], $dox_options['ad_set']['year']['query'] ); }
				if ( $dox_options['ad_set']['condition']['show'] == 'true' && $dox_options['ad_set']['condition']['list'] == 'true' ) { $condition = get_term_by( 'id', $postterms[$dox_options['ad_set']['condition']['query']][0][0], $dox_options['ad_set']['condition']['query'] ); }
				if ( $dox_options['ad_set']['color']['show'] == 'true' && $dox_options['ad_set']['color']['list'] == 'true' ) { $color = get_term_by( 'id', $postterms[$dox_options['ad_set']['color']['query']][0][0], $dox_options['ad_set']['color']['query'] ); }
				if ( $dox_options['ad_set']['fuelType']['show'] == 'true' && $dox_options['ad_set']['fuelType']['list'] == 'true' ) { $fuelType = get_term_by( 'id', $postterms[$dox_options['ad_set']['fuelType']['query']][0][0], $dox_options['ad_set']['fuelType']['query'] ); }
				if ( $dox_options['ad_set']['bodyType']['show'] == 'true' && $dox_options['ad_set']['bodyType']['list'] == 'true' ) { $bodyType = get_term_by( 'id', $postterms[$dox_options['ad_set']['bodyType']['query']][0][0], $dox_options['ad_set']['bodyType']['query'] ); }
				if ( $dox_options['ad_set']['doors']['show'] == 'true' && $dox_options['ad_set']['doors']['list'] == 'true' ) { $doors = get_post_meta($post->ID, $dox_options['ad_set']['doors']['query'], true); }
				if ( $dox_options['ad_set']['cylinders']['show'] == 'true' && $dox_options['ad_set']['cylinders']['list'] == 'true' ) { $cylinders = get_post_meta($post->ID, $dox_options['ad_set']['cylinders']['query'], true); }
				if ( $dox_options['ad_set']['transmission']['show'] == 'true' && $dox_options['ad_set']['transmission']['list'] == 'true' ) { $transmission = get_term_by( 'id', $postterms[$dox_options['ad_set']['transmission']['query']][0][0], $dox_options['ad_set']['transmission']['query'] ); }
				

				$results .= '<div class="'.$postClass[0].' '.$postClass[1].' '.$postClass[2].' '.$postClass[3].' custom-post-type" id="post-'.$post->ID.'">';
									
					$results .= '<div class="grid_3 clearfix alpha">';
						$results .= '<a href="'.$permalink.'" class="image-zoom main-thumb-zoom" target="_blank">';
							$results .= $postThumb;
							$results .= '<span class="zoom-icon"></span>';
						$results .= '</a>';
					$results .= '</div>';
					$results .= '<div class="grid_5 clearfix omega">';
						$results .= '<h3><a href="'.$permalink.'">'.$post->post_title.'</a></h3>';
						
						$results .= '<div class="grid_3 clearfix alpha">';
							$results .= '<ul class="features">';						
										if ( $dox_options['ad_set']['model']['show'] == 'true' && $dox_options['ad_set']['model']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['model']['name'].'</span> : '.$make->name.' / '.$model->name.'</li>'; }
										if ( $dox_options['ad_set']['location']['show'] == 'true' && $dox_options['ad_set']['location']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['location']['name'].'</span> : '.$location->name.' / '.$city->name.'</li>'; }							
										if ( $dox_options['ad_set']['mileage']['show'] == 'true' && $dox_options['ad_set']['mileage']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['mileage']['name'].'</span> : '.$mileage.'</li>'; }
										if ( $dox_options['ad_set']['year']['show'] == 'true' && $dox_options['ad_set']['year']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['year']['name'].'</span> : '.$autoyear->name.'</li>'; }
										if ( $dox_options['ad_set']['condition']['show'] == 'true' && $dox_options['ad_set']['condition']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['condition']['name'].'</span> : '.$condition->name.'</li>'; }
										if ( $dox_options['ad_set']['color']['show'] == 'true' && $dox_options['ad_set']['color']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['color']['name'].'</span> : '.$color->name.'</li>'; }
										if ( $dox_options['ad_set']['fuelType']['show'] == 'true' && $dox_options['ad_set']['fuelType']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['fuelType']['name'].'</span> : '.$fuelType->name.'</li>'; }
										if ( $dox_options['ad_set']['bodyType']['show'] == 'true' && $dox_options['ad_set']['bodyType']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['bodyType']['name'].'</span> : '.$bodyType->name.'</li>'; }
										if ( $dox_options['ad_set']['doors']['show'] == 'true' && $dox_options['ad_set']['doors']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['doors']['name'].'</span> : '.$doors.'</li>'; }
										if ( $dox_options['ad_set']['cylinders']['show'] == 'true' && $dox_options['ad_set']['cylinders']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['cylinders']['name'].'</span> : '.$cylinders.'</li>'; }
										if ( $dox_options['ad_set']['transmission']['show'] == 'true' && $dox_options['ad_set']['transmission']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['transmission']['name'].'</span> : '.$transmission->name.'</li>'; }
							$results .= '</ul>';
						$results .= '</div>';
						
						$results .= '<div class="grid_2 clearfix omega">';
							if ( $dox_options['ad_set']['price']['show'] == 'true' && $dox_options['ad_set']['price']['list'] == 'true' ) {
								$results .= '<ul class="price">';
											$results .= '<li><span>'.$dox_options['ad_set']['price']['name'].'</span>'.$price.' '.$dox_options['ad']['currency'].'</li>';
								$results .= '</ul>';
							}

							$results .= '<a href="?watchlist='.$post->ID.'" class="watchlist-button button">'.__("Add to Watchlist","autotrader").'</a>';
							$results .= '<a href="'.$permalink.'" class="button" target="_blank">'. __("View Details","autotrader").'</a>';
						$results .= '</div>';
						
					$results .= '</div>';
					
				$results .= '</div>';
				
			endwhile;
			
			$pager = dox_pager($paged, $autos->max_num_pages, true);
			
			echo json_encode( array("results" => stripslashes( $results ), 
								"pager" => $pager) );
		}
		else {
			echo json_encode( array("alert" => "alert-warning", 
									"message" => __('No ad could be found matching your search criteria.','autotrader')) );
		}

		// Reset Post Data
		wp_reset_postdata();
	}
	else {
		echo json_encode( array("alert" => "alert-error", 
								"message" => __('Sorry, an error occured.','autotrader')) );			
	}
	
	die();
}

add_action('wp_ajax_nopriv_dox_show_search_results', 'dox_show_search_results');
add_action('wp_ajax_dox_show_search_results', 'dox_show_search_results');

/**
* Displays user's watchlist
* Ajax function
*
* @package Autotrader
* @since 1.0.0
*
* @param int $_REQUEST['user_id']
* @param int $_REQUEST['page_nr']
* @param string $_REQUEST['order_by'] : date, price
* @param string $_REQUEST['order'] : ASC, DESC
*
* @return json.data
*/
function dox_show_watchlist() {

	global $dox_options;
	
	$error = false;

	// Get parameters from ajax call
	$user_id  = (int)$_REQUEST['user_id'];	
	$page_nr  = (int)$_REQUEST['page_nr'];
	$order_by = $_REQUEST['order_by'];
	$order    = $_REQUEST['order'];	
	
	// check user id
	$current_user = wp_get_current_user();
	if ($current_user->ID <> $user_id) { 
		$error = true;
		echo json_encode( array("alert" => "alert-error", 
								"message" => __('You are not authorized to view this data.','autotrader')) );		
	}
	
	if ($error == false) {
		
		// get watchlist data
		$watchlist = array();
		$watchlist = get_user_meta($user_id, 'dox_auto_watchlist', true);
		
		$count = 0;
		$count = count($watchlist);
		
		if ($count > 0) {

			// Prepare query parameter
			$query = array();
			
			$query['post__in'] = array_keys($watchlist);
			$query['post_type'] = $dox_options['ad_set']['type']['base'];
			$query['paged'] = $page_nr;
			$query['order'] = $order;
			$query['post_status'] = "publish";
			
			if ($order_by == 'date') {
				$query['orderby'] = $order_by;		
			}
			elseif ($order_by == 'price'){
				$query['orderby'] = "meta_value_num";
				$query['meta_key'] = $dox_options['ad_set']['price']['query'];		
			}
		
			// Process the query
			$autos = new WP_Query( $query );
			
			if ($autos->have_posts()){
			
				// Prepare output data
				$results = '';
				while ( $autos->have_posts() ) : $autos->the_post(); global $post;
					
					$postterms = dox_get_post_term(get_the_ID());
					$permalink = get_permalink($post->ID);
					$ad_date = get_the_time( get_option('date_format') );
					$postClass = get_post_class(); 
					$postThumb = dox_get_post_image($post->ID, 'default-thumb', 'main' );
					
					if ( $dox_options['ad_set']['model']['show'] == 'true' && $dox_options['ad_set']['model']['list'] == 'true' ) {
						$make = get_term_by( 'id', $postterms[$dox_options['ad_set']['model']['query']][0][0], $dox_options['ad_set']['model']['query'] );
						$model = get_term_by( 'id', $postterms[$dox_options['ad_set']['model']['query']][$postterms[$dox_options['ad_set']['model']['query']][0][0]][0], $dox_options['ad_set']['model']['query'] );
					}
					
					if ( $dox_options['ad_set']['location']['show'] == 'true' && $dox_options['ad_set']['location']['list'] == 'true' ) {
						$location = get_term_by( 'id', $postterms[$dox_options['ad_set']['location']['query']][0][0], $dox_options['ad_set']['location']['query'] );
						$city = get_term_by( 'id', $postterms[$dox_options['ad_set']['location']['query']][$postterms[$dox_options['ad_set']['location']['query']][0][0]][0], $dox_options['ad_set']['location']['query'] );
					}
					
					if ( $dox_options['ad_set']['mileage']['show'] == 'true' && $dox_options['ad_set']['mileage']['list'] == 'true' ) { $mileage = get_post_meta($post->ID, $dox_options['ad_set']['mileage']['query'], true); }
					if ( $dox_options['ad_set']['price']['show'] == 'true' && $dox_options['ad_set']['price']['list'] == 'true' ) { $price = get_post_meta($post->ID, $dox_options['ad_set']['price']['query'], true); }
					if ( $dox_options['ad_set']['year']['show'] == 'true' && $dox_options['ad_set']['year']['list'] == 'true' ) { $autoyear = get_term_by( 'id', $postterms[$dox_options['ad_set']['year']['query']][0][0], $dox_options['ad_set']['year']['query'] ); }
					if ( $dox_options['ad_set']['condition']['show'] == 'true' && $dox_options['ad_set']['condition']['list'] == 'true' ) { $condition = get_term_by( 'id', $postterms[$dox_options['ad_set']['condition']['query']][0][0], $dox_options['ad_set']['condition']['query'] ); }
					if ( $dox_options['ad_set']['color']['show'] == 'true' && $dox_options['ad_set']['color']['list'] == 'true' ) { $color = get_term_by( 'id', $postterms[$dox_options['ad_set']['color']['query']][0][0], $dox_options['ad_set']['color']['query'] ); }
					if ( $dox_options['ad_set']['fuelType']['show'] == 'true' && $dox_options['ad_set']['fuelType']['list'] == 'true' ) { $fuelType = get_term_by( 'id', $postterms[$dox_options['ad_set']['fuelType']['query']][0][0], $dox_options['ad_set']['fuelType']['query'] ); }
					if ( $dox_options['ad_set']['bodyType']['show'] == 'true' && $dox_options['ad_set']['bodyType']['list'] == 'true' ) { $bodyType = get_term_by( 'id', $postterms[$dox_options['ad_set']['bodyType']['query']][0][0], $dox_options['ad_set']['bodyType']['query'] ); }
					if ( $dox_options['ad_set']['doors']['show'] == 'true' && $dox_options['ad_set']['doors']['list'] == 'true' ) { $doors = get_post_meta($post->ID, $dox_options['ad_set']['doors']['query'], true); }
					if ( $dox_options['ad_set']['cylinders']['show'] == 'true' && $dox_options['ad_set']['cylinders']['list'] == 'true' ) { $cylinders = get_post_meta($post->ID, $dox_options['ad_set']['cylinders']['query'], true); }
					if ( $dox_options['ad_set']['transmission']['show'] == 'true' && $dox_options['ad_set']['transmission']['list'] == 'true' ) { $transmission = get_term_by( 'id', $postterms[$dox_options['ad_set']['transmission']['query']][0][0], $dox_options['ad_set']['transmission']['query'] ); }
					

					$results .= '<div class="'.$postClass[0].' '.$postClass[1].' '.$postClass[2].' '.$postClass[3].'  custom-post-type" id="post-'.$post->ID.'">';
										
						$results .= '<div class="grid_3 clearfix alpha">';
							$results .= '<a href="'.$permalink.'" class="image-zoom main-thumb-zoom" target="_blank">';
								$results .= $postThumb;
								$results .= '<span class="zoom-icon"></span>';
							$results .= '</a>';
						$results .= '</div>';
						$results .= '<div class="grid_5 clearfix omega">';
							$results .= '<h3><a href="'.$permalink.'">'.$post->post_title.'</a></h3>';
							
							$results .= '<div class="grid_3 clearfix alpha">';
								$results .= '<ul class="features">';						
											if ( $dox_options['ad_set']['model']['show'] == 'true' && $dox_options['ad_set']['model']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['model']['name'].'</span> : '.$make->name.' / '.$model->name.'</li>'; }
											if ( $dox_options['ad_set']['location']['show'] == 'true' && $dox_options['ad_set']['location']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['location']['name'].'</span> : '.$location->name.' / '.$city->name.'</li>'; }							
											if ( $dox_options['ad_set']['mileage']['show'] == 'true' && $dox_options['ad_set']['mileage']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['mileage']['name'].'</span> : '.$mileage.'</li>'; }
											if ( $dox_options['ad_set']['year']['show'] == 'true' && $dox_options['ad_set']['year']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['year']['name'].'</span> : '.$autoyear->name.'</li>'; }
											if ( $dox_options['ad_set']['condition']['show'] == 'true' && $dox_options['ad_set']['condition']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['condition']['name'].'</span> : '.$condition->name.'</li>'; }
											if ( $dox_options['ad_set']['color']['show'] == 'true' && $dox_options['ad_set']['color']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['color']['name'].'</span> : '.$color->name.'</li>'; }
											if ( $dox_options['ad_set']['fuelType']['show'] == 'true' && $dox_options['ad_set']['fuelType']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['fuelType']['name'].'</span> : '.$fuelType->name.'</li>'; }
											if ( $dox_options['ad_set']['bodyType']['show'] == 'true' && $dox_options['ad_set']['bodyType']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['bodyType']['name'].'</span> : '.$bodyType->name.'</li>'; }
											if ( $dox_options['ad_set']['doors']['show'] == 'true' && $dox_options['ad_set']['doors']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['doors']['name'].'</span> : '.$doors.'</li>'; }
											if ( $dox_options['ad_set']['cylinders']['show'] == 'true' && $dox_options['ad_set']['cylinders']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['cylinders']['name'].'</span> : '.$cylinders.'</li>'; }
											if ( $dox_options['ad_set']['transmission']['show'] == 'true' && $dox_options['ad_set']['transmission']['list'] == 'true' ) { $results .= '<li><span>'.$dox_options['ad_set']['transmission']['name'].'</span> : '.$transmission->name.'</li>'; }
								$results .= '</ul>';
							$results .= '</div>';
							
							$results .= '<div class="grid_2 clearfix omega">';
								if ( $dox_options['ad_set']['price']['show'] == 'true' && $dox_options['ad_set']['price']['list'] == 'true' ) {
									$results .= '<ul class="price">';
												$results .= '<li><span>'.$dox_options['ad_set']['price']['name'].'</span>'.$price.' '.$dox_options['ad']['currency'].'</li>';
									$results .= '</ul>';
								}
				
								$results .= '<a href="?delete='.$post->ID.'" class="watchlist-button button">'.__("Delete Watchlist","autotrader").'</a>';
								$results .= '<a href="'.$permalink.'" class="button" target="_blank">'. __("View Details","autotrader").'</a>';
							$results .= '</div>';
							
						$results .= '</div>';
						
					$results .= '</div>';
					
				endwhile;
				
				$pager = dox_pager($page_nr, $autos->max_num_pages, true);
				
				echo json_encode( array("results" => stripslashes( $results ), 
										"pager" => $pager) );

				// Reset Post Data
				wp_reset_postdata();
			}
			else {
				echo json_encode( array("alert" => "alert-warning", 
										"message" => __('No ad could be found at your watchlist.','autotrader') ) );
			}			
									
		}
		else {
			echo json_encode( array("alert" => "alert-warning", 
								    "message" => __('Sorry, no ad could found at your watchlist.','autotrader') ) );			
		}
	}

	die();
}

add_action('wp_ajax_nopriv_dox_show_watchlist', 'dox_show_watchlist');
add_action('wp_ajax_dox_show_watchlist', 'dox_show_watchlist');

/**
* Remove all ads from user's watchlist
* Ajax function
*
* @package Autotrader
* @since 1.0.0
*
* @param int $_REQUEST['user_id']
*
* @return json.data
*/
function dox_delete_all_watchlist() {

	global $wpdb, $current_user;
	
	$error = false;

	// get parameters from ajax call
	$user_id  = (int)$_REQUEST['user_id'];
		
	if ($current_user->ID != $user_id) { 
		$error = true;
		echo json_encode( array("alert" => "alert-error", 
								"message" => __('You are not authorized to delete watchlist','autotrader') ) );		
	}
	
	if ($error == false) {

		// delete all ads
		$deleted = false;
		$deleted = delete_user_meta($user_id, 'dox_auto_watchlist');

		if ($deleted == false) { 
			$error = true;
			echo json_encode( array("alert" => "alert-error", 
									"message" => __('Sorry, an error occured while deleting your watchlist. Please try again.','autotrader') ) );
		}
		else {
			echo json_encode( array("alert" => "alert-success", 
									"message" => __('All ads have been deleted from your watchlist successfully.','autotrader') ) );			
		}

	}
	
	die();	

}

add_action('wp_ajax_nopriv_dox_delete_all_watchlist', 'dox_delete_all_watchlist');
add_action('wp_ajax_dox_delete_all_watchlist', 'dox_delete_all_watchlist');


/**
* Remove an ad from user's watchlist
* Ajax function
*
* @package Autotrader
* @since 1.0.0
*
* @param int $_REQUEST['post_id']
*
* @return json.data
*/
function dox_delete_to_watchlist() {

	global $wpdb, $current_user;
	
	$error = false;
	
	if ($current_user->ID < 1) { 
		$error = true;
		echo json_encode( array("alert" => "alert-warning", 
								"message" => __('Please login to use this function.','autotrader') ) );		
	}
	
	if ($error == false) {
	
		// get parameters from ajax call
		$post_id  = (int)$_REQUEST['post_id'];
		
		// get watchlist data
		$watchlist = array();
		$watchlist = get_user_meta($current_user->ID, 'dox_auto_watchlist', true);
		
		// check if post_id is already exist
		if (! empty($watchlist) && array_key_exists($post_id, $watchlist)) {
		
			// remove from watchlist
			unset($watchlist[$post_id]);
			
			// Add to watchlist
			$deleted = false;
			$deleted = update_user_meta( $current_user->ID, 'dox_auto_watchlist', $watchlist );
			
			
			if ($deleted == false) { 
				$error = true;
				echo json_encode( array("alert" => "alert-error", 
										"message" => __('Sorry, an error occured while deleting ad from watchlist. Please try again.','autotrader') ) );
			}
			else {
				echo json_encode( array("alert" => "alert-success", 
										"message" => __('The ad has been deleted from your watchlist successfully.','autotrader') ) );			
			}
				
		}
		else {
			$error = true;
			echo json_encode( array("alert" => "alert-warning", 
									"message" => __('The ad does not exist at your watchlist. ','autotrader') ) );
		}
	
	}
	
	die();	

}

add_action('wp_ajax_nopriv_dox_delete_to_watchlist', 'dox_delete_to_watchlist');
add_action('wp_ajax_dox_delete_to_watchlist', 'dox_delete_to_watchlist');


/**
* Add a post to watchlist
* Ajax function
*
* @package Autotrader
* @since 1.0.0
*
* @param int $_REQUEST['post_id']
*
* @return json.data
*/
function dox_add_to_watchlist() {

	global $wpdb, $current_user, $dox_options;
	
	$error = false;
	
	if ($current_user->ID < 1) { 
		$error = true;
		echo json_encode( array("alert" => "alert-warning", 
								"message" => __('Please login to use this function.','autotrader') ) );		
	}
	
	if ($error == false) {
	
		// Get parameters from ajax call
		$post_id  = (int)$_REQUEST['post_id'];
		
		// check ad exists
		$query = "SELECT p.post_author AS author_id FROM $wpdb->posts AS p
					WHERE p.ID = ".$post_id." AND p.post_type = '".$dox_options['ad_set']['type']['base']."'";
					
		$autos = $wpdb->get_results($query);
		
		if ( empty($autos) ) {
			$error = true;
			echo json_encode( array("alert" => "alert-error", 
									"message" => __('The ad could not found.','autotrader') ) );

		}
		
		if ($error == false) {
			
			// get current data
			$watchlist = array();
			$watchlist = get_user_meta($current_user->ID, 'dox_auto_watchlist', true);
			
			// check if post_id is already exist
			if (! empty($watchlist) && array_key_exists($post_id, $watchlist)) {
				$error = true;
				echo json_encode( array("alert" => "alert-warning", 
										"message" => __('Hey, the post is already exist in your watchlist.','autotrader') ) );
			}
			else {
				$watchlist[$post_id] = true;
			}
			
			if ($error == false) {
			
				// Add to watchlist
				$added = false;
				$added = update_user_meta( $current_user->ID, 'dox_auto_watchlist', $watchlist );
				
				
				if ($added == false) { 
					$error = true;
					echo json_encode( array("alert" => "alert-error", 
											"message" => __('Sorry, an error occured while adding the ad to watchlist. Please try again.','autotrader') ) );
				}
				else {
					echo json_encode( array("alert" => "alert-success", 
											"message" => __('The post has been added to your watchlist successfully.','autotrader') ) );			
				}
				
			}
		}
	
	}
	
	die();	

}

add_action('wp_ajax_nopriv_dox_add_to_watchlist', 'dox_add_to_watchlist');
add_action('wp_ajax_dox_add_to_watchlist', 'dox_add_to_watchlist');


/**
* Custom paging
*
* @package WordPress
* @subpackage Administration
*
* @since 1.0.0
*
* @param int $page_nr : current page
* @param int $max_page : the total number of pages
* @param bool $ajaxed : check if function is called from ajaxed function
*
* @return
*/
function dox_pager( $page_nr, $max_page, $ajaxed = true ) {
	
	if ($max_page > 1) {
	
		$start = 1;
		$end = $max_page;
		
		// default value
		if ( $page_nr < 2 ) $page_nr = 1;
		
		$bla_bla = '';
		$bla_bla_end = '';
		
		$start = $page_nr - 2;
		$stop = $page_nr + 2;
		
		
		if ( $start <= 2 ) { $start = 2; }
		else { $bla_bla = '<span class="bla">..</span>'; }
		
		if ( $stop >= $end - 1 ) { $stop = $end - 1; }
		else { $bla_bla_end = '<span class="bla">..</span>'; }
		
		if ( $ajaxed == true ) $link = '#';
		else $link = esc_url(get_pagenum_link());
		
		if ( $page_nr < 2 ) $current = 'current'; else $current = '';
		
		$output = '';
		$output .= '<div class="dox_pager"><span>'.__('Pages','autotrader').'</span><ul><li class="'.$current.'"><a href="'.$link.'" class="pager">1</a></li>';
		
		$output .= $bla_bla;
		
		if ( $stop >= $start ) {
			do {
				
				if ( $start == $page_nr ) $current = 'current'; else $current = '';
				
				if ( $ajaxed == true ) $link = '#';
				else $link = esc_url(get_pagenum_link($start));

				$output .= '<li class="'.$current.'"><a href="'.$link.'" class="pager">'.$start.'</a></li>';
				$start++;		
			} while ( $start <= $stop );
		}
		
		$output .= $bla_bla_end;
		
		if ( $end == $page_nr ) $current = 'current'; else $current = '';
		
		if ( $ajaxed == true ) $link = '#';
		else $link = esc_url(get_pagenum_link($end));
				
		$output .= '<li class="'.$current.'"><a href="'.$link.'" class="pager">'.$end.'</a></li>';
		$output .= '</ul></div>';
		
		return $output;
	}
}

/**
* Delete an ad permanently
* Ajax function
*
* @package Autotrader
* @since 1.0.0
*
* @param int $_REQUEST['post_id']
*
* @return json.data
*/
function dox_delete_ad() {
	
	global $wpdb, $dox_options;
	
	$error = false;
	
	// Get parameters from ajax call
	$post_id  = (int)$_REQUEST['post_id'];
	
	// check ad exists
	$query = "SELECT p.post_author AS author_id FROM $wpdb->posts AS p
				WHERE p.ID = ".$post_id." AND p.post_type = '".$dox_options['ad_set']['type']['base']."'";
				
	$autos = $wpdb->get_results($query);
	
	if ( empty($autos) ) {
		$error = true;
		echo json_encode( array("alert" => "alert-error", 
								"message" => __('The ad could not found.','autotrader') ) );

	}

	if ($error == false) {
	
		// check user authorization
		$current_user = wp_get_current_user();
		
		if ($autos[0]->author_id <> $current_user->ID) {
			$error = true;
			echo json_encode( array("alert" => "alert-error", 
									"message" => __('You are not authorized to delete this ad.','autotrader') ) );			
		}
		
		if ($error == false) {
			
			// Delete permanently
			$deleted = false;
			$deleted = wp_delete_post($post_id);
			
			
			if ($deleted == false) { 
				$error = true;
				echo json_encode( array("alert" => "alert-error", 
									"message" => __('Sorry, an error occured while deleting ad. Please try again.','autotrader') ) );
			}
			else {
				echo json_encode( array("alert" => "alert-success", 
									"message" => __('The ad has been deleted successfully.','autotrader') ) );			
			}
		}
	}
	
	die();
}

add_action('wp_ajax_nopriv_dox_delete_ad', 'dox_delete_ad');
add_action('wp_ajax_dox_delete_ad', 'dox_delete_ad');

/**
* Move the post to trash
* Ajax function
*
* @package Autotrader
* @since 1.0.0
*
* @param int $_REQUEST['post_id']
*
* @return json.data
*/
function dox_move_ad_to_trash() {
	
	global $wpdb, $dox_options;
	
	$error = false;
	
	// Get parameters from ajax call
	$post_id  = (int)$_REQUEST['post_id'];
	
	// check ad exists
	$query = "SELECT p.post_author AS author_id FROM $wpdb->posts AS p
				WHERE p.ID = ".$post_id." AND p.post_type = '".$dox_options['ad_set']['type']['base']."'";
				
	$autos = $wpdb->get_results($query);
	
	if ( empty($autos) ) {
		$error = true;
		echo json_encode( array("alert" => "alert-error", 
								"message" => __('The ad could not found.','autotrader') ) );

	}

	if ($error == false) {
	
		// check user authorization
		$current_user = wp_get_current_user();
		
		if ($autos[0]->author_id <> $current_user->ID) {
			$error = true;
			echo json_encode( array("alert" => "alert-error", 
									"message" => __('You are not authorized to delete this ad.','autotrader') ) );			
		}
		
		if ($error == false) {
			
			// Move to trash
			$deleted_id = 0;
			
			$post_data = array();
			$post_data['ID'] = $post_id;
			$post_data['post_status'] = 'trash';
		
			$deleted_id = wp_update_post( $post_data );
			
			if ($deleted_id != $post_id) { 
				$error = true;
				echo json_encode( array("alert" => "alert-error", 
									"message" => __('Sorry, an error occured while deleting ad. Please try again.','autotrader') ) );
			}
			else {
				echo json_encode( array("alert" => "alert-success", 
									"message" => __('The ad has been deleted successfully.','autotrader') ) );			
			}
		}
	}
	
	die();
}

add_action('wp_ajax_nopriv_dox_move_ad_to_trash', 'dox_move_ad_to_trash');
add_action('wp_ajax_dox_move_ad_to_trash', 'dox_move_ad_to_trash');


/**
* Displays submit an ad page url
*
* @package Autotrader
* @since 1.0.0
*
*/
function dox_get_submit_auto_page() {
	global $dox_options;
	return get_permalink( $dox_options['ad']['submit_page'] );
}

/**
* Displays user dashboard page url
*
* @package Autotrader
* @since 1.0.0
*
*/
function dox_get_user_dashboard_page() {
	global $dox_options;
	return get_permalink( $dox_options['ad']['dashboard_page'] );
}

/**
* Displays user's watchlist page url
*
* @package Autotrader
* @since 1.0.0
*
*/
function dox_get_watchlist_page() {
	global $dox_options;
	return get_permalink( $dox_options['ad']['watchlist_page'] );
}

/**
* Displays user profile page url
*
* @package Autotrader
* @since 1.1.0
*
*/
function dox_get_user_profile_page() {
	global $dox_options;
	return get_permalink( $dox_options['ad']['profile_page'] );
}

/**
* Displays dealer form page url
*
* @package Autotrader
* @since 1.0.0
*
*/
function dox_get_dealer_form_page() {
	global $dox_options;
	return get_permalink( $dox_options['ad']['dealer_page'] );
}

/**
* Displays edit ad page url
*
* @package Autotrader
* @since 1.0.0
*
* @param int $post_id
*/
function dox_get_edit_ad_page($post_id) {
	global $dox_options;
	//return get_permalink( $dox_options['ad']['edit_page'] ).'?ad_id='.$post_id;
	return add_query_arg( 'ad_id', $post_id, get_permalink($dox_options['ad']['edit_page']) );
}

/**
* Displays search autos page url
*
* @package Autotrader
* @since 1.0.0
*
*/
function dox_get_search_autos_page() {
	global $dox_options;
	return get_permalink( $dox_options['ad']['search_page'] );
}

/**
* Displays search results page link
*
* @package Autotrader
* @since 1.0.0
*
*/
function dox_get_search_autos_results_page() {
	global $dox_options;
	return get_permalink( $dox_options['ad']['search_results_page'] );
}




/**
* Displays user's ads with given order
* Ajax function
*
* @package Autotrader
* @since 1.0.0
*
* @param int $_REQUEST['user_id']
* @param int $_REQUEST['status'] : publish, pending, trash
* @param int $_REQUEST['page_nr']
* @param string $_REQUEST['order_by'] : date, price
* @param string $_REQUEST['order'] : ASC, DESC
*
* @return json.data
*/
function dox_user_ads() {

	global $dox_options;
	
	$error = false;
		
	$tax_query = array();
	$meta_query = array();
	
	// Get parameters from ajax call
	$user_id  = (int)$_REQUEST['user_id'];	
	$post_status = $_REQUEST['status'];
	$page_nr  = (int)$_REQUEST['page_nr'];
	$order_by = $_REQUEST['order_by'];
	$order    = $_REQUEST['order'];	
	
	// check user id
	$current_user = wp_get_current_user();
	if ($current_user->ID <> $user_id) { 
		$error = true;
		echo json_encode( array("alert" => "alert-error", 
								"message" => __('You are not authorized to view this data.','autotrader')) );		
	}
	
	if ($error == false) {
		
		// Prepare query parameter
		$query = array();
		
		$query['post_type'] = $dox_options['ad_set']['type']['base'];
		$query['author'] = $user_id;
		$query['paged'] = $page_nr;
		$query['order'] = $order;
		$query['posts_per_page'] = 20;
		$query['post_status'] = $post_status;
		
		if ($order_by == 'date') {
			$query['orderby'] = $order_by;		
		}
		elseif ($order_by == 'price'){
			$query['orderby'] = "meta_value_num";
			$query['meta_key'] = $dox_options['ad_set']['price']['query'];		
		}
		else { $error = true; }
		
		if ($error == false) {
		
			// Process the query
			$autos = new WP_Query( $query );
			
			if ($autos->have_posts()){
			
				// Prepare output data
				$items = '';
				while ( $autos->have_posts() ) : $autos->the_post(); global $post;
					
					$permalink = get_permalink($post->ID);
					$ad_date = get_the_time( get_option('date_format') );
					$ad_price = get_post_meta($post->ID, $dox_options['ad_set']['price']['query'], true);
					$post_title = substr($post->post_title, 0,40);

					$items .= '<ul>';				
					$items .= '<li class="cgrid_9"><a href="'.$permalink.'" target="_blank">'.$post_title.'</a></li>';
					$items .= '<li class="cgrid_4">'.$ad_date.'</li>';
					$items .= '<li class="cgrid_3">'.$ad_price.' '.$dox_options['ad']['currency'].'</li>';
					$items .= '<li class="cgrid_2 cgrid-link"><a href="'.dox_get_edit_ad_page($post->ID).'" target="_blank">'.__('Edit', 'autotrader').'</a></li>';
					$items .= '<li class="cgrid_2 cgrid-link last"><a href="?delete='.$post->ID.'" class="deleteLink">'.__('Delete', 'autotrader').'</a></li>';					
					$items .= '</ul>';
					
				endwhile;
				
				$pager = dox_pager($page_nr, $autos->max_num_pages, true);
				
				echo json_encode( array("items" => $items, 
										"pager" => $pager) );
			}
			else {
				echo json_encode( array("alert" => "alert-warning", 
										"message" => __('No ad found.','autotrader')) );				
			}
			
			// Reset Post Data
			wp_reset_postdata();
		}
		else {
			echo json_encode( array("alert" => "alert-error", 
								    "message" => __('An error occured. Check query parameters.','autotrader')) );			
		}
	}

	die();
}

add_action('wp_ajax_nopriv_dox_user_ads', 'dox_user_ads');
add_action('wp_ajax_dox_user_ads', 'dox_user_ads');

/**
* Displays browse categories name by query name
*
* @package Autotrader
* @since 1.1
*
* @param int $browse_query
* 
* @return html output
*/
function dox_get_browse_name_by_query($browse_query) {

	global $dox_options;

	$output = '';
	
	switch ($browse_query) {
		case $dox_options['ad_set']['location']['query']: 		$output .= $dox_options['ad_set']['location']['name']; break;
		case $dox_options['ad_set']['model']['query']: 			$output .= $dox_options['ad_set']['model']['name']; break;
		case $dox_options['ad_set']['year']['query']: 			$output .= $dox_options['ad_set']['year']['name']; break;
		case $dox_options['ad_set']['color']['query']: 			$output .= $dox_options['ad_set']['color']['name']; break;
		case $dox_options['ad_set']['fuelType']['query']: 		$output .= $dox_options['ad_set']['fuelType']['name']; break;
		case $dox_options['ad_set']['bodyType']['query']: 		$output .= $dox_options['ad_set']['bodyType']['name']; break;
		case $dox_options['ad_set']['transmission']['query']: 	$output .= $dox_options['ad_set']['transmission']['name']; break;;
		case $dox_options['ad_set']['condition']['query']: 		$output .= $dox_options['ad_set']['condition']['name']; break;
	}	

	return $output;

}



/**
* Displays browse categories for admin options
*
* @package Autotrader
* @since 1.1
*
* @param int $selected_query
* 
* @return html output
*/
function dox_get_browse_cat($selected_query) {

	global $dox_options;
	
	$output = '';
	
	if ($dox_options['ad_set']['condition']['show'] == 'true') {
		$output .= '<option value="'.$dox_options['ad_set']['condition']['query'].'" ';
		if ($selected_query == $dox_options['ad_set']['condition']['query'])
			$output .= 'selected="selected"';
		$output .= '>'.$dox_options['ad_set']['condition']['name'].'</option>';
	}
	
	if ($dox_options['ad_set']['model']['show'] == 'true') {
		$output .= '<option value="'.$dox_options['ad_set']['model']['query'].'" ';
		if ($selected_query == $dox_options['ad_set']['model']['query'])
			$output .= 'selected="selected"';
		$output .= '>'.$dox_options['ad_set']['model']['name'].'</option>';
	}

	if ($dox_options['ad_set']['location']['show'] == 'true') {
		$output .= '<option value="'.$dox_options['ad_set']['location']['query'].'" ';
		if ($selected_query == $dox_options['ad_set']['location']['query'])
			$output .= 'selected="selected"';
		$output .= '>'.$dox_options['ad_set']['location']['name'].'</option>';
	}

	if ($dox_options['ad_set']['year']['show'] == 'true') {
		$output .= '<option value="'.$dox_options['ad_set']['year']['query'].'" ';
		if ($selected_query == $dox_options['ad_set']['year']['query'])
			$output .= 'selected="selected"';
		$output .= '>'.$dox_options['ad_set']['year']['name'].'</option>';
	}

	if ($dox_options['ad_set']['color']['show'] == 'true') {
		$output .= '<option value="'.$dox_options['ad_set']['color']['query'].'" ';
		if ($selected_query == $dox_options['ad_set']['color']['query'])
			$output .= 'selected="selected"';
		$output .= '>'.$dox_options['ad_set']['color']['name'].'</option>';
	}

	if ($dox_options['ad_set']['fuelType']['show'] == 'true') {
		$output .= '<option value="'.$dox_options['ad_set']['fuelType']['query'].'" ';
		if ($selected_query == $dox_options['ad_set']['fuelType']['query'])
			$output .= 'selected="selected"';
		$output .= '>'.$dox_options['ad_set']['fuelType']['name'].'</option>';
	}

	if ($dox_options['ad_set']['bodyType']['show'] == 'true') {
		$output .= '<option value="'.$dox_options['ad_set']['bodyType']['query'].'" ';
		if ($selected_query == $dox_options['ad_set']['bodyType']['query'])
			$output .= 'selected="selected"';
		$output .= '>'.$dox_options['ad_set']['bodyType']['name'].'</option>';
	}

	if ($dox_options['ad_set']['transmission']['show'] == 'true') {
		$output .= '<option value="'.$dox_options['ad_set']['transmission']['query'].'" ';
		if ($selected_query == $dox_options['ad_set']['transmission']['query'])
			$output .= 'selected="selected"';
		$output .= '>'.$dox_options['ad_set']['transmission']['name'].'</option>';
	}	
	
	return $output;
}


//////

function dox_comment( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>

	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>">
		
			<div class="comment-meta">
				<div class="avatar-wrapper">
					<?php echo get_avatar( $comment, $size='40' ); ?>
				</div>
				<div class="comment-meta-data">
					<div class="comment-author"><?php comment_author_link() ?></div>
					<div class="comment-date">
						<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','') ?>
					</div>
				</div>
				<div class="comment-reply">
					<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</div>	
			</div>

			<div class="comment-text">
				<?php if ($comment->comment_approved == '0') : ?>
				<p class="not-approved"><?php esc_html_e('Your comment is awaiting moderation.', 'autotrader') ?></p>
				<?php endif; ?>
					<?php comment_text() ?>
			</div>

		</div>
		<div class="clear"></div>
     </li>
<?php
}


add_action('init', 'dox_init');
 
 function dox_init(){
 
	global $wp_version, $current_user;
	
	if ( ! isset( $content_width ) ) $content_width = 620;
	
	load_theme_textdomain( 'autotrader', get_template_directory() . '/languages'); 

	add_action('wp_head', 'dox_dyn_css');

	$show_toolbar = true;
	$show_toolbar = _get_admin_bar_pref($current_user->ID);
	if ($show_toolbar) update_user_meta($current_user->ID, 'show_admin_bar_front', false );		
}

function dox_dyn_css(){
	global $dox_options;
	
	// Logo
	if ($dox_options['general']['logo_url']) { echo '<style type="text/css"> #logo { background: url('.$dox_options['general']['logo_url'].') no-repeat; } </style>'; }
	
}

// Get cities of selected location
add_action('wp_ajax_nopriv_dox_get_city', 'dox_get_city');
add_action('wp_ajax_dox_get_city', 'dox_get_city');

function dox_get_city() {
	
	global $dox_options;
	
	if ($_REQUEST['sel_text'] == true) $sel_text = sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['location']['sub'] );
		else $sel_text = null;	
	
	if(isset($_REQUEST['location_id'])) {
		dox_get_dd_terms( $dox_options['ad_set']['location']['query'], $_REQUEST['location_id'],0, $sel_text );
	}
	
	// Do not delete..
	die();
}

// Get models of selected make
add_action('wp_ajax_nopriv_dox_get_model', 'dox_get_model');
add_action('wp_ajax_dox_get_model', 'dox_get_model');

function dox_get_model() {
	
	global $dox_options;
	
	if ($_REQUEST['sel_text'] == true) $sel_text = sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['model']['sub'] );
		else $sel_text = null;	
	
	if(isset($_REQUEST['make_id'])) {
		dox_get_dd_terms( $dox_options['ad_set']['model']['query'], $_REQUEST['make_id'],0, $sel_text );
	}
	
	// Do not delete..
	die();
}

function dox_get_dd_terms( $taxonomy = 'category', $term_id, $sel_id, $sel_text = null, $order = 'ASC' ) {		
		
		$selected = '';
		if ( $sel_id <= 0 ) $selected = 'selected="selected"';
		
		$terms = array();
		$terms = explode(',', $term_id);
		$count = count( $terms );

		$return = '';
		foreach( $terms as $term ) {
			if ($term >= 0) {
				$options = get_terms( $taxonomy, 'child_of='.$term.'&parent='.$term.'&hide_empty=0&hierarchical=1&depth=1&orderby=name&order='.$order );
				foreach ($options as $option) {
					$return .= '<option value="'.$option->term_id.'" ';
					if ($sel_id == $option->term_id) $return .= 'selected="selected"';
					$return .= '>'.$option->name;
					$return .= '</option>';
				}
			}
		}
		
		if ( $sel_text ) echo '<option value="-1" '.$selected.' >'.$sel_text.'</option>'.$return;
			else echo $return;
}

function dox_get_list_terms( $taxonomy = 'category', $term_id, $number, $orderby = 'name', $order = 'ASC', $hide = '0' ) {		
		
		$terms = array();
		$terms = explode(',', $term_id);
		$count = count( $terms );

		$output = '';
		foreach( $terms as $term ) {
			if ($term >= 0) {
				$options = get_terms( $taxonomy, 'number='.$number.'child_of='.$term.'&parent='.$term.'&hide_empty='.$hide.'&hierarchical=1&depth=1&orderby='.$orderby.'&order='.$order );
				if (! is_wp_error($options) ) {
					foreach ($options as $option) {
						$output .= '<li><a href="'.get_term_link($option->slug, $taxonomy).'">'.$option->name.'</a></li>';
					}
				}
			}
		}
		
		return $output;
}


function dox_get_post_term( $post_id ) {
	// wp_get_object_terms
	
	global $wpdb;
	$query = "SELECT tt.term_id AS ID, tt.taxonomy as tax, tt.parent as par FROM $wpdb->term_taxonomy AS tt
					INNER JOIN $wpdb->term_relationships AS tr ON tr.term_taxonomy_id = tt.term_taxonomy_id 
				WHERE tr.object_id = '$post_id'";
	
	$terms = $wpdb->get_results($query);

	if ( ! $terms ) $terms = array();
	
	foreach($terms as $term) {
		$t[$term->tax][$term->par][] = $term->ID;
	}

	return $t;
}

function dox_query_vars($vars) {
	$vars[] = "ad_id";
	return $vars;
}
add_filter('query_vars', 'dox_query_vars');


function dox_get_post_image($post_id, $img_name = null, $img_size = 'full', $prettyphoto = false) {

	global $dox_options;
	
	$default_thumb = false;
	
	if ($img_name != null) { $post_name = "AND p.post_title = '".$img_name."'"; } else { $post_name = ''; }

	global $wpdb;
	$query = "SELECT p.ID AS ID FROM $wpdb->posts AS p
				WHERE p.post_parent = '$post_id' AND p.post_type = 'attachment' AND p.post_status = 'inherit'".$post_name;
	
	$attachments = $wpdb->get_results($query);

	if ( empty($attachments) ) { 
		$query = "SELECT p.ID AS ID FROM $wpdb->posts AS p
					WHERE p.post_parent = '$post_id' AND p.post_type = 'attachment' AND p.post_status = 'inherit'";	
		
		$attachments = $wpdb->get_results($query);
		
		if ( empty($attachments) ) $default_thumb = true;
	}
	
	if ($default_thumb == false) {
		if ( $prettyphoto == false) {
			return wp_get_attachment_image( $attachments[0]->ID, $img_size );
		} else {
			$full_img = wp_get_attachment_image_src( $attachments[0]->ID, "full" );
			$thumb_img = wp_get_attachment_image_src( $attachments[0]->ID, $img_size );
			
			return '<a href="'.$full_img[0].'" rel="prettyPhoto[gallery]" class="image-zoom single-thumb-zoom"><img src="'.$thumb_img[0].'"/><span class="zoom-icon"></span></a>';
		}
	} else { return wp_get_attachment_image( $dox_options['general']['default_img_id'], $img_size ); }
}

function dox_get_title($term_query, $tax_query) {

	global $dox_options;
	
	$term = get_term_by( 'slug', $term_query, $tax_query );
	
	switch ($tax_query) {
		case $dox_options['ad_set']['location']['query']: 		printf(__('Browse by %s: %s', 'autotrader'), $dox_options['ad_set']['location']['name'], $term->name);		break;
		case $dox_options['ad_set']['model']['query']: 			printf(__('Browse by %s: %s', 'autotrader'), $dox_options['ad_set']['model']['name'], $term->name);			break;
		case $dox_options['ad_set']['year']['query']: 			printf(__('Browse by %s: %s', 'autotrader'), $dox_options['ad_set']['year']['name'], $term->name);			break;
		case $dox_options['ad_set']['color']['query']: 			printf(__('Browse by %s: %s', 'autotrader'), $dox_options['ad_set']['color']['name'], $term->name);			break;
		case $dox_options['ad_set']['fuelType']['query']: 		printf(__('Browse by %s: %s', 'autotrader'), $dox_options['ad_set']['fuelType']['name'], $term->name);		break;
		case $dox_options['ad_set']['bodyType']['query']: 		printf(__('Browse by %s: %s', 'autotrader'), $dox_options['ad_set']['bodyType']['name'], $term->name);		break;
		case $dox_options['ad_set']['transmission']['query']: 	printf(__('Browse by %s: %s', 'autotrader'), $dox_options['ad_set']['transmission']['name'], $term->name);		break;
		case $dox_options['ad_set']['condition']['query']: 		echo $term->name;														break;
	}
}

function dox_get_post($amount,$echo=true) {
	global $post, $shortname;
	
	$postExcerpt = '';
	$postExcerpt = $post->post_excerpt;
	
	if (get_option($shortname.'_use_excerpt') == 'true' && $postExcerpt <> '') { 
		if ($echo) echo $postExcerpt;
		else return $postExcerpt;	
	} else {
		$truncate = $post->post_content;
		
		$truncate = preg_replace('@\[caption[^\]]*?\].*?\[\/caption]@si', '', $truncate);
		
		if ( strlen($truncate) <= $amount ) $echo_out = ''; else $echo_out = '...';
		$truncate = apply_filters('the_content', $truncate);
		$truncate = preg_replace('@<script[^>]*?>.*?</script>@si', '', $truncate);
		$truncate = preg_replace('@<style[^>]*?>.*?</style>@si', '', $truncate);
		
		$truncate = strip_tags($truncate);
		
		if ($echo_out == '...') $truncate = substr($truncate, 0, strrpos(substr($truncate, 0, $amount), ' '));
		else $truncate = substr($truncate, 0, $amount);

		if ($echo) echo $truncate,$echo_out;
		else return ($truncate . $echo_out);
	};
}


?>
<?php if (!function_exists ('add_action')) exit('No direct script access allowed');

class DOX_Paypal {
	
	var $enable;
	var $enable_live;
	var $live_url;
	var $test_url;
	var $paypal_adr;
	var $email;
	var $cost;
	var $currency;	
	var $item_name;	
	var $item_key;
	var $return_url;
	var $notify_url;
	var $custom;
	
	
	function DOX_Paypal($ad_id = '', $ad_key = '', $cost = 0)
	{
		$this->__construct($ad_id, $ad_key, $cost);
	}
  
	function __construct($ad_id = '', $ad_key = '', $cost = 0) 
	{	
		global $dox_options;
	
		$this->enable 		= false;
		$this->enable_live 	= false;
		$this->live_url 	= 'https://www.paypal.com/webscr';
		$this->test_url 	= 'https://www.sandbox.paypal.com/webscr';
		$this->paypal_adr 	= '';
		$this->email 	 	= $dox_options['paypal']['email'];
		$this->currency	 	= $dox_options['ad']['currency'];
		$this->cost		 	= $cost;
		$this->return_url 	= get_permalink( $dox_options['paypal']['return_page'] );
		$this->custom		= $ad_id;
		$this->item_name	= urlencode('Order#'.$ad_id);
		$this->item_key		= $ad_key;
		$this->notify_url   = trailingslashit(home_url()).'?paypalListener=paypal_standard_IPN';
		
		
		if ( $dox_options['paypal']['enable'] == 'true') $this->enable = true;

		if ( $dox_options['paypal']['live'] == 'true') $this->enable_live = true;
		
		if ($this->enable_live == true) {
			$this->paypal_adr = $this->live_url . '?';	
		}
		else {
			$this->paypal_adr = $this->test_url . '?test_ipn=1&';	
		}
	}
	
	function generate_link() {

		$this->paypal_adr .= 'cmd=_xclick';
		$this->paypal_adr .= '&business='.$this->email;
		$this->paypal_adr .= '&item_name='.$this->item_name;
		$this->paypal_adr .= '&amount='.$this->cost;
		$this->paypal_adr .= '&no_note=1';			
		$this->paypal_adr .= '&item_number='.$this->item_key;
		$this->paypal_adr .= '&currency_code='.$this->currency;		
		$this->paypal_adr .= '&no_shipping=1';	
		$this->paypal_adr .= '&charset=UTF-8';
		$this->paypal_adr .= '&rm=2';		
		$this->paypal_adr .= '&return='.$this->return_url;
		$this->paypal_adr .= '&notify_url='.$this->notify_url;
		$this->paypal_adr .= '&custom='.$this->custom;

		return $this->paypal_adr;
	}

}

function dox_check_ipn_request_is_valid($posted) {

		$posted['cmd'] = '_notify-validate';

        $params = array( 
        	'body' 			=> $posted,
        	'sslverify' 	=> false,
        	'timeout' 		=> 30
        );
		
		$payment = new DOX_Paypal();
		
		$response = wp_remote_post( $payment->paypal_adr, $params );
		
        if ( !is_wp_error($response) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 && (strcmp( $response['body'], "VERIFIED") == 0)) {
            return true;
        } else {
            // response was invalid & send email to admin
            wp_mail(get_option('admin_email'), 'PayPal IPN - Response', print_r($response, true)."\n\n\n".print_r($_REQUEST, true));
            return false;
        }	
		
}

function dox_payment_completed($posted) {


    // check posted data
    if ( !empty($posted['txn_type']) && !empty($posted['custom']) && is_numeric($posted['custom']) && $posted['custom']>0 ) {

		// lowercase
		$posted['payment_status'] = strtolower($posted['payment_status']);
		$posted['txn_type'] = strtolower($posted['txn_type']);
			
        $accepted_types = array('cart', 'instant', 'express_checkout', 'web_accept', 'masspay', 'send_money');

        // check transaction
        if (!in_array($posted['txn_type'], $accepted_types)) exit;
		
		// get ad info
		$post_id = (int)$posted['custom'];
		$auto = get_post($post_id);
		
		$payment_status =  get_post_meta($auto->ID, 'auto_payment_status', true);
		$payment_key = get_post_meta($auto->ID, 'auto_payment_key', true);

		if ($payment_status != DOX_STATUS_FEE_PENDING && 
			$payment_status != DOX_STATUS_FEATURED_PENDING && 
			$payment_status != DOX_STATUS_FEATURED_PENDING_WF ) exit;
			
        if ($payment_key != $posted['item_number']) exit;

		// sandbox fix
		if ($posted['test_ipn']==1 && $posted['payment_status']=='pending') $posted['payment_status'] = 'completed';		
		
        // status actions
        switch ($posted['payment_status']) :
		
            case 'completed' :
            	// payment completed
				
				$current_date = date("Y-m-d H:i:s");
				
				if ($payment_status == DOX_STATUS_FEE_PENDING ) {
					update_post_meta($auto->ID, 'auto_payment_status', DOX_STATUS_FEE_COMPLETED);
					update_post_meta($auto->ID, 'ad_fee_payment_date', $current_date);
					update_post_meta($auto->ID, 'ad_fee_payment_transaction_id', $posted['txn_id']);
					update_post_meta($auto->ID, 'ad_fee_payment_email', $posted['payer_email']);
					update_post_meta($auto->ID, 'ad_fee_payment_first_name', $posted['first_name']);
					update_post_meta($auto->ID, 'ad_fee_payment_last_name', $posted['last_name']);
					update_post_meta($auto->ID, 'ad_fee_payment_payment_type', $posted['payment_type']);
					update_post_meta($auto->ID, 'ad_fee_payment_amount', $posted['mc_gross']);
					update_post_meta($auto->ID, 'ad_fee_payment_currency', $posted['mc_currency']);				
				}
				elseif ($payment_status == DOX_STATUS_FEATURED_PENDING || $payment_status == DOX_STATUS_FEATURED_PENDING_WF ) {
					update_post_meta($auto->ID, 'auto_payment_status', DOX_STATUS_FEATURED_COMPLETED);
					update_post_meta($auto->ID, 'ad_featured_payment_date', $current_date);
					update_post_meta($auto->ID, 'ad_featured_payment_transaction_id', $posted['txn_id']);
					update_post_meta($auto->ID, 'ad_featured_payment_email', $posted['payer_email']);
					update_post_meta($auto->ID, 'ad_featured_payment_first_name', $posted['first_name']);
					update_post_meta($auto->ID, 'ad_featured_payment_last_name', $posted['last_name']);
					update_post_meta($auto->ID, 'ad_featured_payment_payment_type', $posted['payment_type']);
					update_post_meta($auto->ID, 'ad_featured_payment_amount', $posted['mc_gross']);
					update_post_meta($auto->ID, 'ad_featured_payment_currency', $posted['mc_currency']);				
				}				

            break;
            case 'denied' :
            case 'expired' :
            case 'failed' :
            case 'voided' :
                // no money
				if ($payment_status == DOX_STATUS_FEE_PENDING ) {
					update_post_meta($auto->ID, 'auto_payment_status', DOX_STATUS_FEE_VOIDED);
				}
				elseif ($payment_status == DOX_STATUS_FEATURED_PENDING || $payment_status == DOX_STATUS_FEATURED_PENDING_WF ) {
					update_post_meta($auto->ID, 'auto_payment_status', DOX_STATUS_FEATURED_VOIDED);
				}
            break;
            default:
            	// nothing
            break;
        endswitch;

    }

}

add_action('valid-paypal-ipn-request', 'dox_payment_completed');

function dox_check_ipn_response() {
		
	if (isset($_GET['paypalListener']) && $_GET['paypalListener'] == 'paypal_standard_IPN'):
		
		@ob_clean();
		
		$_POST = stripslashes_deep($_POST);
		
		if (dox_check_ipn_request_is_valid($_POST)) :
			
			header('HTTP/1.1 200 OK');
			
			do_action("valid-paypal-ipn-request", $_POST);
		
		else :
		
			wp_die("PayPal IPN Request Failure");
		
		endif;
		
	endif;
		
}

add_action('init', 'dox_check_ipn_response');

?>
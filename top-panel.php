<?php 	
		global $current_user, $dox_options;
		$user_logged = false;
		if ( is_user_logged_in() ) { 
			$user_logged = true;
			$author_url = get_author_posts_url( $current_user->ID );
		}
 ?>

<!-- #top-panel -->
<div id="topPanel">
	<div class="panel clearfix">

		<!-- .panel-alert -->
		<div class="panel-alert alert" style="display:none">
			<p></p>
		</div><!-- end .panel-alert -->
						
		<!-- IF USER IS LOGGED -->
		<?php if ($user_logged == true) { ?>
			<div class="inner">
				<div class="grid grid1">
					<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Top Panel (Logged Users)') ) ?>
				</div>			
				
				<!-- .account-nav -->
				<div class="grid grid2 account-nav">
					<h4 class="panel-title"><?php _e('MY ACCOUNT', 'autotrader') ?></h4>
					<ul>
						<li><?php echo '<a href="'.dox_get_submit_auto_page().'">'.get_the_title($dox_options['ad']['submit_page']).'</a>'; ?></li>
						<li><?php echo '<a href="'.dox_get_user_dashboard_page().'">'.get_the_title($dox_options['ad']['dashboard_page']).'</a>'; ?></li>
						<li><?php echo '<a href="'.dox_get_watchlist_page().'">'.get_the_title($dox_options['ad']['watchlist_page']).'</a>'; ?></li>
						<li><?php echo '<a href="'.$author_url.'">'.__('My Published Ads','autotrader').'</a>'; ?></li>
					</ul>					
				</div><!-- end- .account-nav -->	
				
				<!-- .user-profile -->
				<div class="grid grid3 user-profile">
					<h4 class="panel-title"><?php _e('User Profile', 'autotrader') ?></h4>
					<ul>
						<li><?php echo '<a href="'.dox_get_user_profile_page().'">'.get_the_title($dox_options['ad']['profile_page']).'</a>'; ?></li>
						<li><?php echo '<a href="'.dox_get_dealer_form_page().'">'.get_the_title($dox_options['ad']['dealer_page']).'</a>'; ?></li>						
						<li><?php echo '<a href="'.wp_logout_url(home_url()).'">'.__('Log Out','autotrader').'</a>'; ?></li>
					</ul>	
				</div><!-- end- .user-profile -->			
			
			</div>
		<!-- IF NOT USER IS LOGGED -->
		<?php } else {  ?>
			<div class="inner">
				<div class="grid grid1">
					<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Top Panel') ) ?>
				</div>
				
				<!-- .register -->
				<div class="grid grid2 register">
					<h4 class="panel-title"><?php _e('Register', 'autotrader') ?></h4>
					
					<form id="user-submit" method="post" action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>" class="wp-user-form">
						<div class="form-input">
							<label for="user_login"><?php _e('Username', 'autotrader'); ?>: </label>
							<input type="text" name="user_login" value="<?php echo esc_attr(stripslashes($user_login)); ?>" size="20" id="user_login" tabindex="101"/>
						</div>
						<div class="form-input">
							<label for="user_email"><?php _e('Your Email', 'autotrader'); ?>: </label>
							<input type="text" name="user_email" value="<?php echo esc_attr(stripslashes($user_email)); ?>" size="25" id="user_email" tabindex="102"/>
						</div>
						<div class="form-input">
							<label for="user_email"><?php _e('A password will be e-mailed to you.', 'autotrader'); ?></label>
						</div>					
						<div class="form-input">
							<?php do_action('register_form'); ?>
							<input type="submit" name="user-submit" value="<?php _e('Sign up', 'autotrader'); ?>" class="user-submit" tabindex="103" />
							<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>?register=true" />
							<input type="hidden" name="user-cookie" value="1" />
						</div>					
					</form>
					
				</div><!-- end- .register -->	
				
				<!-- .user-login -->
				<div class="grid grid3 user-login">
					<h4 class="panel-title"><?php _e('User Login', 'autotrader') ?></h4>
					<?php wp_login_form( $args ); ?>
				</div><!-- end- .user-login -->
				
			</div>
		<?php } ?>
		<!-- END - USER IS LOGGED -->
		
	</div>
	
	<div class="inner">
		<div class="panel-tab"><h4><?php if ($user_logged == true) { _e('MY ACCOUNT', 'autotrader'); } else { _e('POST A FREE AD', 'autotrader'); } ?></h4></div>
	</div>
	
	<div class="clear"></div>	
</div>
<div class="clear"></div>
<?php 	if ($user_logged == false) {
			$register = $_GET['register']; 
			if($register == true) {
				echo '<div class="alert alert-success"><p>';
					_e('Thank you for sign up to Autotrader. <br/>Please check your email for the password!', 'autotrader');
				echo '</p></div>';			
			}
?>
<script type="text/javascript">

	var $j = jQuery.noConflict();
	
	$j(document).ready(function(){			

		// register submit button
		$j('#user-submit').submit(function () {
			
			if ( $j('#user-submit #user_login').val() == '' || $j('#user-submit #user_email').val() == '' )
			{
				$j(".panel-alert").removeClass('alert-success alert-error alert-warning');
				$j(".panel-alert").addClass('alert-warning');
				
				$j(".panel-alert p").empty();
				$j(".panel-alert p").append('<?php _e('Please enter an username and an e-mail address','autotrader') ?>');
				
				$j('.panel-alert').css('display','block');
				$j('.panel-alert').delay(4000).slideUp(350); 	
							
				return false;
			}
			
		});	

		// login submit button
		$j('#loginform').submit(function () {
			
			if ( $j('#loginform #user_login').val() == '' || $j('#loginform #user_pass').val() == '' )
			{
				$j(".panel-alert").removeClass('alert-success alert-error alert-warning');
				$j(".panel-alert").addClass('alert-warning');
				
				$j(".panel-alert p").empty();
				$j(".panel-alert p").append('<?php _e('Please enter your username and password','autotrader') ?>');
				
				$j('.panel-alert').css('display','block');
				$j('.panel-alert').delay(4000).slideUp(350); 	
							
				return false;
			}
			
		});		
		
	})						  
</script>
<?php } ?>
<!-- end - #top-panel -->
<div class="login-popup-mask"></div>
<div class="login-popup">
	
	<div class="login-box">
		<h4 class="section-title section-line"><?php _e('User Login', 'autotrader') ?></h4>
		<div class="go-home"><a href="<?php echo home_url(); ?>"><?php _e('Home', 'autotrader') ?></a></div>
		
		<?php wp_login_form( $args ); ?>
	</div>
	
	<div class="line"></div>
</div>
<script type="text/javascript">

	var $j = jQuery.noConflict();
	
	$j(document).ready(function(){
		
		//Set the center alignment padding + border
		var popMargTop = ($j('.login-popup').height() + 40) / 2; 
		var popMargLeft = ($j('.login-popup').width() + 40) / 2; 
		
		$j('.login-popup').css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
			
	})						  
</script>		

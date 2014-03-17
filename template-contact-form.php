<?php 
/*
Template Name: Contact Form
*/
?>
<?php get_header(); ?>

<?php 
	
	$recaptcha = $dox_options['recaptcha']['enable'];
	if ($recaptcha == 'true') {
		wp_enqueue_script('dox_recaptcha', 'http://www.google.com/recaptcha/api/js/recaptcha_ajax.js', false, false, false);
	}

?>		
<!-- #contact-form -->
<div id="contact-form" class="dox-template container">
	<div class="container_12 clearfix">
		<div class="grid_12"><h3 class="page-title"><?php the_title(); ?></h3></div>

		<!-- .contact-form-alert -->
		<div class="contact-form-alert alert" style="display:none">
			<p></p>
		</div><!-- end .contact-form-alert -->
			
		<!-- #content -->
		<div id="content" class="grid_8">	
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<!-- .post -->
			<div <?php post_class('clearfix') ?> id="post-<?php the_ID(); ?>">
		
				<!-- .entry-content -->
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- end - .entry-content -->
				
				<h4 class="section-title section-line"><?php _e('Get in touch', 'autotrader') ?></h4>
				
				<!-- .step-form -->
				<div class="step-form">
				
					<!-- .step-form-wrap -->
					<div class="step-form-wrap">					
						<form id="contactForm" action="<?php echo get_permalink(); ?>" method="post">
						
							<div class="form-input clearfix">
								<label for="name"><?php _e('Your Name','autotrader'); ?></label>							
								<input type="text" name="name" id="name" size="25" maxlength="40" value=""/>
							</div>
							
							<div class="form-input clearfix">
								<label for="email"><?php _e('Email','autotrader'); ?></label>							
								<input type="text" name="email" id="email" size="40" maxlength="60" value=""/>
							</div>	
							
							<div class="form-input clearfix">
								<label for="phone"><?php _e('Phone Number','autotrader'); ?></label>							
								<input type="text" name="phone" id="phone" size="20" maxlength="12" value=""/>
							</div>									

							<div class="form-input clearfix">
								<label for="message"><?php _e('Your Message','autotrader'); ?></label>							
								<textarea name="message" id="message" cols="50" rows="5"></textarea>
							</div>
							
							<div class="form-input clearfix">
								<div id="recaptcha_container"></div>
							</div>							
							
							<div class="form-input clearfix">
								<input type="hidden" name="contact_submit" id="contact_submit" value="true" />
								<input type="submit" id="submitButton" name="submitButton" value="<?php _e('Submit Message','autotrader'); ?>"/>
							</div>							
								
						</form>
						
						<div class="clear"></div>
					</div><!-- .step-form-wrap -->
					
					<div class="clear"></div>
				</div><!-- end - .step-form -->
			
			</div><!-- end - .post -->
							
			<?php endwhile; endif; ?>
		</div><!-- end - #content -->
		
		<!-- #sidebar -->
		<div id="sidebar" class="grid_4">
			<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Right Sidebar') ) ?>		
		</div><!-- end - #sidebar -->		
		
		<div class="clear"></div>
	</div>	
</div>
<div class="clear"></div>
<!-- end - #contact-form -->
		
<?php get_footer(); ?>
<script type="text/javascript">
	var $j = jQuery.noConflict();

	init();
	
	function init() {
		create_recaptcha();
	}
	
	function create_recaptcha() {
		if ('<?php echo $recaptcha; ?>' == 'true') {
			Recaptcha.create("<?php echo $dox_options['recaptcha']['public_key']; ?>", "recaptcha_container", {
				theme: "<?php echo $dox_options['recaptcha']['theme']; ?>",
				lang: "<?php echo $dox_options['recaptcha']['lang']; ?>",
				callback: Recaptcha.focus_response_field}
			);
		}
	}
	
	function check_recaptcha() {
	
			$ret = false;
			
			$j.ajax({
				type    : 'POST',
				url     : '<?php echo admin_url('admin-ajax.php'); ?>',
				dataType: 'json',
				cache	: false,
				async	: false,
				timeout	: 10000,
				data    : { action : 'dox_check_recaptcha', 
							challenge_field: $j("input#recaptcha_challenge_field").val(),
							response_field: $j("input#recaptcha_response_field").val(),
							remote_ip: '<?php echo $_SERVER["REMOTE_ADDR"]; ?>'
						},
				success : function(response) {
					if (response.alert == "alert-success") { 						
						$ret = true;
					} else {
						
						create_recaptcha();
						
						$j(".contact-form-alert").removeClass('alert-success alert-error alert-warning');
						$j(".contact-form-alert").addClass(response.alert);
						
						$j(".contact-form-alert p").empty();
						$j(".contact-form-alert p").append(response.message);

						$j('.contact-form-alert').css('display','block');
						$j('.contact-form-alert').delay(4000).slideUp(350);	
						
						$ret = false;
					}
				}
			});	
			
			return $ret;
	}
	
	$j("#contactForm").submit(function(e){
		
		var $valid = false;
		
		if ('<?php echo $recaptcha; ?>' == 'true') $valid = check_recaptcha();
			else $valid = true;
		
		if ($valid == true) {
			
			$j.ajax({
				type    : 'POST',
				url     : '<?php echo admin_url('admin-ajax.php'); ?>',
				dataType: 'json',
				cache	: false,
				data    : { action : 'dox_send_mail', 
							name: $j("#name").val(), 
							email: $j("#email").val(),
							phone: $j("#phone").val(),
							title: '<?php echo __('Autotrader Contact Form Message','autotrader'); ?>', 
							message: $j("#message").val(), 
							mailto: 'to-me' },
				success : function(response) {
									
					$j(".contact-form-alert").removeClass('alert-success alert-error alert-warning');
					$j(".contact-form-alert").addClass(response.alert);
					
					$j(".contact-form-alert p").empty();
					$j(".contact-form-alert p").append(response.message);
					
					if (response.alert == "alert-success") { 
						$j("#name").val("");
						$j("#email").val("");
						$j("#phone").val("");
						$j("#message").val("");
					} 
					
					create_recaptcha();

					$j('.contact-form-alert').css('display','block');
					$j('.contact-form-alert').delay(4000).slideUp(350);	
				}
			});
		}		
		
		e.preventDefault();
		
		return false;
		
	});	
</script>
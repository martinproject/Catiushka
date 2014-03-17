<?php 
/*
Template Name: Dealer Form
*/
?>
<?php get_header(); ?>
		
<!-- #dealer-form -->
<div id="dealer-form" class="dox-template container">
	<div class="container_12 clearfix">
		<div class="grid_12"><h3 class="page-title"><?php the_title(); ?></h3></div>

		<!-- #content -->
		<div id="content" class="grid_8">			
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<!-- if-not-user-logged-in -->
			<?php	$user_logged = false;
					if ( !is_user_logged_in() ) {
						get_template_part( 'login-popup' ); 
					} else { $user_logged = true; global $current_user; }
			?><!-- end - if-not-user-logged-in -->
			
			<!-- .post -->
			<div <?php post_class('clearfix') ?> id="post-<?php the_ID(); ?>">
				
				<!-- .entry-content -->
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- end - .entry-content -->
				
				<!-- if-user-is-logged -->
				<?php if ($user_logged == true) {
				
					$alert_display = 'none';
					
					$dealer_data = array();
					
					if ( !isset($_POST['auto_save']) ) {
						$dealer_data =  get_user_meta($current_user->ID, 'dox_dealer_data', true);
						
						$map_lat = $dealer_data['map_lat'];
						$map_long = $dealer_data['map_long'];
										
						if (empty($map_lat) || empty($map_long) ) {
							$map_lat = $dox_options['map']['lat'];
							$map_long = $dox_options['map']['long'];
						}	
						
					} else {
					
						$dealer_data['title'] = $_POST['title'];
						$dealer_data['contact-person'] = $_POST['contact-person'];
						$dealer_data['phone'] = $_POST['phone'];
						$dealer_data['mobile'] = $_POST['mobile'];
						$dealer_data['fax'] = $_POST['fax'];
						$dealer_data['address'] = $_POST['address'];
						$dealer_data['city'] = $_POST['city'];
						$dealer_data['description'] = $_POST['description'];						
						
						if ( $_POST['mapLatitude'] != '' && $_POST['mapLongitude'] != '' 
								&& $_POST['mapLatitude'] != $dox_options['map']['lat'] && $_POST['mapLongitude'] != $dox_options['map']['long']  ) { 
							
							$dealer_data['map_lat'] = $_POST['mapLatitude'];
							$dealer_data['map_long'] = $_POST['mapLongitude'];

							$map_lat = $dealer_data['map_lat'];
							$map_long = $dealer_data['map_long'];							
						}						
						
						
						/* required files */
						require_once(ABSPATH . "wp-admin" . '/includes/image.php');
						require_once(ABSPATH . "wp-admin" . '/includes/file.php');
						require_once(ABSPATH . "wp-admin" . '/includes/media.php');
						
						if ( (isset($_FILES['attach'])) && ($_FILES['attach']['error'] == UPLOAD_ERR_OK) ) {
							$file = wp_handle_upload($_FILES['attach'], array('test_form' => false));
						}						
							
						if ( isset($file['url'])) {
							$dealer_data['logo_url'] = $file['url'];
						} else {
							$dealer_data['logo_url'] = $_POST['logo_url'];
						}
						
						$updated = false;
						$updated = update_user_meta( $current_user->ID, 'dox_dealer_data', $dealer_data );
						
						if ( $updated == true ) {
							$alert_display = 'block';
							$alert_type = 'alert-success';
							$alert_message = __('Your dealer informations have been updated successfully.','autotrader');
						} else {
							$alert_display = 'block';
							$alert_type = 'alert-error';
							$alert_message = __('Sorry, an error occured while updating your informations. Please try again.','autotrader');
						}
					}

				?>				
				
					<h4 class="section-title section-line"><?php _e('Dealer Information', 'autotrader') ?></h4>
					
					<!-- .step-form -->
					<div class="step-form">

						<!-- .step-alert -->
						<div class="alert <?php echo $alert_type; ?>" style="display:<?php echo $alert_display; ?>">
							<p><?php echo $alert_message; ?></p>
						</div><!-- end .step-alert -->
					
						<!-- .step-form-wrap -->
						<div class="step-form-wrap">
							<!-- display logo -->
								<?php if ($dealer_data['logo_url']) { ?>
									<img src="<?php echo $dealer_data['logo_url']; ?>" class="dealer-logo-preview" height="80" width="140">
								<?php } ?>
							<!-- end - upload logo -->	
								
							<form id="dealerForm" action="<?php echo get_permalink(); ?>" method="post" enctype="multipart/form-data">
							
								<div class="form-input clearfix">
									<label for="title"><?php _e('Dealer Title','autotrader'); ?></label>							
									<input type="text" name="title" id="title" size="40" maxlength="60" value="<?php echo $dealer_data['title']; ?>"/>
								</div>
								
								<div class="form-input clearfix">
									<label for="contact-person"><?php _e('Contact Person','autotrader'); ?></label>							
									<input type="text" name="contact-person" id="contact-person" size="25" maxlength="50" value="<?php echo $dealer_data['contact-person']; ?>"/>
								</div>	
								
								<!-- upload logo -->
								<div class="form-input clearfix">
									<label for="attach"><?php _e('Upload Logo', 'autotrader') ?></label>
									<input type="file" id="attach" name="attach">
									<span class="info"><?php _e('w:140px; h:80px','autotrader'); ?></span>
								</div><!-- end - upload logo -->							
								
								<div class="form-input clearfix">
									<label for="description"><?php _e('Description','autotrader'); ?></label>							
									<textarea name="description" id="description" cols="50" rows="5"><?php echo $dealer_data['description']; ?></textarea>
								</div>									

								<div class="form-input clearfix">
									<label for="phone"><?php _e('Phone Number','autotrader'); ?></label>							
									<input type="text" name="phone" id="phone" size="20" maxlength="15" value="<?php echo $dealer_data['phone']; ?>"/>
								</div>
								
								<div class="form-input clearfix">
									<label for="mobile"><?php _e('Mobile Phone','autotrader'); ?></label>							
									<input type="text" name="mobile" id="mobile" size="20" maxlength="15" value="<?php echo $dealer_data['mobile']; ?>"/>
								</div>

								<div class="form-input clearfix">
									<label for="fax"><?php _e('Fax Number','autotrader'); ?></label>							
									<input type="text" name="fax" id="fax" size="20" maxlength="15" value="<?php echo $dealer_data['fax']; ?>"/>
								</div>

								<div class="form-input clearfix">
									<label for="address"><?php _e('Address','autotrader'); ?></label>							
									<textarea name="address" id="address" cols="50" rows="5"><?php echo $dealer_data['address']; ?></textarea>
								</div>	

								<div class="form-input clearfix">
									<label for="city"><?php _e('City','autotrader'); ?></label>							
									<input type="text" name="city" id="city" size="20" maxlength="20" value="<?php echo $dealer_data['city']; ?>"/>
								</div>							

								<!-- show map  -->
								<?php if ($dox_options['map']['enable'] == 'true') { ?>
									<div class="clear"></div>
									<div class="form-input marginT20 clearfix">
										<label class="sub-title"><?php _e('Map', 'autotrader') ?></label>		
										<div id="googleMap"></div>										
										<input type="hidden" id="mapLatitude" name="mapLatitude" value="<?php echo $map_lat ?>"/>
										<input type="hidden" id="mapLongitude" name="mapLongitude" value="<?php echo $map_long ?>"/>
										<input type="hidden" id="mapZoom" name="mapZoom" value="<?php echo $dox_options['map']['zoom'] ?>"/>										
									</div>																
								<?php } ?><!-- end - show map  -->
								
								<div class="form-input clearfix">
									<input type="hidden" name="auto_save" id="auto_save" value="true" />
									<input type="hidden" name="logo_url" id="logo_url" value="<?php echo $dealer_data['logo_url']; ?>" />
									<input type="submit" id="saveButton" name="saveButton" value="<?php _e('Save','autotrader'); ?>"/>
								</div>							
									
							</form>
							
							<div class="clear"></div>
						</div><!-- .step-form-wrap -->
						
						<div class="clear"></div>
					</div><!-- end - .step-form -->				
				
				<?php } ?><!-- end-if-user-is-logged -->
				
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
<!-- end - #dealer-form -->
		
<?php get_footer(); ?>
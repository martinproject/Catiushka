<?php 
/*
Template Name: Edit an Ad
*/
?>
<?php get_header(); ?>
		
<!-- #edit-ad -->
<div id="editAd" class="dox-template container">
	<div class="container_12 clearfix">
		<div class="grid_12"><h3 class="page-title"><?php the_title(); ?></h3></div>

		<!-- #content -->
		<div id="content" class="grid_8">			
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<!-- if-not-user-logged-in -->
			<?php	$user_logged = false;
					if ( !is_user_logged_in() ) {
						$edit_error = true;
						get_template_part( 'login-popup' ); 
					} else { $user_logged = true; }
			?><!-- end - if-not-user-logged-in -->
			
			<!-- .post -->
			<div <?php post_class('clearfix') ?> id="post-<?php the_ID(); ?>">
			
			<!-- if-not-submit-button-clicked -->
			<?php	
				if ( !isset($_POST['auto_submit']) ) {
					
					/* if user is logged in */
					if ($user_logged == true) {
					
						$edit_error = false;
						
						global $wpdb, $wp_query;
						
						/* get the ad id from query */
						$ad_id = (get_query_var('ad_id')) ? get_query_var('ad_id') : 0;

						
						if ($ad_id > 0 ) { $auto = get_post($ad_id); }
						
						/* if auto id not found */
						if ($auto->ID != $ad_id || $auto->post_type != $dox_options['ad_set']['type']['base'] ) {
							
							$edit_error = true; 
							
							echo '<div class="alert alert-error"><p>';
								_e('The ad you were trying to edit could not be found', 'autotrader');
							echo '</p></div>';								
						}
						
						if ($edit_error == false) {
						
							/* get current user id */
							$current_user = wp_get_current_user();
						
							/* not authorized to edit */
							if ($auto->post_author != $current_user->ID) {
								
								$edit_error = true;
								
								echo '<div class="alert alert-error"><p>';
									_e('You are not authorized to edit this ad.', 'autotrader');
								echo '</p></div>';							
							}
						}
					}/* end - if user is logged in */
					
					
					/* if user can edit */
					if ($edit_error == false) {
					
						/* get all post terms */
						$postterms = dox_get_post_term($ad_id);
						//$payment_status = get_post_meta($auto->ID, 'auto_payment_status', true);
			
			?>
		
				<!-- .entry-content -->
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- end - .entry-content -->
				
				<h4 class="section-title section-line"><?php _e('Update Your Ad', 'autotrader') ?></h4>
				
				<!-- .step-form -->
				<div class="step-form">
				
					<!-- .step-alert -->
					<div class="step-alert alert alert-error" style="display:none">
						<p><?php _e('Please fill all the required fields.', 'autotrader') ?></p>
					</div><!-- end .step-alert -->
					
					<!-- .step-form-nav -->
					<div class="step-form-nav">
						<ul>
							<li class="selected"><span>1</span><?php _e('Features', 'autotrader') ?></li>
							<li class="has-map"><span>2</span><?php _e('Details', 'autotrader') ?></li>
							<li><span>3</span><?php _e('Contact', 'autotrader') ?></li>
							<li class="last"><span>4</span><?php _e('Update', 'autotrader') ?></li>
						</ul>
					</div><!-- end - .step-form-nav -->
					
					<!-- .step-form-wrap -->
					<div class="step-form-wrap">					
						<form id="submitForm" action="<?php echo get_permalink(); ?>" method="post" enctype="multipart/form-data">
							
							<!-- .step-1 -->
							<div class="step step-1">
							
							<?php if ($dox_options['ad_set']['model']['show'] == 'true') { ?>
								<div class="form-input form-input-50 clearfix">
									<label for="<?php echo $dox_options['ad_set']['model']['base']; ?>"><?php echo $dox_options['ad_set']['model']['name']; ?></label>
									<select name="<?php echo $dox_options['ad_set']['model']['base']; ?>" id="<?php echo $dox_options['ad_set']['model']['base']; ?>" class="<?php if ($dox_options['ad_set']['model']['required'] == 'true') echo 'required-field'; ?>"><?php dox_get_dd_terms( $dox_options['ad_set']['model']['query'], 0, $postterms[$dox_options['ad_set']['model']['query']][0][0], sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['model']['name'] ) ); ?></select>
								</div>
								
								<div class="form-input form-input-50 clearfix">
									<label for="<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>"><?php echo $dox_options['ad_set']['model']['sub']; ?></label>							
									<select name="<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>" id="<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>" class="<?php if ($dox_options['ad_set']['model']['required'] == 'true') echo 'required-field'; ?>"><?php dox_get_dd_terms( $dox_options['ad_set']['model']['query'], $postterms[$dox_options['ad_set']['model']['query']][0][0], $postterms[$dox_options['ad_set']['model']['query']][$postterms[$dox_options['ad_set']['model']['query']][0][0]][0], sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['model']['sub'] )); ?></select>
								</div>
							<?php } ?>
							
							
							<?php if ($dox_options['ad_set']['location']['show'] == 'true') { ?>
								<div class="form-input form-input-50 clearfix">
									<label for="<?php echo $dox_options['ad_set']['location']['base']; ?>"><?php echo $dox_options['ad_set']['location']['name']; ?></label>
									<select name="<?php echo $dox_options['ad_set']['location']['base']; ?>" id="<?php echo $dox_options['ad_set']['location']['base']; ?>" class="<?php if ($dox_options['ad_set']['model']['required'] == 'true') echo 'required-field'; ?>"><?php dox_get_dd_terms( $dox_options['ad_set']['location']['query'], 0, $postterms[$dox_options['ad_set']['location']['query']][0][0], sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['location']['name'] ) ); ?></select>																		
								</div>
								
								<div class="form-input form-input-50 clearfix">
									<label for="<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>"><?php echo $dox_options['ad_set']['location']['sub']; ?></label>
									<select name="<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>" id="<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>" class="<?php if ($dox_options['ad_set']['model']['required'] == 'true') echo 'required-field'; ?>"><?php dox_get_dd_terms( $dox_options['ad_set']['location']['query'], $postterms[$dox_options['ad_set']['location']['query']][0][0], $postterms[$dox_options['ad_set']['location']['query']][$postterms[$dox_options['ad_set']['location']['query']][0][0]][0], sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['location']['sub'] ) ); ?></select>								
								</div>
							<?php } ?>
							
							<?php if ($dox_options['ad_set']['condition']['show'] == 'true') { $req = ''; if($dox_options['ad_set']['condition']['required'] == 'true') $req = 'required-field'; ?>
								<div class="form-input form-input-50 clearfix">
									<label for="<?php echo $dox_options['ad_set']['condition']['base']; ?>"><?php echo $dox_options['ad_set']['condition']['name']; ?></label>							
									<?php wp_dropdown_categories( 'name='.$dox_options['ad_set']['condition']['base'].'&taxonomy='.$dox_options['ad_set']['condition']['query'].'&selected='.$postterms[$dox_options['ad_set']['condition']['query']][0][0].'&hide_empty=0&orderby=name&order=ASC&class=postform '.$req.'&show_option_all='. sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['model']['name'] ) ); ?>	
								</div>
							<?php } ?>
							
							<?php if ($dox_options['ad_set']['year']['show'] == 'true') { $req = ''; if($dox_options['ad_set']['year']['required'] == 'true') $req = 'required-field'; ?>
								<div class="form-input form-input-50 clearfix">
									<label for="ad<?php echo $dox_options['ad_set']['year']['base']; ?>"><?php echo $dox_options['ad_set']['year']['name']; ?></label>							
									<?php wp_dropdown_categories( 'name=ad'.$dox_options['ad_set']['year']['base'].'&taxonomy='.$dox_options['ad_set']['year']['query'].'&selected='.$postterms[$dox_options['ad_set']['year']['query']][0][0].'&hide_empty=0&orderby=name&order=DESC&class=postform '.$req.'&show_option_all='. sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['model']['name'] ) ); ?>	
								</div>
							<?php } ?>
								
							<?php if ($dox_options['ad_set']['transmission']['show'] == 'true') { $req = ''; if($dox_options['ad_set']['transmission']['required'] == 'true') $req = 'required-field'; ?>
								<div class="form-input form-input-50 clearfix">
									<label for="<?php echo $dox_options['ad_set']['transmission']['base']; ?>"><?php echo $dox_options['ad_set']['transmission']['name']; ?></label>							
									<?php wp_dropdown_categories( 'name='.$dox_options['ad_set']['transmission']['base'].'&taxonomy='.$dox_options['ad_set']['transmission']['query'].'&selected='.$postterms[$dox_options['ad_set']['transmission']['query']][0][0].'&hide_empty=0&orderby=name&order=ASC&class=postform '.$req.'&show_option_all='. sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['model']['name'] ) ); ?>	
								</div>
							<?php } ?>

							<?php if ($dox_options['ad_set']['color']['show'] == 'true') { $req = ''; if($dox_options['ad_set']['color']['required'] == 'true') $req = 'required-field'; ?>
								<div class="form-input form-input-50 clearfix">
									<label for="<?php echo $dox_options['ad_set']['color']['base']; ?>"><?php echo $dox_options['ad_set']['color']['name']; ?></label>							
									<?php wp_dropdown_categories( 'name='.$dox_options['ad_set']['color']['base'].'&taxonomy='.$dox_options['ad_set']['color']['query'].'&selected='.$postterms[$dox_options['ad_set']['color']['query']][0][0].'&hide_empty=0&orderby=name&order=ASC&class=postform '.$req.'&show_option_all='. sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['model']['name'] ) ); ?>	
								</div>
							<?php } ?>

							<?php if ($dox_options['ad_set']['fuelType']['show'] == 'true') { $req = ''; if($dox_options['ad_set']['fuelType']['required'] == 'true') $req = 'required-field'; ?>
								<div class="form-input form-input-50 clearfix">
									<label for="<?php echo $dox_options['ad_set']['fuelType']['base']; ?>"><?php echo $dox_options['ad_set']['fuelType']['name']; ?></label>							
									<?php wp_dropdown_categories( 'name='.$dox_options['ad_set']['fuelType']['base'].'&taxonomy='.$dox_options['ad_set']['fuelType']['query'].'&selected='.$postterms[$dox_options['ad_set']['fuelType']['query']][0][0].'&hide_empty=0&orderby=name&order=ASC&class=postform '.$req.'&show_option_all='. sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['model']['name'] ) ); ?>	
								</div>
							<?php } ?>

							<?php if ($dox_options['ad_set']['bodyType']['show'] == 'true') { $req = ''; if($dox_options['ad_set']['bodyType']['required'] == 'true') $req = 'required-field'; ?>
								<div class="form-input form-input-50 clearfix">
									<label for="<?php echo $dox_options['ad_set']['bodyType']['base']; ?>"><?php echo $dox_options['ad_set']['bodyType']['name']; ?></label>							
									<?php wp_dropdown_categories( 'name='.$dox_options['ad_set']['bodyType']['base'].'&taxonomy='.$dox_options['ad_set']['bodyType']['query'].'&selected='.$postterms[$dox_options['ad_set']['bodyType']['query']][0][0].'&hide_empty=0&orderby=name&order=ASC&class=postform '.$req.'&show_option_all='. sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['model']['name'] ) ); ?>	
								</div>
							<?php } ?>
								
							<?php if ($dox_options['ad_set']['cylinders']['show'] == 'true') { ?>
								<div class="form-input form-input-50 clearfix">
									<label for="<?php echo $dox_options['ad_set']['cylinders']['base']; ?>"><?php echo $dox_options['ad_set']['cylinders']['name']; ?></label>							
									<input type="text" value="<?php echo get_post_meta($ad_id, $dox_options['ad_set']['cylinders']['query'], true); ?>" name="<?php echo $dox_options['ad_set']['cylinders']['base']; ?>" id="<?php echo $dox_options['ad_set']['cylinders']['base']; ?>" size="9" class="<?php if ($dox_options['ad_set']['cylinders']['required'] == 'true') echo 'required-field'; ?>"/>
								</div>
							<?php } ?>

							<?php if ($dox_options['ad_set']['doors']['show'] == 'true') { ?>
								<div class="form-input form-input-50 clearfix">
									<label for="<?php echo $dox_options['ad_set']['doors']['base']; ?>"><?php echo $dox_options['ad_set']['doors']['name']; ?></label>							
									<input type="text" value="<?php echo get_post_meta($ad_id, $dox_options['ad_set']['doors']['query'], true); ?>" name="<?php echo $dox_options['ad_set']['doors']['base']; ?>" id="<?php echo $dox_options['ad_set']['doors']['base']; ?>" size="9" class="<?php if ($dox_options['ad_set']['doors']['required'] == 'true') echo 'required-field'; ?>"/>
								</div>
							<?php } ?>
								
							<?php if ($dox_options['ad_set']['mileage']['show'] == 'true') { ?>		
								<div class="form-input form-input-50 clearfix">
									<label for="<?php echo $dox_options['ad_set']['mileage']['base']; ?>"><?php echo $dox_options['ad_set']['mileage']['name']; ?></label>							
									<input type="text" value="<?php echo get_post_meta($ad_id, $dox_options['ad_set']['mileage']['query'], true); ?>" name="<?php echo $dox_options['ad_set']['mileage']['base']; ?>" id="<?php echo $dox_options['ad_set']['mileage']['base']; ?>" size="9" class="<?php if ($dox_options['ad_set']['mileage']['required'] == 'true') echo 'required-field'; ?>"/>
								</div>
							<?php } ?>

							<?php if ($dox_options['ad_set']['price']['show'] == 'true') { ?>
								<div class="form-input form-input-50 clearfix">
									<label for="<?php echo $dox_options['ad_set']['price']['base']; ?>"><?php echo $dox_options['ad_set']['price']['name']; ?></label>							
									<input type="text" value="<?php echo get_post_meta($ad_id, $dox_options['ad_set']['price']['query'], true); ?>" name="<?php echo $dox_options['ad_set']['price']['base']; ?>" id="<?php echo $dox_options['ad_set']['price']['base']; ?>" size="9" class="<?php if ($dox_options['ad_set']['price']['required'] == 'true') echo 'required-field'; ?>"/>
								</div>
							<?php } ?>
								
							<div style="float:left;width:100%">
								<div class="form-input form-input-50 clearfix">
									<a href="#" class="step-form-next button has-map"><?php _e('Next Step','autotrader'); ?></a>
								</div>
								
								<div class="form-input form-input-50 clearfix" >
									<label class="label_check label-chbx label-red label-bold clearfix" for="chbx_featured">
										<?php $chbx_checked = ''; $chbx_checked = get_post_meta($ad_id, 'featured_ad', true); ?>
										<input type="checkbox" name="chbx_featured" id="chbx_featured" <?php if ($chbx_checked == DOX_FEATURED_AD) echo 'checked="true" '; if($dox_options['ad']['featured_ad'] != 'true' || $chbx_checked == DOX_FEATURED_AD ) echo 'disabled="disabled"';  ?>/><?php printf( __('Set a featured ad for only %s %s.','autotrader'), $dox_options['ad']['featured_cost'], $dox_options['ad']['currency'] ); ?>
									</label>
								</div>
							</div>
								
							</div><!-- end -.step-1 -->
							
							<!-- .step-2 -->
							<div class="step step-2" style="display:none">
								
								<div class="form-input clearfix">
									<label for="title"><?php _e('Title','autotrader'); ?></label>									
									<input type="text" name="title" id="title" size="50" maxlength="60" class="required-field" value="<?php echo $auto->post_title; ?>"/>
								</div>	

								<div class="form-input clearfix">
									<label for="description"><?php _e('Description','autotrader'); ?></label>							
									<textarea name="description" id="description" class="required-field" cols="50" rows="5"><?php echo $auto->post_content; ?></textarea>
								</div>

								<!-- auto features -->
								<?php
										if ($dox_options['ad_set']['features']['show'] == 'true') { 
											$features = get_terms( $dox_options['ad_set']['features']['query'], 'parent=0&hide_empty=0&hierarchical=1&depth=1&orderby=name&order=ASC' );
											foreach ($features as $feature) { 
												if ($feature->term_id > 0) { ?>
													<div class="form-input clearfix">
														<label class="sub-title"><?php echo $feature->name; ?></label>												
													<?php 	$options = get_terms( $dox_options['ad_set']['features']['query'], 'child_of='.$feature->term_id.'&parent='.$feature->term_id.'&hide_empty=0&hierarchical=1&depth=1&orderby=name&order=ASC' );
															$counter = count($options);
															if ($counter > 0) {
																foreach ($options as $option) { 
																	if ($option->term_id > 0) {
																		$chbx_checked = false;
																		for($i = 0; $i < $counter; $i++) {
																			if ( !empty($postterms[$dox_options['ad_set']['features']['query']][$feature->term_id][$i]) ) {
																				if ( $postterms[$dox_options['ad_set']['features']['query']][$feature->term_id][$i] == $option->term_id ) { $chbx_checked = true; break; }
																			}
																		} /* end - for */ ?>
																		<div class="form-input form-input-33 clearfix">
																			<label class="label_check" for="chbx-<?php echo $option->slug; ?>">
																				<input type="checkbox" name="chbx-<?php echo $option->slug; ?>" id="chbx-<?php echo $option->slug; ?>" <?php if ($chbx_checked) echo 'checked="true"'; ?>/><?php echo $option->name; ?>
																			</label>
																		</div>
												<?php 				} 
																} /* end - foreach -> $options */
															} /* end - if -> $counter > 0 */ ?>												
													</div>
									<?php 		}
											} 
										}?><!-- end - auto features -->
								
								<!-- show map  -->
								<?php if ($dox_options['map']['enable'] == 'true') { 
										$map_lat = get_post_meta($ad_id, 'auto_map_lat', true);
										$map_long = get_post_meta($ad_id, 'auto_map_long', true);
										
										if (empty($map_lat) || empty($map_long) ) {
											$map_lat = $dox_options['map']['lat'];
											$map_long = $dox_options['map']['long'];
										}										
								?>
									<div class="clear"></div>
									<div class="form-input marginT20 clearfix">
										<label class="sub-title"><?php _e('Locate on Map', 'autotrader') ?></label>	
										<div id="googleMap"></div>										
										<input type="hidden" id="mapLatitude" name="mapLatitude" value="<?php echo $map_lat; ?>"/>
										<input type="hidden" id="mapLongitude" name="mapLongitude" value="<?php echo $map_long; ?>"/>
										<input type="hidden" id="mapZoom" name="mapZoom" value="<?php echo $dox_options['map']['zoom'] ?>"/>										
									</div>																
								<?php } ?><!-- end - show map  -->									
								
								<!-- embed video -->
								<div class="form-input clearfix">
									<label class="sub-title" for="attachment"><?php _e('Embed Video', 'autotrader') ?></label>
									
									<label for="videoID"><?php _e('Video ID','autotrader'); ?></label>									
									<input type="text" name="videoID" id="videoID" size="30" maxlength="40" value="<?php echo get_post_meta($ad_id, 'auto_video_id', true); ?>"/>
								</div>
								
								<div class="form-input clearfix">
									<label for="videoSource"><?php _e('Video Source','autotrader'); ?></label>									
									<select name="videoSource" id="videoSource">
										<option value="YOUTUBE" <?php if ( 'YOUTUBE' == get_post_meta($ad_id, 'auto_video_source', true) ) echo 'selected="selected"'; ?>><?php _e('Youtube','autotrader'); ?></option>
										<option value="VIMEO" <?php if ( 'VIMEO' == get_post_meta($ad_id, 'auto_video_source', true) ) echo 'selected="selected"'; ?>><?php _e('Vimeo','autotrader'); ?></option>
										<option value="VIDDLER" <?php if ( 'VIDDLER' == get_post_meta($ad_id, 'auto_video_source', true) ) echo 'selected="selected"'; ?>><?php _e('Viddler','autotrader'); ?></option>
									</select>
									
									<label class="label_check" for="chbx_video">
										<input type="checkbox" name="chbx_video" id="chbx_video" style="margin-top: 5px; margin-left:20px;" <?php if (get_post_meta($ad_id, 'auto_video_show', true) == true) echo 'checked="true"'; ?>/><?php _e('Show video instead of featured photo', 'autotrader') ?>
									</label>									
																		
								</div>																	
								<!-- end - embed video -->								
								
								<div class="form-input clearfix">
									<a href="#" class="step-form-next button"><?php _e('Next Step','autotrader'); ?></a>
								</div>
								
							</div><!-- end -.step-2 -->
							
							<!-- step-3 -->
							<div class="step step-3" style="display:none">
							
								<div class="form-input clearfix">
									<label for="person"><?php _e('Contact Person','autotrader'); ?></label>							
									<input type="text" name="person" id="person" size="25" maxlength="40" class="required-field" value="<?php echo get_post_meta($ad_id, 'auto_person', true); ?>"/>
								</div>
								
								<div class="form-input clearfix">
									<label for="email"><?php _e('Email','autotrader'); ?></label>							
									<input type="text" name="email" id="email" class="required-field" size="40" maxlength="60" value="<?php echo get_post_meta($ad_id, 'auto_email', true); ?>"/>
								</div>	
								
								<div class="form-input clearfix">
									<label for="phone"><?php _e('Phone Number','autotrader'); ?></label>							
									<input type="text" name="phone" id="phone" size="20" maxlength="12" value="<?php echo get_post_meta($ad_id, 'auto_phone', true); ?>"/>
								</div>
								
								<div class="form-input clearfix">
									<label for="mobile"><?php _e('Mobile Phone','autotrader'); ?></label>							
									<input type="text" name="mobile" id="mobile" size="20" maxlength="12" value="<?php echo get_post_meta($ad_id, 'auto_mobile', true); ?>"/>
								</div>
								
								<div class="form-input clearfix">
									<a href="#" class="step-form-next button"><?php _e('Next Step','autotrader'); ?></a>
								</div>
								
							</div><!-- end -.step-3 -->							
							
							<!-- step-4 -->
							<div class="step step-4" style="display:none">
							
								<!-- terms & conditions -->	
								<?php if ($dox_options['ad']['terms'] != '') { ?>
								<div class="form-input clearfix">
									<label for="terms"><?php _e('Terms & Conditions','autotrader'); ?></label>						
									<textarea name="terms" id="terms" class="terms" cols="50" rows="5" readonly="readonly"><?php echo $dox_options['ad']['terms']; ?></textarea>
								</div>
								<?php } ?><!-- end - terms & conditions -->	
								
								<div class="form-input clearfix">
									<label class="label_check clearfix" for="chbx_terms">
										<input type="checkbox" name="chbx_terms" id="chbx_terms"  checked="true" disabled="disabled"/><?php _e('I agree to the terms and conditions','autotrader'); ?>
									</label>
								</div>								
								
								<div class="form-input clearfix">
									<input type="hidden" name="auto_submit" id="auto_submit" value="true" />
									<input type="hidden" name="ad_id" id="ad_id" value="<?php echo $ad_id; ?>" />										
									<input type="submit" id="submitButton" name="submitButton" value="<?php _e('Submit','autotrader'); ?>" <?php if ($user_logged == false) { echo 'disabled="disabled"';} ?> />
								</div>
							
							</div><!-- end -.step-4 -->								
							
						</form>
						
						<div class="clear"></div>
					</div><!-- .step-form-wrap -->
					
					<div class="clear"></div>
				</div><!-- end - .step-form -->
																
			<?php 
			
					} /* end - $edit_error == false */
				} 
				/* else->if-not-submit-button-clicked */
				else { 
				
					$edit_error = false;
					
					/* get ad id avoiding injections */
					$ad_id = (int)$_POST['ad_id'];
					
					$new_payment_status = '';
					$payment_status = get_post_meta($ad_id, 'auto_payment_status', true);
					
					$chbx_checked = ''; 
					$chbx_checked = get_post_meta($ad_id, 'featured_ad', true);
					
					if ($ad_id > 0 ) { $auto = get_post($ad_id); }
					
					/* if auto id not found */
					if ($auto->ID != $ad_id || $auto->post_type != $dox_options['ad_set']['type']['base'] ) {
						
						$edit_error = true; 
						
						echo '<div class="alert alert-error"><p>';
							_e('The ad you were trying to edit could not be found', 'autotrader');
						echo '</p></div>';								
					}
					
					if ($edit_error == false) {
					
						/* get current user id */
						$current_user = wp_get_current_user();
					
						/* not authorized to edit */
						if ($auto->post_author != $current_user->ID) {
							
							$edit_error = true;
							
							echo '<div class="alert alert-error"><p>';
								_e('You are not authorized to edit this ad.', 'autotrader');
							echo '</p></div>';							
						}
					}						
					
					if ($edit_error == false) {
					
						/* get auto features */	
						$features = array();					
						$options = get_terms( $dox_options['ad_set']['features']['query'], 'hide_empty=0&hierarchical=1&depth=2&orderby=name&order=ASC' );
						
						foreach ($options as $option) {
						
							$chbx = 'chbx-'.$option->slug;
							
							if ( $_POST[$chbx] == true ) {
								$features[] =  $option->slug;
							}
						}
						

						/* get all post fields */
						$post_data = array( 
							'ID' => $ad_id,
							'post_author' => $current_user->ID,
							'post_type' => $dox_options['ad_set']['type']['base'],
							'post_title' => $_POST['title'],
							'post_content' => $_POST['description'],								
							'post_status' => 'pending',
							'comment_status' => 'closed',
							'ping_status' => 'closed'								
						);
						
						/* insert post */
						$ad_id = wp_insert_post( $post_data, $edit_error );
						

						/* add post meta data */
						if ( $edit_error == false ) {

							if ( $dox_options['ad_set']['model']['show'] == 'true' )		{ wp_set_object_terms( $ad_id, array( (int)$_POST[$dox_options['ad_set']['model']['base']], (int)$_POST[$dox_options['ad_set']['model']['base'].'sub'] ), $dox_options['ad_set']['model']['query']);	}
							if ( $dox_options['ad_set']['location']['show'] == 'true' )		{ wp_set_object_terms( $ad_id, array( (int)$_POST[$dox_options['ad_set']['location']['base']], (int)$_POST[$dox_options['ad_set']['location']['base'].'sub'] ), $dox_options['ad_set']['location']['query']);	}
							if ( $dox_options['ad_set']['year']['show'] == 'true' )			{ wp_set_object_terms( $ad_id, array( (int)$_POST['ad'.$dox_options['ad_set']['year']['base']] ), $dox_options['ad_set']['year']['query']);	}
							if ( $dox_options['ad_set']['transmission']['show'] == 'true' )	{ wp_set_object_terms( $ad_id, array( (int)$_POST[$dox_options['ad_set']['transmission']['base']] ), $dox_options['ad_set']['transmission']['query']);	}
							if ( $dox_options['ad_set']['color']['show'] == 'true' )		{ wp_set_object_terms( $ad_id, array( (int)$_POST[$dox_options['ad_set']['color']['base']] ), $dox_options['ad_set']['color']['query']);	}
							if ( $dox_options['ad_set']['fuelType']['show'] == 'true' )		{ wp_set_object_terms( $ad_id, array( (int)$_POST[$dox_options['ad_set']['fuelType']['base']] ), $dox_options['ad_set']['fuelType']['query']);	}
							if ( $dox_options['ad_set']['bodyType']['show'] == 'true' )		{ wp_set_object_terms( $ad_id, array( (int)$_POST[$dox_options['ad_set']['bodyType']['base']] ), $dox_options['ad_set']['bodyType']['query']);	}
							if ( $dox_options['ad_set']['condition']['show'] == 'true' )	{ wp_set_object_terms( $ad_id, array( (int)$_POST[$dox_options['ad_set']['condition']['base']] ), $dox_options['ad_set']['condition']['query']);	}
							if ( $dox_options['ad_set']['features']['show'] == 'true' )		{ wp_set_object_terms( $ad_id, $features, $dox_options['ad_set']['features']['query']);	}				
										
							if ( $dox_options['ad_set']['cylinders']['show'] == 'true' )	{ update_post_meta($ad_id, $dox_options['ad_set']['cylinders']['query'], $_POST[$dox_options['ad_set']['cylinders']['base']]); 		}
							if ( $dox_options['ad_set']['doors']['show'] == 'true' ) 		{ update_post_meta($ad_id, $dox_options['ad_set']['doors']['query'], $_POST[$dox_options['ad_set']['doors']['base']]); 				}
							if ( $dox_options['ad_set']['mileage']['show'] == 'true' ) 		{ update_post_meta($ad_id, $dox_options['ad_set']['mileage']['query'], $_POST[$dox_options['ad_set']['mileage']['base']]); 			}
							if ( $dox_options['ad_set']['price']['show'] == 'true' ) 		{ update_post_meta($ad_id, $dox_options['ad_set']['price']['query'], $_POST[$dox_options['ad_set']['price']['base']]); 				}							
														
							update_post_meta($ad_id, 'auto_person', $_POST['person']);
							update_post_meta($ad_id, 'auto_email', $_POST['email']);
							update_post_meta($ad_id, 'auto_phone', $_POST['phone']);
							update_post_meta($ad_id, 'auto_mobile', $_POST['mobile']);
						    update_post_meta($ad_id, 'auto_video_id', $_POST['videoID']); 
							update_post_meta($ad_id, 'auto_video_source', $_POST['videoSource']); 
							
							if ( $_POST['mapLatitude'] != '' && $_POST['mapLongitude'] != '' 
								&& $_POST['mapLatitude'] != $dox_options['map']['lat'] && $_POST['mapLongitude'] != $dox_options['map']['long']  ) 		{ 
								update_post_meta($ad_id, 'auto_map_lat', $_POST['mapLatitude']); 
								update_post_meta($ad_id, 'auto_map_long', $_POST['mapLongitude']);		
							}							
									
							
							
							$video_chbx = false;
							if ( $_POST['chbx_video'] == true ) $video_chbx = true;
							update_post_meta($ad_id, 'auto_video_show', $video_chbx);

							/* calculate cost */
							$cost = 0;
							if ($dox_options['paypal']['enable'] == 'true') {
								
								$std_cost = floatval($dox_options['ad']['ad_fee']);
								$featured_cost = floatval($dox_options['ad']['featured_cost']);
								
								if ( $chbx_checked == DOX_FEATURED_AD && $featured_cost > 0 ) {
																	
									if ($payment_status == DOX_STATUS_FEE_COMPLETED) { 
										$cost += $featured_cost; 
										$cost -= $std_cost; // fee back	
										$new_payment_status = DOX_STATUS_FEATURED_PENDING_WF;
									}
									elseif ($payment_status == DOX_STATUS_FEE_PENDING || $payment_status == DOX_STATUS_FEE_VOIDED ) {
										$cost += $featured_cost;
										$new_payment_status = DOX_STATUS_FEATURED_PENDING;
									}
									elseif ($payment_status == DOX_STATUS_FEATURED_COMPLETED) { 										
										$cost = 0; // no need for payment								
									}
									elseif ($payment_status == DOX_STATUS_FEATURED_PENDING || $payment_status == DOX_STATUS_FEATURED_VOIDED ) {
										$cost += $featured_cost;
										$new_payment_status = DOX_STATUS_FEATURED_PENDING;
									}
									elseif ($payment_status == DOX_STATUS_FEATURED_PENDING_WF ) {
										$cost += $featured_cost; 
										$cost -= $std_cost; // fee back	
										$new_payment_status = DOX_STATUS_FEATURED_PENDING;
									}									
									
									
								}elseif ( $dox_options['ad']['free_ad'] != 'true' && $std_cost > 0 && $payment_status != DOX_STATUS_FEE_COMPLETED ) {
									$new_payment_status = DOX_STATUS_FEE_PENDING;
									$cost += $std_cost;
								}
							}
							
							/* update payment key & status */
							if ($cost > 0) {
								$payment_key = uniqid('AdKey'.$ad_id, false);							
								update_post_meta($ad_id, 'auto_payment_key', $payment_key);

								if ( $chbx_checked == DOX_FEATURED_AD ) {
									update_post_meta($ad_id, 'featured_ad', $chbx_checked);
									update_post_meta($ad_id, 'auto_payment_status', $new_payment_status);						
								} else {
									update_post_meta($ad_id, 'auto_payment_status', $new_payment_status);
								}
							}
							
							/* if featured ad is for free */
							if ( $cost == 0 && $chbx_checked == DOX_FEATURED_AD ) {
								update_post_meta($ad_id, 'featured_ad', $chbx_checked);						
							}							
					
						}
						else { 
							echo '<div class="alert alert-error"><p>';
								_e('Sorry, an error occured while updating your advertisement. <br/>Please try to submit again.', 'autotrader');
							echo '</p></div>';					
						}
					}

					
					/* if advertisement submitted succesfully */
					if ( $edit_error == false ) { 
						echo '<div class="alert alert-success"><p>';
							_e('Your ad has been successfully updated.', 'autotrader');
						echo '</p></div>';

						echo '<div class="entry-content">';
							printf(__('Thanks for updating your advertisement. <br/> Your advertisement ID: <b>#%1$s </b><br/> Your advertisement will be re-published after moderation.', 'autotrader'), $ad_id );
						
						/* if user have to pay for ad, he is redirected to Paypal */
						if ($cost > 0) { 
						$payment = new DOX_Paypal($ad_id, $payment_key, $cost);
							$payment_link = $payment->generate_link();
							
							echo '<label class="label-red">'.__('You will be automotically redirected to Paypal site to complete your order.','autotrader').'</label>';
							echo '<META HTTP-EQUIV=Refresh CONTENT="2; URL='.$payment_link.'">';
							
						}						

						echo '</div>';
					}
				
			} ?><!-- end-if-not-submit-button-clicked -->
			
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
<!-- end - #edit-ad -->
		
<?php get_footer(); ?>

<script type="text/javascript">

	var $j = jQuery.noConflict();
	
	$j(document).ready(function(){
		
	<?php if ($dox_options['ad_set']['model']['show'] == 'true') { ?>
		function fill_dd_model() {
			$j("#submitForm #<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>").empty();
			
			var $make_id = $j("#submitForm #<?php echo $dox_options['ad_set']['model']['base']; ?>").val();

			
			$j.ajax({
				type    : 'POST',
				url     : '<?php echo admin_url('admin-ajax.php'); ?>',
				data    : { action : 'dox_get_model', make_id: $make_id, sel_text: true },
				success : function(response) {
					$j("#submitForm #<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>").removeAttr("disabled");
					$j("#submitForm #<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>").append(response);					
				}						
			});				
		
		}
		
		/* if make changed */
		$j("#submitForm #<?php echo $dox_options['ad_set']['model']['base']; ?>").change(function () {
			fill_dd_model();			
		});
	<?php } ?>
		
	
	<?php if ($dox_options['ad_set']['location']['show'] == 'true') { ?>
		function fill_dd_cities() {
			$j("#submitForm #<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>").empty();
			
			var $location_id = $j("#submitForm #<?php echo $dox_options['ad_set']['location']['base']; ?>").val();
			
			$j.ajax({
				type    : 'POST',
				url     : '<?php echo admin_url('admin-ajax.php'); ?>',
				data    : { action : 'dox_get_city', location_id: $location_id, sel_text: true },
				success : function(response) {
					$j("#submitForm #<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>").removeAttr("disabled");
					$j("#submitForm #<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>").append(response);					
				}						
			});				
		
		}		

		/* if location changed */
		$j("#submitForm #<?php echo $dox_options['ad_set']['location']['base']; ?>").change(function () {
			fill_dd_cities();			
		});	
	<?php } ?>		
			
	})						  
</script>
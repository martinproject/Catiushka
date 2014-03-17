<?php get_header(); ?>
<?php get_header();?>
<?php 
	global $dox_options;
	
	$recaptcha = $dox_options['recaptcha']['enable'];
	if ($recaptcha == 'true') {
		wp_enqueue_script('dox_recaptcha', 'http://www.google.com/recaptcha/api/js/recaptcha_ajax.js', false, false, false);
	}

?>
		
<!-- #single-auto -->
<div id="single-auto" class="container">
	<div class="container_12 clearfix">
		<div class="grid_12"><h3 class="page-title"><?php _e('Ad Details', 'autotrader') ?></h3></div>

		<!-- .single-auto-alert -->
		<div class="single-auto-alert alert" style="display:none">
			<p></p>
		</div><!-- end .single-auto-alert -->
			
		<!-- #content -->
		<div id="content" class="grid_8">	
			<?php if (have_posts()) : while (have_posts()) : the_post();
			
					/* get auto features */
					$postterms = dox_get_post_term(get_the_ID());
					
					$args = array( 'post_type' => 'attachment',
									'numberposts' => -1,
									'post_status' => null,
									'post_name' => 'default-thumb',
									'post_parent' => $post->ID
								);
								
					$attachments = get_posts( $args );
					
					/* get video embed */
					$videoID = get_post_meta($post->ID, 'auto_video_id', true);
					$videoSource = get_post_meta($post->ID, 'auto_video_source', true);
					$videoShow = get_post_meta($post->ID, 'auto_video_show', true);
					
					$video_embed = '';
					if ($videoID != ''){
						$video_embed = dox_get_video_embed($videoID, $videoSource);
					}
									
					?>
			
			<!-- .post -->
			<div <?php post_class('custom-post-type clearfix') ?> id="post-<?php the_ID(); ?>">
				
				<h3 class="title"><?php the_title(); ?></h3>
				
				<!-- .auto-photos -->
				<div class="auto-photos grid_8 alpha">
					
					<!-- .video-embed -->
					<?php if ($videoShow == true && $video_embed != '') { ?>
						<div class="post-image grid_5 alpha">
							<?php echo $video_embed; ?>			
							<div class="clear"></div>
						</div>
					<?php } else { ?><!-- end - .video-embed -->					
					
						<div class="post-image grid_5 alpha">
							<?php echo dox_get_post_image($post->ID, 'default-thumb', 'single', true); ?>
							<div class="clear"></div>
						</div>	
						
					<?php } ?>
					
					
					
					<div class="post-thumbs grid_3 omega">
						<div class="thumb-container tj_container clearfix">
						
						<?php if (count($attachments) > 6) { ?>
							<div class="tj_nav">
								<span id="tj_prev" class="tj_prev"><?php _e('Previous', 'autotrader') ?></span>
								<span id="tj_next" class="tj_next"><?php _e('Next', 'autotrader') ?></span>
							</div>
						<?php } ?>
							
							<?php dox_get_slide_thumbs( $post->ID ); ?>
						</div>
						<div class="clear"></div>
					</div>
					
				</div><!-- end - .auto-photos -->			
				
				<div class="grid_5 alpha">
					<!-- .entry-content -->
					<div class="entry-content">
						<h4 class="section-title section-line"><?php _e('Description', 'autotrader') ?></h4>
					    <a href="?watchlist=<?php echo the_ID(); ?>" class="watchlist-button-single button"><?php _e('Add to Watchlist','autotrader'); ?></a>
						<?php the_content(); ?>
					</div><!-- end - .entry-content -->

					<!-- .video-embed -->
					<?php if ($videoShow == false && $video_embed != '') { ?>
					<div class="video-embed">
						<h4 class="section-title section-line"><?php _e('Ad Video', 'autotrader') ?></h4>
						
						<?php echo $video_embed; ?>
					
						<div class="clear"></div>
					</div>
					<?php } ?><!-- end - .video-embed -->
					
					<!-- show map  -->
					<?php if ($dox_options['map']['enable'] == 'true') { 
								$map_lat = get_post_meta($post->ID, 'auto_map_lat', true);
								$map_long = get_post_meta($post->ID, 'auto_map_long', true);
								
								$map_show = true;
								if (empty($map_lat) || empty($map_long) ) {
									$map_show = false;
								}
								if ($map_show == true) {
									wp_enqueue_script('dox_google_map_api', 'https://maps.googleapis.com/maps/api/js?sensor=false', false, false, false);
									wp_enqueue_script('dox_google_map_show', get_template_directory_uri() . '/js/google_map_show.js', false, false, false);								
					?>
									<div class="google-map clearfix">
										<h4 class="section-title section-line"><?php _e('Location on Map', 'autotrader') ?></h4>		
										<div id="googleMap" style="width:378px;height:200px"></div>										
										<input type="hidden" id="mapLatitude" name="mapLatitude" value="<?php echo $map_lat ?>"/>
										<input type="hidden" id="mapLongitude" name="mapLongitude" value="<?php echo $map_long ?>"/>
										<input type="hidden" id="mapZoom" name="mapZoom" value="<?php echo $dox_options['map']['zoom'] ?>"/>										
									</div>																
					<?php } } ?><!-- end - show map  -->	
				
					<!-- .seller-info -->
					<div class="seller-info">
						<h4 class="section-title section-line"><?php _e('Seller Info', 'autotrader') ?></h4>
						
						<ul>
							<?php 	$sellername = get_post_meta($post->ID, 'auto_person', true);
									echo '<li><span>'.__('Seller Name','autotrader').'</span> : '.$sellername.'</li>';
									$phone = get_post_meta($post->ID, 'auto_phone', true);
									echo '<li><span>'.__('Phone Number','autotrader').'</span> : '.$phone.'</li>';
									$mobile = get_post_meta($post->ID, 'auto_mobile', true);
									echo '<li><span>'.__('Mobile Number','autotrader').'</span> : '.$mobile.'</li>';									
							?>
							<li><span><?php _e('Ad Date','autotrader'); ?></span> : <?php the_time( get_option('date_format') ); ?></li>	
						</ul>
						<div class="clear"></div>
					</div><!-- end - .seller-info -->
					
					<!-- .contact-seller -->
					<div class="contact-seller">
						<h4 class="section-title section-line"><?php _e('Contact to Seller', 'autotrader') ?></h4>
						
						<!-- .step-form -->
						<div class="step-form-alt">
								
							<!-- .step-form-wrap -->
							<div class="step-form-wrap">					
								<form id="contactForm" action="<?php echo get_permalink(); ?>" method="post">															
									
									<div class="form-input clearfix">
										<label for="sellername"><?php _e('Seller Name','autotrader'); ?></label>							
										<input type="text" name="sellername" id="sellername" size="25" disabled="true" value="<?php echo get_post_meta($post->ID, 'auto_person', true); ?>"/>
									</div>
									
									<div class="form-input clearfix">
										<label for="name"><?php _e('Your Name','autotrader'); ?></label>							
										<input type="text" name="name" id="name" size="25" maxlength="40" value=""/>
									</div>									
									
									<div class="form-input clearfix">
										<label for="email"><?php _e('Email','autotrader'); ?></label>							
										<input type="text" name="email" id="email" size="35" maxlength="60" value=""/>
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
										<input type="hidden" name="post_id" id="post_id" value="<?php echo the_ID(); ?>" />
										<input type="submit" id="submitButton" name="submitButton" value="<?php _e('Send Message','autotrader'); ?>"/>
									</div>							
										
								</form>
								
								<div class="clear"></div>
							</div><!-- .step-form-wrap -->
							<div class="clear"></div>
						</div><!-- end - .step-form -->	
						
					</div><!-- end - .contact-seller -->				
				</div>
				<div class="grid_3 omega">
					
					<!-- .auto-main-features -->
					<div class="auto-features">
						<h4 class="section-title section-line"><?php _e('Features', 'autotrader') ?></h4>
						<ul>
							<?php 	
									if ( $dox_options['ad_set']['price']['show'] == 'true' ) { 
										$price = get_post_meta($post->ID, $dox_options['ad_set']['price']['query'], true);
										echo '<li><span>'.$dox_options['ad_set']['price']['name'].'</span> : '.$price.' '.$dox_options['ad']['currency'].'</li>';
									}
									
									if ( $dox_options['ad_set']['model']['show'] == 'true' ) { 
										$make = get_term_by( 'id', $postterms[$dox_options['ad_set']['model']['query']][0][0], $dox_options['ad_set']['model']['query'] );
										echo '<li><span>'.$dox_options['ad_set']['model']['name'].'</span> : '.$make->name.'</li>';
										$model = get_term_by( 'id', $postterms[$dox_options['ad_set']['model']['query']][$postterms[$dox_options['ad_set']['model']['query']][0][0]][0], $dox_options['ad_set']['model']['query'] );									
										echo '<li><span>'.$dox_options['ad_set']['model']['sub'].'</span> : '.$model->name.'</li>';
									}
									
									if ( $dox_options['ad_set']['condition']['show'] == 'true' ) { 
										$condition = get_term_by( 'id', $postterms[$dox_options['ad_set']['condition']['query']][0][0], $dox_options['ad_set']['condition']['query'] );
										echo '<li><span>'.$dox_options['ad_set']['condition']['name'].'</span> : '.$condition->name.'</li>';
									}
									
									if ( $dox_options['ad_set']['location']['show'] == 'true' ) { 
										$location = get_term_by( 'id', $postterms[$dox_options['ad_set']['location']['query']][0][0], $dox_options['ad_set']['location']['query'] );
										echo '<li><span>'.$dox_options['ad_set']['location']['name'].'</span> : '.$location->name.'</li>';	
										$city = get_term_by( 'id', $postterms[$dox_options['ad_set']['location']['query']][$postterms[$dox_options['ad_set']['location']['query']][0][0]][0], $dox_options['ad_set']['location']['query'] );									
										echo '<li><span>'.$dox_options['ad_set']['location']['sub'].'</span> : '.$city->name.'</li>';	
									}									
									
									if ( $dox_options['ad_set']['mileage']['show'] == 'true' ) { 
										$mileage = get_post_meta($post->ID, $dox_options['ad_set']['mileage']['query'], true);
										echo '<li><span>'.$dox_options['ad_set']['mileage']['name'].'</span> : '.$mileage.'</li>';
									}
									
									if ( $dox_options['ad_set']['year']['show'] == 'true' ) { 
										$autoyear = get_term_by( 'id', $postterms[$dox_options['ad_set']['year']['query']][0][0], $dox_options['ad_set']['year']['query'] );
										echo '<li><span>'.$dox_options['ad_set']['year']['name'].'</span> : '.$autoyear->name.'</li>';
									}
									
									if ( $dox_options['ad_set']['color']['show'] == 'true' ) { 
										$colour = get_term_by( 'id', $postterms[$dox_options['ad_set']['color']['query']][0][0], $dox_options['ad_set']['color']['query'] );
										echo '<li><span>'.$dox_options['ad_set']['color']['name'].'</span> : '.$colour->name.'</li>';
									}	
									
									if ( $dox_options['ad_set']['fuelType']['show'] == 'true' ) { 
										$fuel_type = get_term_by( 'id', $postterms[$dox_options['ad_set']['fuelType']['query']][0][0], $dox_options['ad_set']['fuelType']['query'] );
										echo '<li><span>'.$dox_options['ad_set']['fuelType']['name'].'</span> : '.$fuel_type->name.'</li>';
									}
									
									if ( $dox_options['ad_set']['bodyType']['show'] == 'true' ) { 
										$body_type = get_term_by( 'id', $postterms[$dox_options['ad_set']['bodyType']['query']][0][0], $dox_options['ad_set']['bodyType']['query'] );
										echo '<li><span>'.$dox_options['ad_set']['bodyType']['name'].'</span> : '.$body_type->name.'</li>';
									}
									
									if ( $dox_options['ad_set']['doors']['show'] == 'true' ) { 
										$doors = get_post_meta($post->ID, $dox_options['ad_set']['doors']['query'], true);
										echo '<li><span>'.$dox_options['ad_set']['doors']['name'].'</span> : '.$doors.'</li>';
									}
									
									if ( $dox_options['ad_set']['cylinders']['show'] == 'true' ) { 
										$cylinders = get_post_meta($post->ID, $dox_options['ad_set']['cylinders']['query'], true);
										echo '<li><span>'.$dox_options['ad_set']['cylinders']['name'].'</span> : '.$cylinders.'</li>';
									}
									
									if ( $dox_options['ad_set']['transmission']['show'] == 'true' ) { 
										$transmission = get_term_by( 'id', $postterms[$dox_options['ad_set']['transmission']['query']][0][0], $dox_options['ad_set']['transmission']['query'] );
										echo '<li><span>'.$dox_options['ad_set']['transmission']['name'].'</span> : '.$transmission->name.'</li>';
									}									
							?>
						</ul>
						<div class="clear"></div>
					</div><!-- end - .auto-main-features -->	
					
					<!-- auto features -->
					<?php
							if ( $dox_options['ad_set']['features']['show'] == 'true' ) { 
								$features = get_terms( $dox_options['ad_set']['features']['query'], 'parent=0&hide_empty=0&hierarchical=1&depth=1&orderby=name&order=ASC' );
								foreach ($features as $feature) { 
									if ($feature->term_id > 0) { ?>
										<div class="auto-features">
											<h4 class="section-title section-line"><?php echo $feature->name; ?></h4>
											<ul>										
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
																
																<?php if ( !($dox_options['ad']['show_empty_features'] == '' && $chbx_checked == false) ) { ?>
																<li>
																	<label class="label_check" for="chbx-<?php echo $option->slug; ?>">
																		<input type="checkbox" name="chbx-<?php echo $option->slug; ?>" id="chbx-<?php echo $option->slug; ?>" <?php if ($chbx_checked) echo 'checked="true"'; ?> disabled="true"><?php echo $option->name; ?>
																	</label>
																</li>
																<?php } ?>
											<?php 			} 
													} /* end - foreach -> $options */
												} /* end - if -> $counter > 0 */ ?>												
											</ul>
											<div class="clear"></div>
										</div>
					<?php 			}
								}
							}?><!-- end - auto features -->					
					
					
				</div>
			
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
<!-- end - #single-auto -->
		
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
				lang: "<?php echo $dox_options['recaptcha']['lang']; ?>" }
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
						
						$j(".single-auto-alert").removeClass('alert-success alert-error alert-warning');
						$j(".single-auto-alert").addClass(response.alert);
						
						$j(".single-auto-alert p").empty();
						$j(".single-auto-alert p").append(response.message);

						$j('.single-auto-alert').css('display','block');
						$j('.single-auto-alert').delay(4000).slideUp(350);	
						
						$ret = false;
					}
				}
			});	
			
			return $ret;
	}	
	
	$j("a[rel^='prettyPhoto']").prettyPhoto( { opacity: '0.40', show_title: false, social_tools: '' } );
	
	$j(function() {
		$j('.thumb-container').gridnav({
			rows: 3,
			type	: {
				mode		: 'fade', 	// use def | fade | seqfade | updown | sequpdown | showhide | disperse | rows
				speed		: 500,			// for fade, seqfade, updown, sequpdown, showhide, disperse, rows
				easing		: '',			// for fade, seqfade, updown, sequpdown, showhide, disperse, rows	
				factor		: '',			// for seqfade, sequpdown, rows
				reverse		: ''			// for sequpdown
			}
		});
	});
	
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
							phone: '',
							title: '<?php echo __('Autotrader Ad Message','autotrader'); ?>', 
							message: $j("#message").val(), 
							mailto: $j("#post_id").val() },
				success : function(response) {
									
					$j(".single-auto-alert").removeClass('alert-success alert-error alert-warning');
					$j(".single-auto-alert").addClass(response.alert);
					
					$j(".single-auto-alert p").empty();
					$j(".single-auto-alert p").append(response.message);
					
					if (response.alert == "alert-success") { 
						$j("#name").val("");
						$j("#email").val("");
						$j("#message").val("");
					}

					create_recaptcha();
					
					$j('.single-auto-alert').css('display','block');
					$j('.single-auto-alert').delay(4000).slideUp(350);	
				}
			});	
			
		}
		e.preventDefault();
		
		return false;		
	});	
	
	// add to watchlist
	$j('#content .custom-post-type .watchlist-button-single').click(function() {
		
		// get post id
		var $post_id = $j(this).attr("href").match(/watchlist=([0-9]+)/)[1];
		
		$j.ajax({
			type    : 'POST',
			url     : '<?php echo admin_url('admin-ajax.php'); ?>',
			dataType: 'json',
			cache	: false,
			data    : { action 	 : 'dox_add_to_watchlist', 
						post_id  : $post_id },
			success : function(response) {
				
				$j(".single-auto-alert").removeClass('alert-success alert-error alert-warning');
				$j(".single-auto-alert").addClass(response.alert);
				
				$j(".single-auto-alert p").empty();
				$j(".single-auto-alert p").append(response.message);

				$j('.single-auto-alert').css('display','block');
				$j('.single-auto-alert').delay(4000).slideUp(350); 
				
			}
		});				

		
		return false;
	})
		
</script>
<?php get_header(); ?>

<?php
	if ( $dox_options['map']['enable'] == 'true'  ) {
		wp_enqueue_script('dox_google_map_api', 'https://maps.googleapis.com/maps/api/js?sensor=false', false, false, false);
		wp_enqueue_script('dox_google_map_show', get_template_directory_uri() . '/js/google_map_show.js', false, false, false);
	}	
?>	

<!-- #user-ads -->
<div id="user-ads" class="container">
	<div class="container_12 clearfix">
		<div class="grid_12"><h3 class="page-title">
			<?php 
					global $wp_query;
					
					$curauth = $wp_query->get_queried_object();
					
					$dealer_data = array();
					$dealer_data =  get_user_meta($curauth->ID, 'dox_dealer_data', true);
					
					if (! empty($dealer_data)) { echo $dealer_data['title']; }
					else { echo __('Ads by: ','autotrader').$curauth->display_name; }
					
					$map_lat = $dealer_data['map_lat'];
					$map_long = $dealer_data['map_long'];
					
					$map_show = true;					
					if (empty($map_lat) || empty($map_long) ) {
						$map_show = false;
					}						
			?> 
					
		</h3></div>

		<!-- .user-alert -->
		<div class="user-alert alert" style="display:none">
			<p></p>
		</div><!-- end .user-alert -->
				
		<!-- #content -->
		<div id="content" class="grid_8 listing">	
			
			<!-- .dealer-data -->
			<?php if (! empty($dealer_data)) { ?>
				<div class="dealer-data">
					<div class="dealer-logo grid_2 alpha">
						<img src="<?php echo $dealer_data['logo_url']; ?>" class="dealer-logo" width="140">
					</div>
					<div class="grid_6 omega">
						<div class="description"><?php echo $dealer_data['description']; ?></div>
						<label class="sub-title"><?php echo __('Contact Person', 'autotrader').' : '.$dealer_data['contact-person']; ?></label>						
						<div class="tel grid_2 alpha">
							<p><span><?php _e('Phone', 'autotrader') ?></span>: <?php echo $dealer_data['phone']; ?></p>
							<p><span><?php _e('Mobile', 'autotrader') ?></span>: <?php echo $dealer_data['mobile']; ?></p>
							<p><span><?php _e('Fax', 'autotrader') ?></span>: <?php echo $dealer_data['fax']; ?></p>
						</div>
						<div class="address grid_4 omega">
							<?php echo $dealer_data['address']; ?>
						</div>
						
						<!-- show map  -->
						<?php if ($dox_options['map']['enable'] == 'true' && $map_show == true) { ?>
							<div class="clear"></div>
							<div class="form-input marginT20 clearfix">
								<label class="sub-title"><?php _e('Location on Map', 'autotrader') ?></label>		
								<div id="googleMap" style="width:458px;height:220px"></div>										
								<input type="hidden" id="mapLatitude" name="mapLatitude" value="<?php echo $map_lat ?>"/>
								<input type="hidden" id="mapLongitude" name="mapLongitude" value="<?php echo $map_long ?>"/>
								<input type="hidden" id="mapZoom" name="mapZoom" value="<?php echo $dox_options['map']['zoom'] ?>"/>										
							</div>																
						<?php } ?><!-- end - show map  -->
								
					</div>
				</div>
			<?php } ?><!-- end - .dealer-data -->
			
			
			<h4 class="section-title section-line"><?php _e('Latest Ads', 'autotrader') ?></h4>
			
			<!-- .user-ad-results -->
			<div class="user-ad-results">
				<!-- Ajax container -->
			</div><!-- end - .user-ad-results -->
			
			
			<!-- .user-ad-paging -->
			<div class="user-ad-paging">
				<!-- Ajax container -->
			</div><!-- end - .user-ad-paging -->	
			
		</div><!-- end - #content -->
		
		<!-- #sidebar -->
		<div id="sidebar" class="grid_4">
			<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Right Sidebar') ) ?>
		</div><!-- end - #sidebar -->		
		
		<div class="clear"></div>
	</div>	
</div>
<div class="clear"></div>
<!-- end - #user-ads -->
		
<?php get_footer(); ?>
<script type="text/javascript">

	var $j = jQuery.noConflict();
	
	$j(document).ready(function(){			

		initialization();
		
		function initialization() {
		
			$j('#user-ads').data('page_nr', '1');
			
			show_user_ads();
		}
		
		function show_user_ads() {
		
			$page_nr = $j('#user-ads').data('page_nr'); 

			$j.ajax({
				type    : 'POST',
				url     : '<?php echo admin_url('admin-ajax.php'); ?>',
				dataType: 'json',
				cache	: false,
				data    : { action 	 : 'dox_show_user_ads', 
							user_id  : '<?php echo $curauth->ID; ?>',
							page_nr  : $page_nr },
				success : function(response) {
					$j("#user-ads .user-ad-results").empty();
					$j("#user-ads .user-ad-paging").empty();
					
					if (response.alert) {
						$j("#user-ads .user-alert").removeClass('alert-success alert-error alert-warning');
						$j("#user-ads .user-alert").addClass(response.alert);
						
						$j("#user-ads .user-alert p").empty();
						$j("#user-ads .user-alert p").append(response.message);

						$j('#user-ads .user-alert').css('display','block');
						$j('#user-ads .user-alert').delay(4000).slideUp(350); 	
					} else {
						$j("#user-ads .user-ad-results").append(response.results);
						$j("#user-ads .user-ad-paging").append(response.pager);							
					}
				}
			});			
		}	

		// paging
		$j("a.pager").live("click", function(){
			
			$j('#user-ads').removeData('page_nr');
			$j('#user-ads').data('page_nr', $j(this).text());
			
			show_user_ads();
			
			return false;
		});			
				
		// add to watchlist
		$j('.listing .custom-post-type .watchlist-button').live("click", function() {
			
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
					
					$j(".user-alert").removeClass('alert-success alert-error alert-warning');
					$j(".user-alert").addClass(response.alert);
					
					$j(".user-alert p").empty();
					$j(".user-alert p").append(response.message);

					$j('.user-alert').css('display','block');
					$j('.user-alert').delay(4000).slideUp(350); 

				}
			});				

			
			return false;
		});			
		
	})						  
</script>
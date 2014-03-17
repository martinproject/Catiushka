<?php get_header(); ?> 

<!-- #featured-cars -->
<div id="featuredCars" class="container">
	<div class="container_12 clearfix">
		<div class="grid_12 clearfix"><h4 class="section-title section-line"><?php _e('Featured Cars', 'autotrader'); ?></h4></div>
			
		<div id="featuredCars_tj_container" class="grid_12 tj_container">
			
			<div class="tj_nav">
				<span id="tj_prev" class="tj_prev">Previous</span>
				<span id="tj_next" class="tj_next">Next</span>
			</div>
			
			<div class="tj_wrapper">
				<ul class="tj_gallery">
				<?php	
					$args = array ( 'post_type' => $dox_options['ad_set']['type']['base'],
									'posts_per_page' => $dox_options['home']['featured_ad_nr'],
									'meta_query' => array ( 
															array( 'key' => 'featured_ad', 'value' => DOX_FEATURED_AD, 'type' => 'CHAR', 'compare' => '==' ) 
														)
								);
					$featuredAutos = new WP_Query( $args );

					$counter = 0;
					while ($featuredAutos->have_posts()) : $featuredAutos->the_post(); 
					$counter++; 
					if ($counter == 1) $className = 'alpha'; 
						elseif ($counter == 3) { $className = 'omega'; $counter = 0; }
						else $className = ''; ?>
				
					<li class="grid_4 <?php echo $className; ?>">
						<a href="<?php the_permalink(); ?>" class="image-zoom">
							<?php echo dox_get_post_image($post->ID, 'default-thumb', 'featured' ); ?>
							<span class="zoom-icon"></span>
						</a>
						<h5 class="marginT5"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
						<div class="clear"></div>
					</li>					
				<?php endwhile; ?>
				</ul>
			</div>
			
		</div>
			
		<div class="clear"></div>
	</div>
</div>
<div class="clear"></div>

<script type="text/javascript">
	var $j = jQuery.noConflict();
	
	$j(function() {
		$j('#featuredCars_tj_container').gridnav({
			rows: 1,
			type	: {
				mode		: 'seqfade', 	// use def | fade | seqfade | updown | sequpdown | showhide | disperse | rows
				speed		: 800,			// for fade, seqfade, updown, sequpdown, showhide, disperse, rows
				easing		: '',			// for fade, seqfade, updown, sequpdown, showhide, disperse, rows	
				factor		: 100,			// for seqfade, sequpdown, rows
				reverse		: ''			// for sequpdown
			}
		});
	});
</script>
<!-- end - #featured-cars -->

		
<div class="container">
	<div class="container_12 clearfix">
		
		<!-- #browser -->
		<div id="browser" class="grid_8">
			<h4 class="section-title section-line"><?php _e('Browse Cars', 'autotrader') ?></h4>
			
			<div class="grid_2 alpha browser-cat">
				<h5><?php echo dox_get_browse_name_by_query($dox_options['home']['browse_make']['query']); ?></h5>
				<ul>
					<?php echo dox_get_list_terms($dox_options['home']['browse_make']['query'], 0,  $dox_options['home']['browse_make']['number'], $dox_options['home']['browse_make']['orderby'], $dox_options['home']['browse_make']['order']); ?> 
				</ul>
			</div>

			<div class="grid_2 browser-cat">
				<h5><?php echo dox_get_browse_name_by_query($dox_options['home']['browse_body_type']['query']); ?></h5>
				<ul>
					<?php echo dox_get_list_terms($dox_options['home']['browse_body_type']['query'], 0,  $dox_options['home']['browse_body_type']['number'], $dox_options['home']['browse_body_type']['orderby'], $dox_options['home']['browse_body_type']['order']); ?> 
				</ul>
				
				<h5><?php echo dox_get_browse_name_by_query($dox_options['home']['browse_fuel_type']['query']); ?></h5>
				<ul>
					<?php echo dox_get_list_terms($dox_options['home']['browse_fuel_type']['query'], 0,  $dox_options['home']['browse_fuel_type']['number'], $dox_options['home']['browse_fuel_type']['orderby'], $dox_options['home']['browse_fuel_type']['order']); ?> 
				</ul>			
			</div>

			<div class="grid_2 browser-cat">

				<h5><?php echo dox_get_browse_name_by_query($dox_options['home']['browse_year']['query']); ?></h5>
				<ul class="by-year clearfix">
					<?php echo dox_get_list_terms($dox_options['home']['browse_year']['query'], 0,  $dox_options['home']['browse_year']['number'], $dox_options['home']['browse_year']['orderby'], $dox_options['home']['browse_year']['order']); ?> 
				</ul>
				
				<h5><?php echo dox_get_browse_name_by_query($dox_options['home']['browse_color']['query']); ?></h5>
				<ul>
					<?php echo dox_get_list_terms($dox_options['home']['browse_color']['query'], 0,  $dox_options['home']['browse_color']['number'], $dox_options['home']['browse_color']['orderby'], $dox_options['home']['browse_color']['order']); ?> 
				</ul>			
			</div>
			
			<div class="grid_2 omega browser-cat">
				<h5><?php echo dox_get_browse_name_by_query($dox_options['home']['browse_location']['query']); ?></h5>
				<ul>
					<?php echo dox_get_list_terms($dox_options['home']['browse_location']['query'], 0,  $dox_options['home']['browse_location']['number'], $dox_options['home']['browse_location']['orderby'], $dox_options['home']['browse_location']['order']); ?> 
				</ul>
			</div>			
			
		</div><!-- end - #browser -->
		
		<!-- #search -->
		<div class="grid_4">
			<h4 class="section-title section-line"><?php _e('Search Cars', 'autotrader') ?></h4>
			
			<div id="homeSearch">
				<form id="homeSearchForm" action="<?php echo dox_get_search_autos_results_page(); ?>" method="post">
					
					<?php if ($dox_options['ad_set']['condition']['show'] == 'true' && $dox_options['ad_set']['condition']['search'] == 'true'  ) { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['condition']['base']; ?>"><?php echo $dox_options['ad_set']['condition']['name']; ?></label>
						<select name="<?php echo $dox_options['ad_set']['condition']['base']; ?>[]" id="<?php echo $dox_options['ad_set']['condition']['base']; ?>"><?php dox_get_dd_terms( $dox_options['ad_set']['condition']['query'], 0,0, sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['condition']['name'] ) ); ?></select>
					</div>
					<?php } ?>						
					
					<?php if ($dox_options['ad_set']['model']['show'] == 'true' && $dox_options['ad_set']['model']['search'] == 'true') { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['model']['base']; ?>"><?php echo $dox_options['ad_set']['model']['name']; ?></label>
						<select name="<?php echo $dox_options['ad_set']['model']['base']; ?>[]" id="<?php echo $dox_options['ad_set']['model']['base']; ?>"><?php dox_get_dd_terms( $dox_options['ad_set']['model']['query'], 0,0, sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['model']['name'] ) ); ?></select>
					</div>
					
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>"><?php echo $dox_options['ad_set']['model']['sub']; ?></label>							
						<select name="<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>[]" id="<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>" disabled="disabled" ></select>
					</div>
					<?php } ?>
					
					<?php if ($dox_options['ad_set']['location']['show'] == 'true' && $dox_options['ad_set']['location']['search'] == 'true') { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['location']['base']; ?>"><?php echo $dox_options['ad_set']['location']['name']; ?></label>
						<select name="<?php echo $dox_options['ad_set']['location']['base']; ?>[]" id="<?php echo $dox_options['ad_set']['location']['base']; ?>"><?php dox_get_dd_terms( $dox_options['ad_set']['location']['query'], 0,0, sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['location']['name'] ) ); ?></select>
					</div>
					
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>"><?php echo $dox_options['ad_set']['location']['sub']; ?></label>
						<select name="<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>[]" id="<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>" disabled="disabled" ></select>
					</div>
					<?php } ?>

					<?php if ($dox_options['ad_set']['year']['show'] == 'true' && $dox_options['ad_set']['year']['search'] == 'true') { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['year']['base']; ?>"><?php echo $dox_options['ad_set']['year']['name']; ?></label>
						<select name="ad<?php echo $dox_options['ad_set']['year']['base']; ?>[]" id="ad<?php echo $dox_options['ad_set']['year']['base']; ?>"><?php dox_get_dd_terms( $dox_options['ad_set']['year']['query'], 0,0, sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['year']['name'] ) ); ?></select>
					</div>
					<?php } ?>						
					
					<?php if ($dox_options['ad_set']['color']['show'] == 'true' && $dox_options['ad_set']['color']['search'] == 'true') { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['color']['base']; ?>"><?php echo $dox_options['ad_set']['color']['name']; ?></label>
						<select name="<?php echo $dox_options['ad_set']['color']['base']; ?>[]" id="<?php echo $dox_options['ad_set']['color']['base']; ?>"><?php dox_get_dd_terms( $dox_options['ad_set']['color']['query'], 0,0, sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['color']['name'] ) ); ?></select>
					</div>
					<?php } ?>						
					
					<?php if ($dox_options['ad_set']['fuelType']['show'] == 'true' && $dox_options['ad_set']['fuelType']['search'] == 'true') { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['fuelType']['base']; ?>"><?php echo $dox_options['ad_set']['fuelType']['name']; ?></label>
						<select name="<?php echo $dox_options['ad_set']['fuelType']['base']; ?>[]" id="<?php echo $dox_options['ad_set']['fuelType']['base']; ?>"><?php dox_get_dd_terms( $dox_options['ad_set']['fuelType']['query'], 0,0, sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['fuelType']['name'] ) ); ?></select>
					</div>
					<?php } ?>	

					<?php if ($dox_options['ad_set']['bodyType']['show'] == 'true' && $dox_options['ad_set']['bodyType']['search'] == 'true') { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['bodyType']['base']; ?>"><?php echo $dox_options['ad_set']['bodyType']['name']; ?></label>
						<select name="<?php echo $dox_options['ad_set']['bodyType']['base']; ?>[]" id="<?php echo $dox_options['ad_set']['bodyType']['base']; ?>"><?php dox_get_dd_terms( $dox_options['ad_set']['bodyType']['query'], 0,0, sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['bodyType']['name'] ) ); ?></select>
					</div>
					<?php } ?>	

					<?php if ($dox_options['ad_set']['transmission']['show'] == 'true' && $dox_options['ad_set']['transmission']['search'] == 'true') { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['transmission']['base']; ?>"><?php echo $dox_options['ad_set']['transmission']['name']; ?></label>
						<select name="<?php echo $dox_options['ad_set']['transmission']['base']; ?>[]" id="<?php echo $dox_options['ad_set']['transmission']['base']; ?>"><?php dox_get_dd_terms( $dox_options['ad_set']['transmission']['query'], 0,0, sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['transmission']['name'] ) ); ?></select>
					</div>
					<?php } ?>						
					
					<?php if ($dox_options['ad_set']['cylinders']['show'] == 'true' && $dox_options['ad_set']['cylinders']['search'] == 'true') { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['cylinders']['base']; ?>-min"><?php echo $dox_options['ad_set']['cylinders']['name']; ?></label>							
						<input type="text" name="<?php echo $dox_options['ad_set']['cylinders']['base']; ?>-min" id="<?php echo $dox_options['ad_set']['cylinders']['base']; ?>-min" size="9"/>
						<span class="to"><?php _e('to', 'autotrader'); ?></span>
						<input type="text" name="<?php echo $dox_options['ad_set']['cylinders']['base']; ?>-max" id="<?php echo $dox_options['ad_set']['cylinders']['base']; ?>-max" size="9"/>
					</div>
					<?php } ?>

					<?php if ($dox_options['ad_set']['doors']['show'] == 'true' && $dox_options['ad_set']['doors']['search'] == 'true') { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['doors']['base']; ?>-min"><?php echo $dox_options['ad_set']['doors']['name']; ?></label>							
						<input type="text" name="<?php echo $dox_options['ad_set']['doors']['base']; ?>-min" id="<?php echo $dox_options['ad_set']['doors']['base']; ?>-min" size="9"/>
						<span class="to"><?php _e('to', 'autotrader'); ?></span>
						<input type="text" name="<?php echo $dox_options['ad_set']['doors']['base']; ?>-max" id="<?php echo $dox_options['ad_set']['doors']['base']; ?>-max" size="9"/>
					</div>
					<?php } ?>

					<?php if ($dox_options['ad_set']['mileage']['show'] == 'true' && $dox_options['ad_set']['mileage']['search'] == 'true') { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['mileage']['base']; ?>-min"><?php echo $dox_options['ad_set']['mileage']['name']; ?></label>							
						<input type="text" name="<?php echo $dox_options['ad_set']['mileage']['base']; ?>-min" id="<?php echo $dox_options['ad_set']['mileage']['base']; ?>-min" size="9"/>
						<span class="to"><?php _e('to', 'autotrader'); ?></span>
						<input type="text" name="<?php echo $dox_options['ad_set']['mileage']['base']; ?>-max" id="<?php echo $dox_options['ad_set']['mileage']['base']; ?>-max" size="9"/>
					</div>
					<?php } ?>					
					
					<?php if ($dox_options['ad_set']['price']['show'] == 'true' && $dox_options['ad_set']['price']['search'] == 'true') { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['price']['base']; ?>-min"><?php echo $dox_options['ad_set']['price']['name']; ?></label>							
						<input type="text" name="<?php echo $dox_options['ad_set']['price']['base']; ?>-min" id="<?php echo $dox_options['ad_set']['price']['base']; ?>-min" size="9"/>
						<span class="to"><?php _e('to', 'autotrader'); ?></span>
						<input type="text" name="<?php echo $dox_options['ad_set']['price']['base']; ?>-max" id="<?php echo $dox_options['ad_set']['price']['base']; ?>-max" size="9"/>
					</div>
					<?php } ?>

					<div class="form-input clearfix">
						<input type="hidden" name="auto_search" id="auto_search" value="true" />
						<input type="submit" id="homeSearchButton" name="homeSearchButton" value="<?php _e('Search','autotrader'); ?>" />
						<a href="<?php echo dox_get_search_autos_page(); ?>" class="advancedSearch"><?php _e('Advanced Search','autotrader'); ?></a>
					</div>
					
				</form>
			</div>
		</div><!-- end - #search -->
		
		<div class="clear"></div>
	</div> 
</div>
<div class="clear"></div>


<!-- #latest-cars -->
<div id="latestCars" class="container">
	<div class="container_12 clearfix">
		<div class="grid_12"><h4 class="section-title section-line"><?php _e('Latest Cars', 'autotrader') ?></h4></div>
		
		<div id="latestCars_tj_container" class="grid_12 tj_container">
			
			<div class="tj_nav">
				<span id="tj_prev2" class="tj_prev">Previous</span>
				<span id="tj_next2" class="tj_next">Next</span>
			</div>
			
			<div class="tj_wrapper">
				<ul class="tj_gallery">
				<?php	
					$latestAutos = new WP_Query(); $latestAutos->query('post_type='.$dox_options['ad_set']['type']['base'].'&posts_per_page='.$dox_options['home']['latest_ad_nr']);
					
					$counter = 0;
					while ($latestAutos->have_posts()) : $latestAutos->the_post();
					$counter++; 
					if ($counter == 1) $className = 'alpha'; 
						elseif ($counter == 4) { $className = 'omega'; $counter = 0; }
						else $className = ''; ?>
						
					<li class="grid_3 clearfix <?php echo $className; ?>">
						<a href="<?php the_permalink(); ?>" class="image-zoom home-thumb-zoom">
							<?php echo dox_get_post_image($post->ID, 'default-thumb', 'main' ); ?>
							<span class="zoom-icon"></span>
						</a>
						<h6 class="marginT5"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
						<div class="clear"></div>
					</li>
					
				<?php endwhile; ?>
				</ul>
				<div class="clear"></div>
			</div>
		</div>	
		<div class="clear"></div>
	</div>	
</div>
<div class="clear"></div>

<script type="text/javascript">
	var $j = jQuery.noConflict();
	
	$j(function() {
		$j('#latestCars_tj_container').gridnav({
			rows	: 1,
			navL	: '#tj_prev2',
			navR	: '#tj_next2',
			type	: {
				mode		: 'seqfade', 	// use def | fade | seqfade | updown | sequpdown | showhide | disperse | rows
				speed		: 400,			// for fade, seqfade, updown, sequpdown, showhide, disperse, rows
				easing		: '',			// for fade, seqfade, updown, sequpdown, showhide, disperse, rows	
				factor		: 100,			// for seqfade, sequpdown, rows
				reverse		: ''			// for sequpdown
			}
		});
	});	
</script>
<!-- end - #latest-cars -->

<!-- #car-dealers -->
<div id="carDealers" class="container">
	<div class="container_12 clearfix">
		<div class="grid_12"><h4 class="section-title section-line"><?php _e('Car Dealers', 'autotrader') ?></h4></div>
		<?php
				$dealers = get_users( 'number=6&meta_key=dox_dealer_data&orderby=registered' );
				$dealer_data = array();
				foreach ($dealers as $dealer) { 					
					$dealer_data =  get_user_meta($dealer->ID, 'dox_dealer_data', true);
					$author_url = get_author_posts_url( $dealer->ID );
		?>
					<div class="grid_2 clearfix">
						<a href="<?php echo $author_url;?>" class="image-zoom small-thumb-zoom">
							<img src="<?php echo $dealer_data['logo_url']; ?>" class="dealer-logo" height="80" width="140" alt="<?php echo 'Logo: '.$dealer->display_name; ?>"/>
							<span class="zoom-icon"></span>
						</a>
						<h6 class="marginT5"><a href="<?php echo $author_url;?>"><?php echo $dealer->display_name; ?></a></h6>
						<div class="clear"></div>
					</div>				
		<?php } ?>
		<div class="clear"></div>
	</div>	
</div>
<div class="clear"></div>
<!-- end - #car-dealers -->

<?php get_footer(); ?>


<script type="text/javascript">
	var $j = jQuery.noConflict();
	
	$j(document).ready(function(){
		
		<?php if ($dox_options['ad_set']['model']['show'] == 'true') { ?>	
		function fill_dd_model() {
			$j("#homeSearch #<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>").empty();
			
			var $make_id = $j("#homeSearch #<?php echo $dox_options['ad_set']['model']['base']; ?>").val();

			
			$j.ajax({
				type    : 'POST',
				url     : '<?php echo admin_url('admin-ajax.php'); ?>',
				data    : { action : 'dox_get_model', make_id: $make_id, sel_text: true },
				success : function(response) {
					$j("#homeSearch #<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>").removeAttr("disabled");
					$j("#homeSearch #<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>").append(response);					
				}						
			});				
		
		}
		
		/* if make changed */
		$j("#homeSearch #<?php echo $dox_options['ad_set']['model']['base']; ?>").change(function () {
			fill_dd_model();			
		});	
		<?php } ?>	
		
		<?php if ($dox_options['ad_set']['location']['show'] == 'true') { ?>
		function fill_dd_cities() {
			$j("#homeSearch #<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>").empty();
			
			var $location_id = $j("#homeSearch #<?php echo $dox_options['ad_set']['location']['base']; ?>").val();
			
			$j.ajax({
				type    : 'POST',
				url     : '<?php echo admin_url('admin-ajax.php'); ?>',
				data    : { action : 'dox_get_city', location_id: $location_id, sel_text: true },
				success : function(response) {
					$j("#homeSearch #<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>").removeAttr("disabled");
					$j("#homeSearch #<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>").append(response);					
				}						
			});				
		
		}		
		
		/* if location changed */
		$j("#homeSearch #<?php echo $dox_options['ad_set']['location']['base']; ?>").change(function () {
			fill_dd_cities();			
		});	
		<?php } ?>			
			
	})	
</script>
<?php 
/*
Template Name: Search Ads
*/
?>
<?php get_header(); ?>
		
<!-- #search -->
<div id="search" class="dox-template container">
	<div class="container_12 clearfix">
		<div class="grid_12"><h3 class="page-title"><?php the_title(); ?></h3></div>

		<!-- #content -->
		<div id="content" class="grid_8">			
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<!-- .post -->
			<div <?php post_class('clearfix') ?> id="post-<?php the_ID(); ?>">
					
				<!-- .entry-content -->
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- end - .entry-content -->

				<h4 class="section-title section-line"><?php _e('Find Your Car', 'autotrader') ?></h4>
									
				<!-- .step-form -->
				<div class="step-form">
				
					<!-- .step-alert -->
					<div class="step-alert alert alert-error" style="display:none">
						<p></p>
					</div><!-- end .step-alert -->
					
					<!-- .step-form-wrap -->
					<div class="step-form-wrap">
					
						<!-- #search-form -->
						<div id="search-form">
							<form id="searchForm" action="<?php echo dox_get_search_autos_results_page(); ?>" method="post" enctype="multipart/form-data">
																	
								<?php if ($dox_options['ad_set']['model']['show'] == 'true') { ?>
									<div class="form-input form-input-33 clearfix">
										<label for="<?php echo $dox_options['ad_set']['model']['base']; ?>"><?php echo $dox_options['ad_set']['model']['name']; ?></label>
										<select name="<?php echo $dox_options['ad_set']['model']['base']; ?>[]" id="<?php echo $dox_options['ad_set']['model']['base']; ?>" multiple="multiple"><?php dox_get_dd_terms( $dox_options['ad_set']['model']['query'], 0,0, null ); ?></select>
									</div>
									
									
									<div class="form-input form-input-33 clearfix">
										<label for="<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>"><?php echo $dox_options['ad_set']['model']['sub']; ?></label>							
										<select name="<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>[]" id="<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>" multiple="multiple" disabled="disabled"></select>
									</div>
								<?php } ?>
								
								<?php if ($dox_options['ad_set']['condition']['show'] == 'true') { ?>
									<div class="form-input form-input-33 clearfix">
										<label for="<?php echo $dox_options['ad_set']['condition']['base']; ?>"><?php echo $dox_options['ad_set']['condition']['name']; ?></label>							
										<select name="<?php echo $dox_options['ad_set']['condition']['base']; ?>[]" id="<?php echo $dox_options['ad_set']['condition']['base']; ?>" multiple="multiple"><?php dox_get_dd_terms( $dox_options['ad_set']['condition']['query'], 0,0, null ); ?></select>
									</div>
								<?php } ?>
								
								<?php if ($dox_options['ad_set']['location']['show'] == 'true') { ?>
									<div class="form-input form-input-33 clearfix">
										<label for="<?php echo $dox_options['ad_set']['location']['base']; ?>"><?php echo $dox_options['ad_set']['location']['name']; ?></label>							
										<select name="<?php echo $dox_options['ad_set']['location']['base']; ?>[]" id="<?php echo $dox_options['ad_set']['location']['base']; ?>" multiple="multiple"><?php dox_get_dd_terms( $dox_options['ad_set']['location']['query'], 0,0, null ); ?></select>									
									</div>
								
									<div class="form-input form-input-33 clearfix">
										<label for="<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>"><?php echo $dox_options['ad_set']['location']['sub']; ?></label>							
										<select name="<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>[]" id="<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>" multiple="multiple" disabled="disabled"></select>
									</div>
								<?php } ?>								

								<?php if ($dox_options['ad_set']['year']['show'] == 'true') { ?>
									<div class="form-input form-input-33 clearfix">
										<label for="ad<?php echo $dox_options['ad_set']['year']['base']; ?>"><?php echo $dox_options['ad_set']['year']['name']; ?></label>							
										<select name="ad<?php echo $dox_options['ad_set']['year']['base']; ?>[]" id="ad<?php echo $dox_options['ad_set']['year']['base']; ?>" multiple="multiple"><?php dox_get_dd_terms( $dox_options['ad_set']['year']['query'], 0,0, null, 'DESC' ); ?></select>	
									</div>
								<?php } ?>	
								
								<?php if ($dox_options['ad_set']['transmission']['show'] == 'true') { ?>
									<div class="form-input form-input-33 clearfix">
										<label for="<?php echo $dox_options['ad_set']['transmission']['base']; ?>"><?php echo $dox_options['ad_set']['transmission']['name']; ?></label>							
										<select name="<?php echo $dox_options['ad_set']['transmission']['base']; ?>[]" id="<?php echo $dox_options['ad_set']['transmission']['base']; ?>" multiple="multiple"><?php dox_get_dd_terms( $dox_options['ad_set']['transmission']['query'], 0,0, null ); ?></select>	
									</div>
								<?php } ?>								

								<?php if ($dox_options['ad_set']['color']['show'] == 'true') { ?>
									<div class="form-input form-input-33 clearfix">
										<label for="<?php echo $dox_options['ad_set']['color']['base']; ?>"><?php echo $dox_options['ad_set']['color']['name']; ?></label>							
										<select name="<?php echo $dox_options['ad_set']['color']['base']; ?>[]" id="<?php echo $dox_options['ad_set']['color']['base']; ?>" multiple="multiple"><?php dox_get_dd_terms( $dox_options['ad_set']['color']['query'], 0,0, null ); ?></select>	
									</div>
								<?php } ?>

								<?php if ($dox_options['ad_set']['fuelType']['show'] == 'true') { ?>
									<div class="form-input form-input-33 clearfix">
										<label for="<?php echo $dox_options['ad_set']['fuelType']['base']; ?>"><?php echo $dox_options['ad_set']['fuelType']['name']; ?></label>							
										<select name="<?php echo $dox_options['ad_set']['fuelType']['base']; ?>[]" id="<?php echo $dox_options['ad_set']['fuelType']['base']; ?>" multiple="multiple"><?php dox_get_dd_terms( $dox_options['ad_set']['fuelType']['query'], 0,0, null ); ?></select>	
									</div>
								<?php } ?>								

								<?php if ($dox_options['ad_set']['bodyType']['show'] == 'true') { ?>
									<div class="form-input form-input-50 clearfix">
										<label for="<?php echo $dox_options['ad_set']['bodyType']['base']; ?>"><?php echo $dox_options['ad_set']['bodyType']['name']; ?></label>							
										<select name="<?php echo $dox_options['ad_set']['bodyType']['base']; ?>[]" id="<?php echo $dox_options['ad_set']['bodyType']['base']; ?>" multiple="multiple"><?php dox_get_dd_terms( $dox_options['ad_set']['bodyType']['query'], 0,0, null ); ?></select>
									</div>
								<?php } ?>
								
								<div style="float:left;width:100%">
								<?php if ($dox_options['ad_set']['cylinders']['show'] == 'true') { ?>
									<div class="form-input form-input-50 clearfix">
										<label for="<?php echo $dox_options['ad_set']['cylinders']['base']; ?>"><?php echo $dox_options['ad_set']['cylinders']['name']; ?></label>
										<input type="text" name="<?php echo $dox_options['ad_set']['cylinders']['base']; ?>-min" id="<?php echo $dox_options['ad_set']['cylinders']['base']; ?>-min" size="9" maxlength="5"/>
										<span class="to"><?php _e('to', 'autotrader'); ?></span>
										<input type="text" name="<?php echo $dox_options['ad_set']['cylinders']['base']; ?>-max" id="<?php echo $dox_options['ad_set']['cylinders']['base']; ?>-max" size="9" maxlength="5"/>								
									</div>
								<?php } ?>

								<?php if ($dox_options['ad_set']['doors']['show'] == 'true') { ?>
									<div class="form-input form-input-50 clearfix">
										<label for="<?php echo $dox_options['ad_set']['doors']['base']; ?>"><?php echo $dox_options['ad_set']['doors']['name']; ?></label>							
										<input type="text" name="<?php echo $dox_options['ad_set']['doors']['base']; ?>-min" id="<?php echo $dox_options['ad_set']['doors']['base']; ?>-min" size="9" maxlength="1"/>
										<span class="to"><?php _e('to', 'autotrader'); ?></span>
										<input type="text" name="<?php echo $dox_options['ad_set']['doors']['base']; ?>-max" id="<?php echo $dox_options['ad_set']['doors']['base']; ?>-max" size="9" maxlength="1"/>								
									</div>
								<?php } ?>
								
								<?php if ($dox_options['ad_set']['mileage']['show'] == 'true') { ?>
									<div class="form-input form-input-50 clearfix">
										<label for="<?php echo $dox_options['ad_set']['mileage']['base']; ?>"><?php echo $dox_options['ad_set']['mileage']['name']; ?></label>							
										<input type="text" name="<?php echo $dox_options['ad_set']['mileage']['base']; ?>-min" id="<?php echo $dox_options['ad_set']['mileage']['base']; ?>-min" size="9" maxlength="6"/>
										<span class="to"><?php _e('to', 'autotrader'); ?></span>
										<input type="text" name="<?php echo $dox_options['ad_set']['mileage']['base']; ?>-max" id="<?php echo $dox_options['ad_set']['mileage']['base']; ?>-max" size="9" maxlength="6"/>
									</div>
								<?php } ?>
								
								
								<?php if ($dox_options['ad_set']['price']['show'] == 'true') { ?>
									<div class="form-input form-input-50 clearfix">
										<label for="<?php echo $dox_options['ad_set']['price']['base']; ?>"><?php echo $dox_options['ad_set']['price']['name']; ?></label>							
										<input type="text" name="<?php echo $dox_options['ad_set']['price']['base']; ?>-min" id="<?php echo $dox_options['ad_set']['price']['base']; ?>-min" size="9"/>
										<span class="to"><?php _e('to', 'autotrader'); ?></span>
										<input type="text" name="<?php echo $dox_options['ad_set']['price']['base']; ?>-max" id="<?php echo $dox_options['ad_set']['price']['base']; ?>-max" size="9"/>
									</div>
								<?php } ?>
								</div>
								
								
								<div class="form-input clearfix">
									<label for="keyword"><?php echo _e('Keyword','autotrader'); ?></label>
									<input type="text" name="keyword" id="keyword" size="60" maxlength="50"/>
									<div class="clear"></div>
								</div>
								
								<div style="float:left;width:100%">
									<div class="form-input clearfix">
										<input type="hidden" name="auto_search" id="auto_search" value="true" />
										<input type="submit"  name="searchButton" id="searchButton" class="button" value="<?php _e('Search','autotrader'); ?>" />
									</div>
								</div>									
								
							</form>
						</div><!-- end - #search-form -->
						
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
<!-- end - #search -->
		
<?php get_footer(); ?>

<script type="text/javascript">

	var $j = jQuery.noConflict();
	
	$j(document).ready(function(){
		
		<?php if ($dox_options['ad_set']['model']['show'] == 'true') { ?>
		function fill_dd_model() {
			$j("#search-form #<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>").empty();
			
			var $make = ''; 
			
			$j("#<?php echo $dox_options['ad_set']['model']['base']; ?> :selected").each(function(i, selected){ 
				if (i == 0) $make = $j(selected).val();
				else $make = $make+','+$j(selected).val(); 
			});
			
			$j.ajax({
				type    : 'POST',
				url     : '<?php echo admin_url('admin-ajax.php'); ?>',
				data    : { action : 'dox_get_model', make_id: $make },
				success : function(response) {
					$j("#<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>").removeAttr("disabled");
					$j("#<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>").append(response);					
				}						
			});				
		
		}
				
		/* if make changed */
		$j("#search-form #<?php echo $dox_options['ad_set']['model']['base']; ?>").change(function () {
			fill_dd_model();			
		});	
		<?php } ?>	
		
		<?php if ($dox_options['ad_set']['location']['show'] == 'true') { ?>
		function fill_dd_cities() {
			$j("#search-form #<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>").empty();
			
			var $location = ''; 
			
			$j("#<?php echo $dox_options['ad_set']['location']['base']; ?> :selected").each(function(i, selected){ 
				if (i == 0) $location = $j(selected).val();
				else $location = $location+','+$j(selected).val(); 
			});
			
			$j.ajax({
				type    : 'POST',
				url     : '<?php echo admin_url('admin-ajax.php'); ?>',
				data    : { action : 'dox_get_city', location_id: $location },
				success : function(response) {
					$j("#<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>").removeAttr("disabled");
					$j("#<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>").append(response);					
				}						
			});				
		
		}		
		
		/* if location changed */
		$j("#search-form #<?php echo $dox_options['ad_set']['location']['base']; ?>").change(function () {
			fill_dd_cities();			
		});
		<?php } ?>	
		
	})						  
</script>
<?php get_header(); ?>
		
<!-- #taxonomy -->
<div id="taxonomy" class="container">
	<div class="container_12 clearfix">
		<div class="grid_12"><h3 class="page-title"><?php dox_get_title(get_query_var( 'term' ), get_query_var( 'taxonomy' )); ?></h3></div>

		<!-- .taxonomy-alert -->
		<div class="taxonomy-alert alert" style="display:none">
			<p></p>
		</div><!-- end .taxonomy-alert -->
				
		<!-- #content -->
		<div id="content" class="grid_8 listing">			
			<?php	if (have_posts()): while (have_posts()) : the_post();
			
					/* get auto features */
					$postterms = dox_get_post_term(get_the_ID());
					
					/* get permalink */
					$permalink = get_permalink(get_the_ID()); ?>
					
			<!-- .post -->
			<div <?php post_class('custom-post-type clearfix') ?> id="post-<?php the_ID(); ?>">
								
				<div class="grid_3 clearfix alpha">
					<a href="<?php echo $permalink; ?>" class="image-zoom main-thumb-zoom" target="_blank">
						<?php echo dox_get_post_image($post->ID, 'default-thumb', 'main' ); ?>
						<span class="zoom-icon"></span>
					</a>
				</div>
				<div class="grid_5 clearfix omega">
					<h3><a href="<?php echo $permalink; ?>"><?php the_title(); ?></a></h3>
					<div class="grid_3 clearfix alpha">
						<ul class="features">
						<?php 
								if ( $dox_options['ad_set']['model']['show'] == 'true' && $dox_options['ad_set']['model']['list'] == 'true' ) {
									$make = get_term_by( 'id', $postterms[$dox_options['ad_set']['model']['query']][0][0], $dox_options['ad_set']['model']['query'] );
									$model = get_term_by( 'id', $postterms[$dox_options['ad_set']['model']['query']][$postterms[$dox_options['ad_set']['model']['query']][0][0]][0], $dox_options['ad_set']['model']['query'] );
								}
								
								if ( $dox_options['ad_set']['location']['show'] == 'true' && $dox_options['ad_set']['location']['list'] == 'true' ) {
									$location = get_term_by( 'id', $postterms[$dox_options['ad_set']['location']['query']][0][0], $dox_options['ad_set']['location']['query'] );
									$city = get_term_by( 'id', $postterms[$dox_options['ad_set']['location']['query']][$postterms[$dox_options['ad_set']['location']['query']][0][0]][0], $dox_options['ad_set']['location']['query'] );
								}
								
								if ( $dox_options['ad_set']['mileage']['show'] == 'true' && $dox_options['ad_set']['mileage']['list'] == 'true' ) { $mileage = get_post_meta($post->ID, $dox_options['ad_set']['mileage']['query'], true); }
								if ( $dox_options['ad_set']['price']['show'] == 'true' && $dox_options['ad_set']['price']['list'] == 'true' ) { $price = get_post_meta($post->ID, $dox_options['ad_set']['price']['query'], true); }
								if ( $dox_options['ad_set']['year']['show'] == 'true' && $dox_options['ad_set']['year']['list'] == 'true' ) { $autoyear = get_term_by( 'id', $postterms[$dox_options['ad_set']['year']['query']][0][0], $dox_options['ad_set']['year']['query'] ); }
								if ( $dox_options['ad_set']['condition']['show'] == 'true' && $dox_options['ad_set']['condition']['list'] == 'true' ) { $condition = get_term_by( 'id', $postterms[$dox_options['ad_set']['condition']['query']][0][0], $dox_options['ad_set']['condition']['query'] ); }
								if ( $dox_options['ad_set']['color']['show'] == 'true' && $dox_options['ad_set']['color']['list'] == 'true' ) { $color = get_term_by( 'id', $postterms[$dox_options['ad_set']['color']['query']][0][0], $dox_options['ad_set']['color']['query'] ); }
								if ( $dox_options['ad_set']['fuelType']['show'] == 'true' && $dox_options['ad_set']['fuelType']['list'] == 'true' ) { $fuelType = get_term_by( 'id', $postterms[$dox_options['ad_set']['fuelType']['query']][0][0], $dox_options['ad_set']['fuelType']['query'] ); }
								if ( $dox_options['ad_set']['bodyType']['show'] == 'true' && $dox_options['ad_set']['bodyType']['list'] == 'true' ) { $bodyType = get_term_by( 'id', $postterms[$dox_options['ad_set']['bodyType']['query']][0][0], $dox_options['ad_set']['bodyType']['query'] ); }
								if ( $dox_options['ad_set']['doors']['show'] == 'true' && $dox_options['ad_set']['doors']['list'] == 'true' ) { $doors = get_post_meta($post->ID, $dox_options['ad_set']['doors']['query'], true); }
								if ( $dox_options['ad_set']['cylinders']['show'] == 'true' && $dox_options['ad_set']['cylinders']['list'] == 'true' ) { $cylinders = get_post_meta($post->ID, $dox_options['ad_set']['cylinders']['query'], true); }
								if ( $dox_options['ad_set']['transmission']['show'] == 'true' && $dox_options['ad_set']['transmission']['list'] == 'true' ) { $transmission = get_term_by( 'id', $postterms[$dox_options['ad_set']['transmission']['query']][0][0], $dox_options['ad_set']['transmission']['query'] ); }
																										
								$output = '';						
											if ( $dox_options['ad_set']['model']['show'] == 'true' && $dox_options['ad_set']['model']['list'] == 'true' ) { $output .= '<li><span>'.$dox_options['ad_set']['model']['name'].'</span> : '.$make->name.' / '.$model->name.'</li>'; }
											if ( $dox_options['ad_set']['location']['show'] == 'true' && $dox_options['ad_set']['location']['list'] == 'true' ) { $output .= '<li><span>'.$dox_options['ad_set']['location']['name'].'</span> : '.$location->name.' / '.$city->name.'</li>'; }							
											if ( $dox_options['ad_set']['mileage']['show'] == 'true' && $dox_options['ad_set']['mileage']['list'] == 'true' ) { $output .= '<li><span>'.$dox_options['ad_set']['mileage']['name'].'</span> : '.$mileage.'</li>'; }
											if ( $dox_options['ad_set']['year']['show'] == 'true' && $dox_options['ad_set']['year']['list'] == 'true' ) { $output .= '<li><span>'.$dox_options['ad_set']['year']['name'].'</span> : '.$autoyear->name.'</li>'; }
											if ( $dox_options['ad_set']['condition']['show'] == 'true' && $dox_options['ad_set']['condition']['list'] == 'true' ) { $output .= '<li><span>'.$dox_options['ad_set']['condition']['name'].'</span> : '.$condition->name.'</li>'; }
											if ( $dox_options['ad_set']['color']['show'] == 'true' && $dox_options['ad_set']['color']['list'] == 'true' ) { $output .= '<li><span>'.$dox_options['ad_set']['color']['name'].'</span> : '.$color->name.'</li>'; }
											if ( $dox_options['ad_set']['fuelType']['show'] == 'true' && $dox_options['ad_set']['fuelType']['list'] == 'true' ) { $output .= '<li><span>'.$dox_options['ad_set']['fuelType']['name'].'</span> : '.$fuelType->name.'</li>'; }
											if ( $dox_options['ad_set']['bodyType']['show'] == 'true' && $dox_options['ad_set']['bodyType']['list'] == 'true' ) { $output .= '<li><span>'.$dox_options['ad_set']['bodyType']['name'].'</span> : '.$bodyType->name.'</li>'; }
											if ( $dox_options['ad_set']['doors']['show'] == 'true' && $dox_options['ad_set']['doors']['list'] == 'true' ) { $output .= '<li><span>'.$dox_options['ad_set']['doors']['name'].'</span> : '.$doors->name.'</li>'; }
											if ( $dox_options['ad_set']['cylinders']['show'] == 'true' && $dox_options['ad_set']['cylinders']['list'] == 'true' ) { $output .= '<li><span>'.$dox_options['ad_set']['cylinders']['name'].'</span> : '.$cylinders->name.'</li>'; }
											if ( $dox_options['ad_set']['transmission']['show'] == 'true' && $dox_options['ad_set']['transmission']['list'] == 'true' ) { $output .= '<li><span>'.$dox_options['ad_set']['transmission']['name'].'</span> : '.$transmission->name.'</li>'; }

								echo $output;							
						?>
						</ul>
					</div>
					<div class="grid_2 clearfix omega">
						<ul class="price">
							<?php 	$price = get_post_meta($post->ID, $dox_options['ad_set']['price']['query'], true);
									echo '<li><span>'.$dox_options['ad_set']['price']['name'].'</span>'.$price.' '.$dox_options['ad']['currency'].'</li>'; ?>
						</ul>					
						<a href="?watchlist=<?php echo the_ID(); ?>" class="watchlist-button button"><?php _e('Add to Watchlist','autotrader'); ?></a>
						<a href="<?php echo $permalink; ?>" class="button" target="_blank"><?php _e('View Details','autotrader'); ?></a>
					</div>
				</div>
				
			</div><!-- end - .post -->
							
			<?php endwhile;
			
				else: ?>
					<!-- .entry-content -->
					<div class="entry-content">
						<?php _e('No ad could be found matching your search criteria.','autotrader'); ?>
					</div><!-- end - .entry-content -->
			<?php endif; ?>

			<!-- .listing-paging -->
			<?php	$page_nr= intval(get_query_var('paged'));
					$max_page = $wp_query->max_num_pages; ?>
					
			<div class="listing-paging">					
				<?php echo dox_pager( $page_nr, $max_page, false ); ?>							
			</div><!-- end - .listing-paging -->	
						
		</div><!-- end - #content -->
		
		<!-- #sidebar -->
		<div id="sidebar" class="grid_4">
			<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Right Sidebar') ) ?>		
		</div><!-- end - #sidebar -->		
		
		<div class="clear"></div>
	</div>	
</div>
<div class="clear"></div>
<!-- end - #taxonomy -->
		
<?php get_footer(); ?>
<script type="text/javascript">

	var $j = jQuery.noConflict();
	
	$j(document).ready(function(){			
		
		// add to watchlist
		$j('.listing .custom-post-type .watchlist-button').click(function() {
			
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
					
					$j(".taxonomy-alert").removeClass('alert-success alert-error alert-warning');
					$j(".taxonomy-alert").addClass(response.alert);
					
					$j(".taxonomy-alert p").empty();
					$j(".taxonomy-alert p").append(response.message);

					$j('.taxonomy-alert').css('display','block');
					$j('.taxonomy-alert').delay(4000).slideUp(350); 

				}
			});				

			
			return false;
		});			
		
	})						  
</script>
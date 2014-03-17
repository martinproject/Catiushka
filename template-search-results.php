<?php 
/*
Template Name: Search Results
*/
?>
<?php get_header(); ?>
		
<!-- #searchResults -->
<div id="searchResults" class="dox-template container">
	<div class="container_12 clearfix">
		<div class="grid_12"><h3 class="page-title"><?php the_title(); ?></h3></div>

		<!-- .search-results-alert -->
		<div class="search-results-alert alert" style="display:none">
			<p></p>
		</div><!-- end .search-results-alert -->
		
		<?php	// get search parameters
				$paged = intval(get_query_var('paged'));
				if ($paged < 1) $paged = 1;
				
			
				$args .= 'cylinders_min='.$_POST[$dox_options['ad_set']['cylinders']['base'].'-min'];
				$args .= '&cylinders_max='.$_POST[$dox_options['ad_set']['cylinders']['base'].'-max'];
				$args .= '&doors_min='.$_POST[$dox_options['ad_set']['doors']['base'].'-min'];
				$args .= '&doors_max='.$_POST[$dox_options['ad_set']['doors']['base'].'-max'];				
				$args .= '&mileage_min='.$_POST[$dox_options['ad_set']['mileage']['base'].'-min'];
				$args .= '&mileage_max='.$_POST[$dox_options['ad_set']['mileage']['base'].'-max'];
				$args .= '&price_min='.$_POST[$dox_options['ad_set']['price']['base'].'-min'];
				$args .= '&price_max='.$_POST[$dox_options['ad_set']['price']['base'].'-max'];
				$args .= '&keyword='.$_POST['keyword'];
				
				if (!empty ($_POST[$dox_options['ad_set']['model']['base']])) $make = implode(',',$_POST[$dox_options['ad_set']['model']['base']]);
				if (!empty ($_POST[$dox_options['ad_set']['model']['base'].'sub'])) $model = implode(',',$_POST[$dox_options['ad_set']['model']['base'].'sub']);
				if (!empty ($_POST[$dox_options['ad_set']['condition']['base']])) $condition = implode(',',$_POST[$dox_options['ad_set']['condition']['base']]);
				if (!empty ($_POST[$dox_options['ad_set']['location']['base']])) $location = implode(',',$_POST[$dox_options['ad_set']['location']['base']]);
				if (!empty ($_POST[$dox_options['ad_set']['location']['base'].'sub'])) $city = implode(',',$_POST[$dox_options['ad_set']['location']['base'].'sub']);
				if (!empty ($_POST['ad'.$dox_options['ad_set']['year']['base']])) $autoyear = implode(',',$_POST['ad'.$dox_options['ad_set']['year']['base']]);
				if (!empty ($_POST[$dox_options['ad_set']['transmission']['base']])) $transmission = implode(',',$_POST[$dox_options['ad_set']['transmission']['base']]);
				if (!empty ($_POST[$dox_options['ad_set']['color']['base']])) $colour = implode(',',$_POST[$dox_options['ad_set']['color']['base']]);
				if (!empty ($_POST[$dox_options['ad_set']['fuelType']['base']])) $fuel_type = implode(',',$_POST[$dox_options['ad_set']['fuelType']['base']]);
				if (!empty ($_POST[$dox_options['ad_set']['bodyType']['base']])) $body_type = implode(',',$_POST[$dox_options['ad_set']['bodyType']['base']]);
				
		?>
					
		<!-- #content -->
		<div id="content" class="grid_8 listing">

			<!-- .entry-content -->
			<div class="entry-content" style="display:none">
				<?php _e('No ad could be found matching your search criteria.','autotrader'); ?>
			</div><!-- end - .entry-content -->
					
			<!-- .search-sort -->
			<div class="search-sort items-sort clearfix" style="display:none">
				<div class="sort-container">
					<span><?php _e('Sort by','autotrader'); ?></span>
					<select id="sort-results" name="sort-results">
						<option value="newest"><?php _e('Date (Newest > Oldest)','autotrader'); ?></option>
						<option value="oldest"><?php _e('Date (Oldest > Newest)','autotrader'); ?></option>
						<option value="lowest"><?php _e('Price (Low > High)','autotrader'); ?></option>
						<option value="highest"><?php _e('Price (High > Low)','autotrader'); ?></option>
					</select>
				</div>
			</div><!-- end - .search-sort -->
		
			<!-- .search-results -->
			<div class="search-results">
				<!-- Ajax container -->
			</div><!-- end - .search-results -->
			
			
			<!-- .search-paging -->
			<div class="search-paging">
				<!-- Ajax container -->
			</div><!-- end - .search-paging -->			
			
		</div><!-- end - #content -->
		
		<!-- #sidebar -->
		<div id="sidebar" class="grid_4">
			<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Right Sidebar') ) ?>		
		</div><!-- end - #sidebar -->		
		
		<div class="clear"></div>
	</div>	
</div>
<div class="clear"></div>
<!-- end - #searchResults -->
		
<?php get_footer(); ?>
<script type="text/javascript">

	var $j = jQuery.noConflict();
	
	$j(document).ready(function(){			
		
		initialization();
		
		function initialization() {
			
			// initialize the sort option
			$j("#sort-results option[value='newest']").attr('selected', 'selected');
			
			var $paged = '<?php echo $paged; ?>';
			
			$j('.listing').data('paged', $paged);
			$j('.listing').data('order_by', 'date');
			$j('.listing').data('order', 'DESC');
			
			show_search_results();
		}
		
		// show search results
		function show_search_results() {
			
			$paged = $j('.listing').data('paged'); 
			$order_by = $j('.listing').data('order_by');  
			$order = $j('.listing').data('order'); 
					
						
			$j.ajax({
				type    : 'POST',
				url     : '<?php echo admin_url('admin-ajax.php'); ?>',
				dataType: 'json',
				cache	: false,
				data    : { action 	 		: 'dox_show_search_results', 
							args	 		: '<?php echo $args; ?>',
							condition 		: '<?php echo $condition; ?>',
							make 			: '<?php echo $make; ?>',
							model 			: '<?php echo $model; ?>',
							location		: '<?php echo $location; ?>',
							city			: '<?php echo $city; ?>',
							autoyear 		: '<?php echo $autoyear; ?>',
							transmission 	: '<?php echo $transmission; ?>',
							colour 			: '<?php echo $colour; ?>',
							fuel_type 		: '<?php echo $fuel_type; ?>',
							body_type 		: '<?php echo $body_type; ?>',
							paged    		: $paged,
							order    		: $order,
							orderby  		: $order_by
						  },
				success : function(response) {
					$j(".listing .search-results").empty();
					$j(".listing .search-paging").empty();					
					
					if (response.alert) {
						
						$j(".search-results-alert").removeClass('alert-success alert-error alert-warning');
						$j(".search-results-alert").addClass(response.alert);
						
						$j(".search-results-alert p").empty();
						$j(".search-results-alert p").append(response.message);
						
						$j('.entry-content').css('display','block');
						
						$j('.search-results-alert').css('display','block');
						$j('.search-results-alert').delay(4000).slideUp(350); 	
					} else {
						$j('.search-sort').show();
						$j(".listing .search-results").append(response.results);
						$j(".listing .search-paging").append(response.pager);							
					}

				}
			});			
		}
		
		// add to watchlist
		$j('.listing .search-results .custom-post-type .watchlist-button').live("click", function() {
			
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
					
					$j(".search-results-alert").removeClass('alert-success alert-error alert-warning');
					$j(".search-results-alert").addClass(response.alert);
					
					$j(".search-results-alert p").empty();
					$j(".search-results-alert p").append(response.message);

					$j('.search-results-alert').css('display','block');
					$j('.search-results-alert').delay(4000).slideUp(350); 

				}
			});				

			
			return false;
		});	

		// if page clicked
		$j("a.pager").live("click", function(){			
			
			var $paged = $j(this).text();
			
			$j('.listing').removeData('paged');
			$j('.listing').data('paged', $paged);

			show_search_results();

			return false;
		});

		// sorting results
		$j("#sort-results").change(function () {
		
			$j('.listing').removeData('sort');
			$j('.listing').data('sort', $j("#sort-results").val());
			
			if ($j('.listing').data('sort') == 'newest') {
			
				$j('.listing').removeData('order_by');
				$order_by = $j('.listing').data('order_by', 'date');
				
				$j('.listing').removeData('order');
				$order = $j('.listing').data('order', 'DESC');
				
			} else if ($j('.listing').data('sort') == 'oldest') {

				$j('.listing').removeData('order_by');
				$order_by = $j('.listing').data('order_by', 'date');
				
				$j('.listing').removeData('order');
				$order = $j('.listing').data('order', 'ASC');
							
			} else if ($j('.listing').data('sort') == 'lowest') { 

				$j('.listing').removeData('order_by');
				$order_by = $j('.listing').data('order_by', 'price');
				
				$j('.listing').removeData('order');
				$order = $j('.listing').data('order', 'ASC');
							
			} else if ($j('.listing').data('sort') == 'highest') {

				$j('.listing').removeData('order_by');
				$order_by = $j('.listing').data('order_by', 'price');
				
				$j('.listing').removeData('order');
				$order = $j('.listing').data('order', 'DESC');
							
			}
			
			show_search_results()
		});
		
	})						  
</script>
<?php 
/*
Template Name: Watchlist
*/
?>
<?php get_header(); global $current_user; ?>
		
<!-- #watchlist -->
<div id="watchlist" class="dox-template container">
	<div class="container_12 clearfix">
		<div class="grid_12"><h3 class="page-title"><?php the_title(); ?></h3></div>

		<!-- .watchlist-alert -->
		<div class="watchlist-alert alert" style="display:none">
			<p></p>
		</div><!-- end .watchlist-alert -->
		
		<!-- if-not-user-logged-in -->
		<?php	if (! is_user_logged_in() ) {
					get_template_part( 'login-popup' ); 
				}
		?><!-- end - if-not-user-logged-in -->
			
		<!-- #content -->
		<div id="content" class="grid_8 listing">	

			<!-- .entry-content -->
			<div class="entry-content" style="display:block">
				<?php _e('No ad could be found at your watchlist.','autotrader'); ?>
			</div><!-- end - .entry-content -->
			
			<!-- .watchlist-sort -->
			<div class="watchlist-sort items-sort clearfix" style="display:none">
				<span class="delete-link"><a href="#"><?php _e('Delete all','autotrader'); ?></a></span>
				<div class="sort-container">
					<span><?php _e('Sort by','autotrader'); ?></span>
					<select id="sort-results" name="sort-results">
						<option value="newest"><?php _e('Date (Newest > Oldest)','autotrader'); ?></option>
						<option value="oldest"><?php _e('Date (Oldest > Newest)','autotrader'); ?></option>
						<option value="lowest"><?php _e('Price (Low > High)','autotrader'); ?></option>
						<option value="highest"><?php _e('Price (High > Low)','autotrader'); ?></option>
					</select>
				</div>
			</div><!-- end - .watchlist-sort -->
			
			<!-- .watchlist-results -->
			<div class="watchlist-results">
				<!-- Ajax container -->
			</div><!-- end - .watchlist-results -->
			
			
			<!-- .watchlist-paging -->
			<div class="watchlist-paging">
				<!-- Ajax container -->
			</div><!-- end - .watchlist-paging -->	
			
		</div><!-- end - #content -->
		
		<!-- #sidebar -->
		<div id="sidebar" class="grid_4">
			<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Right Sidebar') ) ?>		
		</div><!-- end - #sidebar -->		
		
		<div class="clear"></div>
	</div>	
</div>
<div class="clear"></div>
<!-- end - #watchlist -->
		
<?php get_footer(); ?>
<script type="text/javascript">

	var $j = jQuery.noConflict();
	
	$j(document).ready(function(){			

		initialization();
		
		function initialization() {
		
			// initialize the sort option
			$j("#sort-results option[value='newest']").attr('selected', 'selected');
			
			$j('#watchlist').data('page_nr', '1');
			$j('#watchlist').data('order_by', 'date');
			$j('#watchlist').data('order', 'DESC');			
		
			show_watchlist();
		}
		
		function show_watchlist() {
		
			$page_nr = $j('#watchlist').data('page_nr'); 
			$order_by = $j('#watchlist').data('order_by');  
			$order = $j('#watchlist').data('order'); 

			$j.ajax({
				type    : 'POST',
				url     : '<?php echo admin_url('admin-ajax.php'); ?>',
				dataType: 'json',
				cache	: false,
				data    : { action 	 : 'dox_show_watchlist',
							user_id  : '<?php echo $current_user->ID; ?>',
							page_nr  : $page_nr,
							order_by : $order_by,
							order	 : $order },
				success : function(response) {
					$j("#watchlist .watchlist-results").empty();
					$j("#watchlist .watchlist-paging").empty();					
					if (response.alert) {									
						$j("#watchlist .watchlist-alert").removeClass('alert-success alert-error alert-warning');
						$j("#watchlist .watchlist-alert").addClass(response.alert);
						
						$j("#watchlist .watchlist-alert p").empty();
						$j("#watchlist .watchlist-alert p").append(response.message);
						
						$j('#watchlist .watchlist-alert').css('display','block');
						$j('#watchlist .watchlist-alert').delay(4000).slideUp(350); 	
					} else {
						
						$j('.entry-content').css('display','none');						
						$j('.watchlist-sort').show();
						
						$j("#watchlist .watchlist-results").append(response.results);
						$j("#watchlist .watchlist-paging").append(response.pager);							
					}
				}
			});			
		}	
		
		// sorting results
		$j("#sort-results").change(function () {
			
			$j('#watchlist').removeData('sort');
			$j('#watchlist').data('sort', $j("#sort-results").val());
			
			if ($j('#watchlist').data('sort') == 'newest') {
			
				$j('#watchlist').removeData('order_by');
				$order_by = $j('#watchlist').data('order_by', 'date');
				
				$j('#watchlist').removeData('order');
				$order = $j('#watchlist').data('order', 'DESC');
				
			} else if ($j('#watchlist').data('sort') == 'oldest') {

				$j('#watchlist').removeData('order_by');
				$order_by = $j('#watchlist').data('order_by', 'date');
				
				$j('#watchlist').removeData('order');
				$order = $j('#watchlist').data('order', 'ASC');
							
			} else if ($j('#watchlist').data('sort') == 'lowest') { 

				$j('#watchlist').removeData('order_by');
				$order_by = $j('#watchlist').data('order_by', 'price');
				
				$j('#watchlist').removeData('order');
				$order = $j('#watchlist').data('order', 'ASC');
							
			} else if ($j('#watchlist').data('sort') == 'highest') {

				$j('#watchlist').removeData('order_by');
				$order_by = $j('#watchlist').data('order_by', 'price');
				
				$j('#watchlist').removeData('order');
				$order = $j('#watchlist').data('order', 'DESC');
							
			}
			
			show_watchlist()
		});
		
		// paging
		$j("a.pager").live("click", function(){
			
			$j('#watchlist').removeData('page_nr');
			$j('#watchlist').data('page_nr', $j(this).text());
			
			show_watchlist();
			
			return false;
		});			
				
		// delete to watchlist
		$j('#watchlist .custom-post-type .watchlist-button').live("click", function() {
			
			// get post id
			var $post_id = $j(this).attr("href").match(/delete=([0-9]+)/)[1];
			
			$j.ajax({
				type    : 'POST',
				url     : '<?php echo admin_url('admin-ajax.php'); ?>',
				dataType: 'json',
				cache	: false,
				data    : { action 	 : 'dox_delete_to_watchlist', 
							post_id  : $post_id },
				success : function(response) {
					
					show_watchlist();
					
					$j(".watchlist-alert").removeClass('alert-success alert-error alert-warning');
					$j(".watchlist-alert").addClass(response.alert);
					
					$j(".watchlist-alert p").empty();
					$j(".watchlist-alert p").append(response.message);

					$j('.watchlist-alert').css('display','block');
					$j('.watchlist-alert').delay(4000).slideUp(350); 

				}
			});				
			
			return false;
		});

		// delete all ads from watchlist
		$j(".watchlist-sort .delete-link a").click(function(){
			
			// delete permanently
			 if ( confirm('<?php _e('Are you sure to delete all watchlist ads?','autotrader') ?>')) {
			
				$j.ajax({
					type    : 'POST',
					url     : '<?php echo admin_url('admin-ajax.php'); ?>',
					dataType: 'json',
					data    : { action 	 : 'dox_delete_all_watchlist',
								user_id  : '<?php echo $current_user->ID; ?>'},
					success : function(response) {
				
						$j(".watchlist-alert").removeClass('alert-success alert-error alert-warning');
						$j(".watchlist-alert").addClass(response.alert);
						
						if (response.alert == "alert-success") { 
							$j("#watchlist .watchlist-results").empty();
							$j("#watchlist .watchlist-paging").empty();
							$j("#watchlist .watchlist-sort").remove();
						}
												
						$j(".watchlist-alert p").empty();
						$j(".watchlist-alert p").append(response.message);

						$j('.watchlist-alert').css('display','block');
						$j('.watchlist-alert').delay(4000).slideUp(350);				
					}
					
				});	
				
			}
			
			return false;
		});	
		
	})						  
</script>
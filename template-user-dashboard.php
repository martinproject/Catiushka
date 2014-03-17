<?php 
/*
Template Name: User Dashboard
*/
?>
<?php get_header(); ?>
		
<!-- #user-dashboard -->
<div id="userDashboard" class="dox-template container">
	<div class="container_12 clearfix">
		<div class="grid_12"><h3 class="page-title"><?php the_title(); ?></h3></div>

		<!-- #content -->
		<div id="content" class="grid_8">			
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<!-- if-not-user-logged-in -->
			<?php	$user_logged = false;
					if ( !is_user_logged_in() ) {
						get_template_part( 'login-popup' ); 
					} else { $user_logged = true; $current_user = wp_get_current_user(); }
			?><!-- end - if-not-user-logged-in -->
			
			<!-- .post -->
			<div <?php post_class('clearfix') ?> id="post-<?php the_ID(); ?>">
				
				<!-- .entry-content -->
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- end - .entry-content -->
				
				<!-- if-user-is-logged -->
				<?php if ($user_logged == true) { ?>
				
					<!-- .user-ads -->
					<div class="user-ads cgrid">
						<h4 class="section-title section-line"><?php _e('Your Ads', 'autotrader') ?></h4>
						
						<!-- .cgrid-alert -->
						<div class="cgrid-alert alert" style="display:none">
							<p></p>
						</div><!-- end .cgrid-alert -->
					
						<!-- viewing post status -->
						<div class="post-status selector">
							<select name="post-status" id="post-status">
								<option value="publish"><?php _e('Published', 'autotrader') ?></option>
								<option value="pending"><?php _e('Pending', 'autotrader') ?></option>
								<option value="trash"><?php _e('Deleted', 'autotrader') ?></option>
							</select>
						</div><!-- end - viewing post status -->
					
						<!-- .cgrid-header -->
						<div class="cgrid-header">
							<ul>
								<li class="cgrid_9"><?php _e('Title', 'autotrader') ?></li>	
								<li class="cgrid_4 date cursor"><?php _e('Date', 'autotrader') ?></li>
								<li class="cgrid_3 price cursor"><?php _e('Price', 'autotrader') ?></li>
								<li class="cgrid_2"><?php _e('Edit', 'autotrader') ?></li>
								<li class="cgrid_2 last"><?php _e('Delete', 'autotrader') ?></li>
							</ul>					
						</div><!-- end - .cgrid-header -->
												
						<!-- .cgrid-body -->
						<div class="cgrid-body">
						
							<!-- Ajax container -->
							
						</div><!-- end - .cgrid-body -->

						<!-- .cgrid-paging -->
						<div class="cgrid-paging">
						
							<!-- Ajax container -->
							
						</div><!-- end - .cgrid-paging -->						
					
					</div><!-- end - .user-ads -->
				
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
<!-- end - #user-dashboard -->
		
<?php get_footer(); ?>
<script type="text/javascript">

	var $j = jQuery.noConflict();
	
	$j(document).ready(function(){			
		
		initialization();
		
		function initialization() {
			
			// initialize the selector option
			$j("#post-status option[value='publish']").attr('selected', 'selected');
			
			$j('.user-ads').data('status', 'publish');
			$j('.user-ads').data('page_nr', '1');
			$j('.user-ads').data('order_by', 'date');
			$j('.user-ads').data('order', 'DESC');
			
			show_user_ads();
		}
		
		function show_user_ads() {
		
			$post_status = $j('.user-ads').data('status');
			$page_nr = $j('.user-ads').data('page_nr'); 
			$order_by = $j('.user-ads').data('order_by');  
			$order = $j('.user-ads').data('order'); 

			$j.ajax({
				type    : 'POST',
				url     : '<?php echo admin_url('admin-ajax.php'); ?>',
				dataType: 'json',
				cache	: false,
				data    : { action 	 : 'dox_user_ads', 
							user_id  : '<?php echo $current_user->ID; ?>',
							status   : $post_status,
							page_nr  : $page_nr,
							order_by : $order_by,
							order	 : $order },
				success : function(response) {
					$j(".user-ads .cgrid-body").empty();
					$j(".user-ads .cgrid-paging").empty();
					
					if (response.alert) {
						$j(".user-ads .cgrid-alert").removeClass('alert-success alert-error alert-warning');
						$j(".user-ads .cgrid-alert").addClass(response.alert);
						
						$j(".user-ads .cgrid-alert p").empty();
						$j(".user-ads .cgrid-alert p").append(response.message);

						$j('.user-ads .cgrid-alert').css('display','block');
						$j('.user-ads .cgrid-alert').delay(4000).slideUp(350); 	
					} else {
						$j(".user-ads .cgrid-body").append(response.items);
						$j(".user-ads .cgrid-paging").append(response.pager);							
					}

				}
			});			
		}
		
		// changing post status
		$j("#post-status").change(function () {
		
			$j('.user-ads').removeData('status');
			$j('.user-ads').data('status', $j("#post-status").val());
			
			show_user_ads();
		});
		
		// sorting options
		$j('.user-ads .cgrid-header ul li').click(function() {
			
			if ($j(this).hasClass('date')) {
				$j('.user-ads').removeData('order_by');
				$j('.user-ads').data('order_by', 'date');
				
				if ($j('.user-ads').data('order') == 'ASC') {
					$j('.user-ads').removeData('order');
					$j('.user-ads').data('order', 'DESC');
				} else {
					$j('.user-ads').removeData('order');
					$j('.user-ads').data('order', 'ASC');					
				}
				
				show_user_ads();				
			}
			else if ($j(this).hasClass('price')) {
				$j('.user-ads').removeData('order_by');
				$j('.user-ads').data('order_by', 'price');
				
				if ($j('.user-ads').data('order') == 'ASC') {
					$j('.user-ads').removeData('order');
					$j('.user-ads').data('order', 'DESC');
				} else {
					$j('.user-ads').removeData('order');
					$j('.user-ads').data('order', 'ASC');					
				}				
				
				show_user_ads();
			}
		});
		
		$j(".user-ads .cgrid-body ul li a.deleteLink").live("click", function(){
			
			// get post id
			var $post_id = $j(this).attr("href").match(/delete=([0-9]+)/)[1];
			
			
			if ($j('.user-ads').data('status') == 'trash') { 
			
				// delete permanently
				 if ( confirm('<?php _e('Are you sure to delete this ad PERMANENTLY?','autotrader') ?>')) {
				
					$j.ajax({
						type    : 'POST',
						url     : '<?php echo admin_url('admin-ajax.php'); ?>',
						dataType: 'json',
						data    : { action 	 : 'dox_delete_ad', 
									post_id  : $post_id },
						success : function(response) {
							$j(".user-ads .cgrid-alert").removeClass('alert-success alert-error alert-warning');
							$j(".user-ads .cgrid-alert").addClass(response.alert);
							
							$j(".user-ads .cgrid-alert p").empty();
							$j(".user-ads .cgrid-alert p").append(response.message);
							
							// refresh grid
							show_user_ads();
							
							$j('.user-ads .cgrid-alert').css('display','block');
							$j('.user-ads .cgrid-alert').delay(4000).slideUp(350); 					
						}
					});	
				}
				
			} else {
				
				// move to trash
				 if ( confirm('<?php _e('Are you sure to delete this ad?','autotrader') ?>')) {
				
					$j.ajax({
						type    : 'POST',
						url     : '<?php echo admin_url('admin-ajax.php'); ?>',
						dataType: 'json',
						data    : { action 	 : 'dox_move_ad_to_trash', 
									post_id  : $post_id },
						success : function(response) {
							$j(".user-ads .cgrid-alert").removeClass('alert-success alert-error alert-warning');
							$j(".user-ads .cgrid-alert").addClass(response.alert);
							
							$j(".user-ads .cgrid-alert p").empty();
							$j(".user-ads .cgrid-alert p").append(response.message);

							// refresh grid
							show_user_ads();
							
							$j('.user-ads .cgrid-alert').css('display','block');
							$j('.user-ads .cgrid-alert').delay(4000).slideUp(350); 					
						}
					});	
				}
			}
			
			return false;
		});	

		// if page clicked
		$j("a.pager").live("click", function(){
			
			var $page_nr = $j(this).text();
			$j('.user-ads').removeData('page_nr');
			$j('.user-ads').data('page_nr', $page_nr);

			show_user_ads();

			return false;
		});			
		
	})						  
</script>

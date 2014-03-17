<?php get_header(); ?>
		
<!-- #page-404 -->
<div id="page-404" class="container">
	<div class="container_12 clearfix">
		<div class="grid_12"><h3 class="page-title"><?php _e('Page Not Found', 'autotrader') ?></h3></div>

		<!-- #content -->
		<div id="content" class="grid_8">	
		
			<!-- .post -->
			<div class="post grid_8 alpha">
				
				<h3 class="blog-title"><?php _e("Sorry, we could not find the page you are looking for.",'autotrader'); ?></a></h3>
				<h3><?php _e("Please search the content at site.",'autotrader'); ?></h3>
				
			</div><!-- end - .post -->					
			
		</div><!-- end - #content -->
		
		<!-- #sidebar -->
		<div id="sidebar" class="grid_4">
			<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Blog Sidebar') ) ?>		
		</div><!-- end - #sidebar -->		
		
		<div class="clear"></div>
	</div>	
</div>
<div class="clear"></div>
<!-- end - #page-404 -->
		
<?php get_footer(); ?>
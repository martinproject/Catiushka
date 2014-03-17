<?php 
/*
Template Name: Full Width
*/
?>
<?php get_header(); ?>
		
<!-- #page -->
<div id="page" class="container">
	<div class="container_12 clearfix">
		<div class="grid_12"><h3 class="page-title"><?php the_title(); ?></h3></div>

		<!-- #content -->
		<div id="content" class="grid_12">	
			<?php if (have_posts()) : while (have_posts()) : the_post();
				
				/* get permalink */
				$permalink = get_permalink(get_the_ID());
			?>
			
			<!-- .post -->
			<div <?php post_class('clearfix') ?> id="post-<?php the_ID(); ?>">
			
				<!-- .post-container -->
				<div class="post-container grid_12 alpha omega">
				
					<div class="post-meta grid_2 alpha">
					
						<!-- .post-meta-data -->
						<div class="post-meta-data">
							<span class="posted"><?php the_time( get_option('date_format') ) ?></span>
							<span class="author"><?php the_author_posts_link(); ?></span> 
							<span class="comment"><?php comments_popup_link(__('No comments', 'autotrader'), __('1 Comment', 'autotrader'), __('% Comments', 'autotrader')); ?></span>
						</div><!-- .post-meta-data -->
						
						<!-- .social-buttons -->
						<div class="social-buttons">
							
							<span class="twitter"><a href="http://twitter.com/share?url=<?php echo $permalink; ?>&text=<?php echo get_the_title().' - '.$permalink; ?>&via=<?php echo $dox_options['footer']['twitter']; ?>" class="twitter-share-button" data-count="horizontal"><?php _e('Tweet this article', 'autotrader'); ?></a></span>
							<span class="google"><div class="g-plusone" data-size="medium" data-href="<?php echo $permalink; ?>"></div></span>
							<span class="facebook"><div id="fb-root"></div><div class="fb-like" data-href="<?php echo $permalink; ?>" data-send="false" data-layout="button_count" data-width="100" data-show-faces="false" data-font="arial"></div></span>
							<div class="clear"></div>
						</div><!-- end - .social-buttons -->					
					
					</div>
					
					<!-- .post-data -->
					<div class="post-data grid_10 omega">
						<div class="entry-content">
						<?php the_content(); ?>									
						</div>						
					</div><!-- .post-data -->
					
				</div><!-- end - .post-container -->				
			
			</div><!-- end - .post -->
			
			<?php comments_template(); ?>  
							
			<?php endwhile; endif; ?>	
			
		</div><!-- end - #content -->
	
		<div class="clear"></div>
	</div>	
</div>
<div class="clear"></div>
<!-- end - #page -->
		
<?php get_footer(); ?>
<?php get_header();?>
		
<?php global $dox_options; ?>
<!-- #single-post -->
<div id="single-post" class="container">
	<div class="container_12 clearfix">
		<div class="grid_12"><h3 class="page-title"><?php _e('Autotrader Blog', 'autotrader') ?></h3></div>

		<!-- #content -->
		<div id="content" class="grid_8">	
			<?php if (have_posts()) : while (have_posts()) : the_post();
				
				/* get permalink */
				$permalink = get_permalink(get_the_ID());
			?>
			
			<!-- .post -->
			<div <?php post_class('clearfix') ?> id="post-<?php the_ID(); ?>">
			
				<div class="post-image"><?php echo dox_get_post_image($post->ID, 'default-thumb', 'blog', false); ?></div>

				<!-- .post-container -->
				<div class="post-container grid_8 alpha">
					<h3 class="blog-title"><?php the_title(); ?></h3>
					
					<div class="post-meta grid_2 alpha">
					
						<!-- .post-meta-data -->
						<div class="post-meta-data">
							<span class="posted"><?php the_time( get_option('date_format') ) ?></span>
							<span class="author"><?php the_author_posts_link(); ?></span> 
							<span class="comment"><?php comments_popup_link(__('No comments', 'autotrader'), __('1 Comment', 'autotrader'), __('% Comments', 'autotrader')); ?></span>
							<span class="tags"><?php $tags = wp_get_post_tags($post->ID); if(! empty($tags)) { $tag_link = get_tag_link($tags[0]->term_id); echo '<a href="'.$tag_link.'">'.$tags[0]->name.'</a>'; } ?></span>						
						</div><!-- .post-meta-data -->
						
						<!-- .social-buttons -->
						<div class="social-buttons">
							
							<span class="twitter"><a href="http://twitter.com/share?url=<?php echo $permalink; ?>&text=<?php echo get_the_title(); ?>&via=<?php echo $dox_options['footer']['twitter']; ?>" class="twitter-share-button" data-count="horizontal"><?php _e('Tweet this article', 'autotrader'); ?></a></span>
							<span class="google"><div class="g-plusone" data-size="medium" data-href="<?php echo $permalink; ?>"></div></span>
							<span class="facebook"><div id="fb-root"></div><div class="fb-like" data-href="<?php echo $permalink; ?>" data-send="false" data-layout="button_count" data-width="100" data-show-faces="false" data-font="arial"></div></span>
							<div class="clear"></div>
						</div><!-- end - .social-buttons -->					
					
					</div>
					
					<!-- .post-data -->
					<div class="post-data grid_6 omega">
						<div class="entry-content">
						<?php the_content(); ?>									
						</div>						
					</div><!-- .post-data -->
					
				</div><!-- end - .post-container -->				
			
			</div><!-- end - .post -->
			
			<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			
			<?php comments_template(); ?>  
							
			<?php endwhile; endif; ?>	
			
		</div><!-- end - #content -->
		
		<!-- #sidebar -->
		<div id="sidebar" class="grid_4">
			<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Blog Sidebar') ) ?>		
		</div><!-- end - #sidebar -->		
		
		<div class="clear"></div>
	</div>	
</div>
<div class="clear"></div>
<!-- end - #single-post -->
		
<?php get_footer(); ?>
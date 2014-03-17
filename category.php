<?php get_header(); ?>
		
<!-- #category -->
<div id="category" class="container">
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
			
				<div class="post-image">
					<a href="<?php echo $permalink; ?>" class="opac">
						<?php echo dox_get_post_image($post->ID, 'default-thumb', 'blog', false); ?>
					</a>				
				</div>

				<!-- .post-container -->
				<div class="post-container grid_8 alpha">
					
					<h3 class="blog-title"><a href="<?php echo $permalink; ?>"><?php the_title(); ?></a></h3>
					
					<div class="post-meta grid_2 alpha">
						<!-- .post-meta-data -->
						<div class="post-meta-data">
							<span class="posted"><?php the_time( get_option('date_format') ) ?></span>
							<span class="author"><?php the_author_posts_link(); ?></span> 
							<span class="comment"><?php comments_popup_link(__('No comments', 'autotrader'), __('1 Comment', 'autotrader'), __('% Comments', 'autotrader')); ?></span>
							<span class="tags"><?php $tags = wp_get_post_tags($post->ID); if(! empty($tags)) { $tag_link = get_tag_link($tags[0]->term_id); echo '<a href="'.$tag_link.'">'.$tags[0]->name.'</a>'; } ?></span>						
						</div><!-- .post-meta-data -->
					</div>
					
					<!-- .post-data -->
					<div class="post-data grid_6 omega">
						<div class="entry-content">
						<?php dox_get_post($dox_options['blog']['excerpt']); ?>									
						</div>
					</div><!-- .post-data -->
					
				</div><!-- end - .post-container -->				
			
			</div><!-- end - .post -->
							
			<?php endwhile; endif; ?>
			
			<!-- .category-paging -->
			<?php	$page_nr= intval(get_query_var('paged'));
					$max_page = $wp_query->max_num_pages; ?>
					
			<div class="category-paging">					
				<?php echo dox_pager( $page_nr, $max_page, false ); ?>	
				<div class="navleft" style="display:none"><?php next_posts_link(__('&larr; Older Entries', 'autotrader')) ?></div>
				<div class="navright" style="display:none"><?php previous_posts_link(__('Newer Entries &rarr;', 'autotrader')) ?></div>					
			</div><!-- end - .category-paging -->	
			
		</div><!-- end - #content -->
		
		<!-- #sidebar -->
		<div id="sidebar" class="grid_4">
			<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Blog Sidebar') ) ?>		
		</div><!-- end - #sidebar -->		
		
		<div class="clear"></div>
	</div>	
</div>
<div class="clear"></div>
<!-- end - #category -->
		
<?php get_footer(); ?>
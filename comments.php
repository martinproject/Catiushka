<?php

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php esc_html_e('This post is password protected. Enter the password to view comments.', 'autotrader'); ?></p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
<div id="comments">
	<h3 class="comment-title"><?php comments_number( __( 'No Responses', 'autotrader' ), __( '1 Comment', 'autotrader' ), __( '% Comments', 'autotrader' ) );?></h3>

	<div class="clear"></div>

	<ol class="commentlist">
	    <?php wp_list_comments('type=comment&callback=dox_comment'); ?>
	</ol>

	<div class="clear"></div>

<?php // pagination
		if(function_exists('wp_commentnavi')) :
			wp_commentnavi();
		else : ?>
			<div class="comment-navigation">
				<div class="alignleft"><?php previous_comments_link() ?></div>
				<div class="alignright"><?php next_comments_link() ?></div>
			</div>
<?php	endif; ?>
	<div class="clear"></div>
</div>
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php esc_html_e('Comments are closed.', 'autotrader'); ?></p>

	<?php endif; ?>
	
<?php endif; ?>

<?php if ( comments_open() ) : ?>

<div id="respond">

<h3 class="comment-title"><?php comment_form_title( __( 'Leave a Reply', 'autotrader' ), __( 'Leave a Reply to %s', 'autotrader' ) ); ?></h3>

<div class="cancel-comment-reply">
	<?php cancel_comment_reply_link(); ?>
</div>

<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : 
	    printf( __('<p>You must be <a href="%s">logged in</a> to post a comment.</p>', 'autotrader' ), wp_login_url( get_permalink()) );
      else : ?>

	<!-- .step-form -->
	<div class="step-form">
			
		<!-- .step-form-wrap -->
		<div class="step-form-wrap">
			<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( is_user_logged_in() ) : ?>

				<div class="form-input clearfix">
					<?php printf( __('Logged in as <a href="%1$s/wp-admin/profile.php">%2$s</a>.', 'autotrader' ), get_option('siteurl'), $user_identity ); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php esc_html_e('Log out of this account', 'autotrader'); ?>"><?php esc_html_e('Log out &raquo;', 'autotrader'); ?></a></p>
				</div>
<?php else : ?>

				<div class="form-input clearfix">
					<label for="author"><?php esc_html_e('Name', 'autotrader'); ?> <?php if ($req) esc_html_e('(required)', 'autotrader'); ?></label>							
					<input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="20" tabindex="1"/>
				</div>									
				
				<div class="form-input clearfix">
					<label for="email"><?php esc_html_e('Mail (will not be published)', 'autotrader'); ?> <?php if ($req) esc_html_e('(required)', 'autotrader'); ?></label>							
					<input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="35" tabindex="2"/>
				</div>	
				
				<div class="form-input clearfix">
					<label for="url"><?php esc_html_e('Website', 'autotrader'); ?></label>							
					<input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="25" tabindex="3" />
				</div>				
<?php endif; ?>

				<div class="form-input clearfix">
					<label for="comment"><?php _e('Comment','autotrader'); ?></label>							
					<textarea name="comment" id="comment" cols="50" rows="5" tabindex="4"></textarea>
				</div>

				<div class="form-input clearfix">
					<input name="submit" type="submit" id="submit" tabindex="5" value="<?php esc_attr_e('Submit Comment', 'autotrader'); ?>" />
					<?php comment_id_fields(); ?>
				</div>

				<?php do_action('comment_form', $post->ID); ?>

			</form>
			<div class="clear"></div>
		</div><!-- .step-form-wrap -->
		<div class="clear"></div>
	</div><!-- end - .step-form -->	

<?php endif; // If registration required and not logged in ?>
	<div class="clear"></div>
</div>

<?php endif; // if you delete this the sky will fall on your head ?>

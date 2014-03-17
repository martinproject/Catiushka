<?php 
	global $dox_options;
	
	$post_type = get_post_type( $post->ID );
	if ($post_type == 'post') get_template_part('part-single-post');
	elseif ($post_type == $dox_options['ad_set']['type']['base']) get_template_part('part-single-custom');
	else get_template_part('part-single-post');
?>
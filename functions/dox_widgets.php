<?php 


/**
* Display auto's terms link by chosen taxonomy
*
* @package Autotrader
* @since 1.0.0
*/
class dox_wid_browse_autos extends WP_Widget {

     function dox_wid_browse_autos() {

		$widget_ops = array( 'classname' => 'dox_wid_browse_autos', 'description' => __('Browse autos by category', 'autotrader') );
		$control_ops = array( 'width' => 300, 'id_base' => 'dox_wid_browse_autos' );

		$this->WP_Widget( 'dox_wid_browse_autos', __('DOX: Browse Autos', 'autotrader'), $widget_ops, $control_ops );
     }

     function widget($args, $instance) {
		extract( $args );
		$title= $instance['title'];
		$taxonomy = $instance['taxonomy'];		
		$number = $instance['number'];
		$orderby = $instance['orderby'];		
		$order = $instance['order'];		

		// Start widget
		echo $before_widget;  ?>
		
			<h3><?php if ( $title ) echo $title; ?></h3>
			<ul class="<?php echo $taxonomy; ?> clearfix">
				<?php echo dox_get_list_terms($taxonomy, 0,  $number, $orderby, $order); ?> 
			</ul>
			
		<?php echo $after_widget;
     }

     function update($new_instance, $old_instance) {
       $instance = $old_instance;
	   $instance['title'] = $new_instance['title'];
	   $instance['taxonomy'] = $new_instance['taxonomy'];
	   $instance['number'] = $new_instance['number'];
	   $instance['orderby'] = $new_instance['orderby'];
	   $instance['order'] = $new_instance['order'];	   
	   
		return $instance;
     }

     function form($instance) {
	 
		global $dox_options; 
		
		$defaults = array(
			'title' => '',
			'taxonomy' => '',		
			'number' => '10',
			'orderby' => 'count',
			'order' => 'DESC'
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'autotrader') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>		
		<p>
			<label for="<?php echo $this->get_field_id( 'taxonomy' ); ?>"><?php _e('Browse Category', 'autotrader') ?></label>
			<select id="<?php echo $this->get_field_id( 'taxonomy' ); ?>" name="<?php echo $this->get_field_name( 'taxonomy' ); ?>" class="widefat">
				
				<?php if ( $dox_options['ad_set']['model']['show'] == 'true' ) {  ?>
					<option value="<?php echo $dox_options['ad_set']['model']['query'] ?>" <?php if ( $dox_options['ad_set']['model']['query'] == $instance['taxonomy'] ) echo 'selected="selected"'; ?>><?php echo $dox_options['ad_set']['model']['name']; ?></option>
				<?php } ?>
				
				<?php if ( $dox_options['ad_set']['condition']['show'] == 'true' ) {  ?>
					<option value="<?php echo $dox_options['ad_set']['condition']['query'] ?>" <?php if ( $dox_options['ad_set']['condition']['query'] == $instance['taxonomy'] ) echo 'selected="selected"'; ?>><?php echo $dox_options['ad_set']['condition']['name']; ?></option>
				<?php } ?>
				
				<?php if ( $dox_options['ad_set']['location']['show'] == 'true' ) {  ?>
					<option value="<?php echo $dox_options['ad_set']['location']['query'] ?>" <?php if ( $dox_options['ad_set']['location']['query'] == $instance['taxonomy'] ) echo 'selected="selected"'; ?>><?php echo $dox_options['ad_set']['location']['name']; ?></option>
				<?php } ?>
				
				<?php if ( $dox_options['ad_set']['color']['show'] == 'true' ) {  ?>
					<option value="<?php echo $dox_options['ad_set']['color']['query'] ?>" <?php if ( $dox_options['ad_set']['color']['query'] == $instance['taxonomy'] ) echo 'selected="selected"'; ?>><?php echo $dox_options['ad_set']['color']['name']; ?></option>
				<?php } ?>
				
				<?php if ( $dox_options['ad_set']['bodyType']['show'] == 'true' ) {  ?>
					<option value="<?php echo $dox_options['ad_set']['bodyType']['query'] ?>" <?php if ( $dox_options['ad_set']['bodyType']['query'] == $instance['taxonomy'] ) echo 'selected="selected"'; ?>><?php echo $dox_options['ad_set']['bodyType']['name']; ?></option>
				<?php } ?>
				
				<?php if ( $dox_options['ad_set']['fuelType']['show'] == 'true' ) {  ?>
					<option value="<?php echo $dox_options['ad_set']['fuelType']['query'] ?>" <?php if ( $dox_options['ad_set']['fuelType']['query'] == $instance['taxonomy'] ) echo 'selected="selected"'; ?>><?php echo $dox_options['ad_set']['fuelType']['name']; ?></option>
				<?php } ?>
				
				<?php if ( $dox_options['ad_set']['year']['show'] == 'true' ) {  ?>
					<option value="<?php echo $dox_options['ad_set']['year']['query'] ?>" <?php if ( $dox_options['ad_set']['year']['query'] == $instance['taxonomy'] ) echo 'selected="selected"'; ?>><?php echo $dox_options['ad_set']['year']['name']; ?></option>
				<?php } ?>
				
				<?php if ( $dox_options['ad_set']['transmission']['show'] == 'true' ) {  ?>
					<option value="<?php echo $dox_options['ad_set']['transmission']['query'] ?>" <?php if ( $dox_options['ad_set']['transmission']['query'] == $instance['taxonomy'] ) echo 'selected="selected"'; ?>><?php echo $dox_options['ad_set']['transmission']['name']; ?></option>			
				<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Number of terms to show:', 'autotrader') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" />
		</p>		
		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e('Order by:', 'autotrader') ?></label>
			<select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>" class="widefat">
				<option value="count" <?php if ( 'count' == $instance['orderby'] ) echo 'selected="selected"'; ?>><?php _e('Count','autotrader'); ?></option>
				<option value="name" <?php if ( 'name' == $instance['orderby'] ) echo 'selected="selected"'; ?>><?php _e('Name','autotrader'); ?></option>
				<option value="ID" <?php if ( 'ID' == $instance['orderby'] ) echo 'selected="selected"'; ?>><?php _e('Term ID','autotrader'); ?></option>					
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e('Order:', 'autotrader') ?></label>
			<select id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>" class="widefat">
				<option value="DESC" <?php if ( 'DESC' == $instance['order'] ) echo 'selected="selected"'; ?>><?php _e('Descending','autotrader'); ?></option>
				<option value="ASC" <?php if ( 'ASC' == $instance['order'] ) echo 'selected="selected"'; ?>><?php _e('Ascending','autotrader'); ?></option>				
			</select>
		</p>		
				
		<?php
     }
}

register_widget('dox_wid_browse_autos');

/**
* Display auto's terms link by chosen taxonomy
*
* @package Autotrader
* @since 1.0.0
*/
class dox_wid_show_posts extends WP_Widget {

     function dox_wid_show_posts() {

		$widget_ops = array( 'classname' => 'dox_wid_show_posts', 'description' => __('Show posts', 'autotrader') );
		$control_ops = array( 'width' => 300, 'id_base' => 'dox_wid_show_posts' );

		$this->WP_Widget( 'dox_wid_show_posts', __('DOX: Show Posts', 'autotrader'), $widget_ops, $control_ops );
     }

     function widget($args, $instance) {
		extract( $args );
		$title= $instance['title'];
		$post_type = $instance['post_type'];		
		$number = $instance['number'];	

		global $dox_options;
			
		$error = false;
		$meta_query = array();
		$meta = array();
		
		if ($post_type == 'latest_ads') { 
			$postType = $dox_options['ad_set']['type']['base']; 
		}
		elseif ($post_type == 'featured_ads') { 
			$postType = $dox_options['ad_set']['type']['base']; 
			$meta['key'] = "featured_ad"; 
			$meta['value'] = DOX_FEATURED_AD; 
			$meta['type'] = "CHAR";
			$meta['compare'] = "==";
			$meta_query[] = $meta;
		}
		elseif ($post_type == 'latest_blogs') { 
			$postType = 'post';
		}
		else { $error = true; }
				
		
		// Prepare query parameter
		$query = array();		
		$query['post_type'] = $postType;
		$query['orderby'] = "date";
		$query['order'] = "DESC";
		$query['post_status'] = "publish";	
		$query['posts_per_page'] = $number;
		$query['meta_query'] = $meta_query;		
		
		$output = '';
		if ($error == false) {
	
			// Process the query
			$posts = new WP_Query( $query );
			
			if ($posts->have_posts()){
			
				// Prepare output data
				$output .= '<ul class="clearfix">';
				while ( $posts->have_posts() ) : $posts->the_post(); global $post;
					$permalink = get_permalink($post->ID);
					$post_date = get_the_time( get_option('date_format') );
					$price = get_post_meta($post->ID, $dox_options['ad_set']['price']['query'], true);
					$postThumb = dox_get_post_image($post->ID, 'default-thumb', 'tiny' );
				
					$output .= '<li>';
					$output .= '<a href="'.$permalink.'" class="opac">'.$postThumb.'</a>';
					$output .= '<h5><a href="'.$permalink.'">'.$post->post_title.'</a>';					
					if ($post_type == 'latest_blogs') { $output .= '<span class="post-date"> - '.$post_date.'</span>'; } 
						else { $output .= '<span class="ad-price"> - '.$price.' '.$dox_options['ad']['currency'].'</span>'; }
					$output .= '</h5></li>';
				endwhile;
				$output .= '</ul>';
			}
			
		}
		else { $output .= '<h4>'.__('Sorry, an error occured. Check widget parameters.','autotrader').'</h4>'; }
		
		
		// Start widget
		echo $before_widget;  ?>
		
			<h3><?php if ( $title ) echo $title; ?></h3>

		<?php 	echo $output;
				echo $after_widget;
     }

     function update($new_instance, $old_instance) {
       $instance = $old_instance;
	   $instance['title'] = $new_instance['title'];
	   $instance['post_type'] = $new_instance['post_type'];
	   $instance['number'] = $new_instance['number'];
	   
		return $instance;
     }

     function form($instance) {
	 
		$defaults = array(
			'title' => '',
			'post_type' => '',		
			'number' => '5'
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'autotrader') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>		
		<p>
			<label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e("Post's Category", "autotrader") ?></label>
			<select id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>" class="widefat">
				<option value="latest_ads" <?php if ( 'latest_ads' == $instance['post_type'] ) echo 'selected="selected"'; ?>><?php _e('Latest Ads','autotrader'); ?></option>
				<option value="featured_ads" <?php if ( 'featured_ads' == $instance['post_type'] ) echo 'selected="selected"'; ?>><?php _e('Featured Ads','autotrader'); ?></option>
				<option value="latest_blogs" <?php if ( 'latest_blogs' == $instance['post_type'] ) echo 'selected="selected"'; ?>><?php _e('Latest Blog Posts','autotrader'); ?></option>				
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Number of posts to show:', 'autotrader') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" />
		</p>		
				
		<?php
     }
}

register_widget('dox_wid_show_posts');

/**
* Search autos box
*
* @package Autotrader
* @since 1.0.0
*/
class dox_wid_search_autos extends WP_Widget {

     function dox_wid_search_autos() {

		$widget_ops = array( 'classname' => 'dox_wid_search_autos', 'description' => __('Search Autos Box', 'autotrader') );
		$control_ops = array( 'width' => 300, 'id_base' => 'dox_wid_search_autos' );

		$this->WP_Widget( 'dox_wid_search_autos', __('DOX: Search Autos', 'autotrader'), $widget_ops, $control_ops );
     }

     function widget($args, $instance) {
		extract( $args );
		$title= $instance['title'];
		$random_nr = rand(1, 99999999999); 		

		global $dox_options;
		
		// Start widget
		echo $before_widget;  ?>
		
			<h3><?php if ( $title ) echo $title; ?></h3>
			<div class="search-autos-box">
				<form id="searchAutosBox<?php echo $random_nr ?>" action="<?php echo dox_get_search_autos_results_page(); ?>" method="post">
					
					<?php if ($dox_options['ad_set']['condition']['show'] == 'true' && $dox_options['ad_set']['condition']['search'] == 'true'  ) { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['condition']['base']; ?>"><?php echo $dox_options['ad_set']['condition']['name']; ?></label>
						<select name="<?php echo $dox_options['ad_set']['condition']['base']; ?>[]" id="<?php echo $dox_options['ad_set']['condition']['base']; ?>"><?php dox_get_dd_terms( $dox_options['ad_set']['condition']['query'], 0,0, sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['condition']['name'] ) ); ?></select>
					</div>
					<?php } ?>						
					
					<?php if ($dox_options['ad_set']['model']['show'] == 'true' && $dox_options['ad_set']['model']['search'] == 'true') { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['model']['base']; ?>"><?php echo $dox_options['ad_set']['model']['name']; ?></label>
						<select name="<?php echo $dox_options['ad_set']['model']['base']; ?>[]" id="<?php echo $dox_options['ad_set']['model']['base']; ?>"><?php dox_get_dd_terms( $dox_options['ad_set']['model']['query'], 0,0, sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['model']['name'] ) ); ?></select>
					</div>
					
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>"><?php echo $dox_options['ad_set']['model']['sub']; ?></label>							
						<select name="<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>[]" id="<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>" disabled="disabled" ></select>
					</div>
					<?php } ?>
					
					<?php if ($dox_options['ad_set']['location']['show'] == 'true' && $dox_options['ad_set']['location']['search'] == 'true') { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['location']['base']; ?>"><?php echo $dox_options['ad_set']['location']['name']; ?></label>
						<select name="<?php echo $dox_options['ad_set']['location']['base']; ?>[]" id="<?php echo $dox_options['ad_set']['location']['base']; ?>"><?php dox_get_dd_terms( $dox_options['ad_set']['location']['query'], 0,0, sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['location']['name'] ) ); ?></select>
					</div>
					
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>"><?php echo $dox_options['ad_set']['location']['sub']; ?></label>
						<select name="<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>[]" id="<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>" disabled="disabled" ></select>
					</div>
					<?php } ?>

					<?php if ($dox_options['ad_set']['year']['show'] == 'true' && $dox_options['ad_set']['year']['search'] == 'true') { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['year']['base']; ?>"><?php echo $dox_options['ad_set']['year']['name']; ?></label>
						<select name="ad<?php echo $dox_options['ad_set']['year']['base']; ?>[]" id="ad<?php echo $dox_options['ad_set']['year']['base']; ?>"><?php dox_get_dd_terms( $dox_options['ad_set']['year']['query'], 0,0, sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['year']['name'] ) ); ?></select>
					</div>
					<?php } ?>						
					
					<?php if ($dox_options['ad_set']['color']['show'] == 'true' && $dox_options['ad_set']['color']['search'] == 'true') { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['color']['base']; ?>"><?php echo $dox_options['ad_set']['color']['name']; ?></label>
						<select name="<?php echo $dox_options['ad_set']['color']['base']; ?>[]" id="<?php echo $dox_options['ad_set']['color']['base']; ?>"><?php dox_get_dd_terms( $dox_options['ad_set']['color']['query'], 0,0, sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['color']['name'] ) ); ?></select>
					</div>
					<?php } ?>						
					
					<?php if ($dox_options['ad_set']['fuelType']['show'] == 'true' && $dox_options['ad_set']['fuelType']['search'] == 'true') { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['fuelType']['base']; ?>"><?php echo $dox_options['ad_set']['fuelType']['name']; ?></label>
						<select name="<?php echo $dox_options['ad_set']['fuelType']['base']; ?>[]" id="<?php echo $dox_options['ad_set']['fuelType']['base']; ?>"><?php dox_get_dd_terms( $dox_options['ad_set']['fuelType']['query'], 0,0, sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['fuelType']['name'] ) ); ?></select>
					</div>
					<?php } ?>	

					<?php if ($dox_options['ad_set']['bodyType']['show'] == 'true' && $dox_options['ad_set']['bodyType']['search'] == 'true') { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['bodyType']['base']; ?>"><?php echo $dox_options['ad_set']['bodyType']['name']; ?></label>
						<select name="<?php echo $dox_options['ad_set']['bodyType']['base']; ?>[]" id="<?php echo $dox_options['ad_set']['bodyType']['base']; ?>"><?php dox_get_dd_terms( $dox_options['ad_set']['bodyType']['query'], 0,0, sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['bodyType']['name'] ) ); ?></select>
					</div>
					<?php } ?>	

					<?php if ($dox_options['ad_set']['transmission']['show'] == 'true' && $dox_options['ad_set']['transmission']['search'] == 'true') { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['transmission']['base']; ?>"><?php echo $dox_options['ad_set']['transmission']['name']; ?></label>
						<select name="<?php echo $dox_options['ad_set']['transmission']['base']; ?>[]" id="<?php echo $dox_options['ad_set']['transmission']['base']; ?>"><?php dox_get_dd_terms( $dox_options['ad_set']['transmission']['query'], 0,0, sprintf( __('Select %s', 'autotrader'), $dox_options['ad_set']['transmission']['name'] ) ); ?></select>
					</div>
					<?php } ?>						
					
					<?php if ($dox_options['ad_set']['cylinders']['show'] == 'true' && $dox_options['ad_set']['cylinders']['search'] == 'true') { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['cylinders']['base']; ?>-min"><?php echo $dox_options['ad_set']['cylinders']['name']; ?></label>							
						<input type="text" name="<?php echo $dox_options['ad_set']['cylinders']['base']; ?>-min" id="<?php echo $dox_options['ad_set']['cylinders']['base']; ?>-min" size="9"/>
						<span class="to"><?php _e('to', 'autotrader'); ?></span>
						<input type="text" name="<?php echo $dox_options['ad_set']['cylinders']['base']; ?>-max" id="<?php echo $dox_options['ad_set']['cylinders']['base']; ?>-max" size="9"/>
					</div>
					<?php } ?>

					<?php if ($dox_options['ad_set']['doors']['show'] == 'true' && $dox_options['ad_set']['doors']['search'] == 'true') { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['doors']['base']; ?>-min"><?php echo $dox_options['ad_set']['doors']['name']; ?></label>							
						<input type="text" name="<?php echo $dox_options['ad_set']['doors']['base']; ?>-min" id="<?php echo $dox_options['ad_set']['doors']['base']; ?>-min" size="9"/>
						<span class="to"><?php _e('to', 'autotrader'); ?></span>
						<input type="text" name="<?php echo $dox_options['ad_set']['doors']['base']; ?>-max" id="<?php echo $dox_options['ad_set']['doors']['base']; ?>-max" size="9"/>
					</div>
					<?php } ?>

					<?php if ($dox_options['ad_set']['mileage']['show'] == 'true' && $dox_options['ad_set']['mileage']['search'] == 'true') { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['mileage']['base']; ?>-min"><?php echo $dox_options['ad_set']['mileage']['name']; ?></label>							
						<input type="text" name="<?php echo $dox_options['ad_set']['mileage']['base']; ?>-min" id="<?php echo $dox_options['ad_set']['mileage']['base']; ?>-min" size="9"/>
						<span class="to"><?php _e('to', 'autotrader'); ?></span>
						<input type="text" name="<?php echo $dox_options['ad_set']['mileage']['base']; ?>-max" id="<?php echo $dox_options['ad_set']['mileage']['base']; ?>-max" size="9"/>
					</div>
					<?php } ?>					
					
					<?php if ($dox_options['ad_set']['price']['show'] == 'true' && $dox_options['ad_set']['price']['search'] == 'true') { ?>
					<div class="form-input clearfix">
						<label for="<?php echo $dox_options['ad_set']['price']['base']; ?>-min"><?php echo $dox_options['ad_set']['price']['name']; ?></label>							
						<input type="text" name="<?php echo $dox_options['ad_set']['price']['base']; ?>-min" id="<?php echo $dox_options['ad_set']['price']['base']; ?>-min" size="9"/>
						<span class="to"><?php _e('to', 'autotrader'); ?></span>
						<input type="text" name="<?php echo $dox_options['ad_set']['price']['base']; ?>-max" id="<?php echo $dox_options['ad_set']['price']['base']; ?>-max" size="9"/>
					</div>
					<?php } ?>

					<div class="form-input clearfix">
						<input type="hidden" name="auto_search" id="auto_search" value="true" />
						<input type="submit" id="searchAutosBoxButton"name="searchAutosBoxButton" value="<?php _e('Search','autotrader'); ?>" />
						<a href="<?php echo dox_get_search_autos_page(); ?>" class="advancedSearch"><?php _e('Advanced Search','autotrader'); ?></a>
					</div>
					
				</form>
			</div>
			
		<?php echo $after_widget; ?>
		
			<script type="text/javascript">

				var $j = jQuery.noConflict();
				
				$j(document).ready(function(){
					
					<?php if ($dox_options['ad_set']['model']['show'] == 'true') { ?>	
					function fill_dd_model() {
						$j("#searchAutosBox<?php echo $random_nr ?> #<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>").empty();
						
						var $make_id = $j("#searchAutosBox<?php echo $random_nr ?> #<?php echo $dox_options['ad_set']['model']['base']; ?>").val();

						
						$j.ajax({
							type    : 'POST',
							url     : '<?php echo admin_url('admin-ajax.php'); ?>',
							data    : { action : 'dox_get_model', make_id: $make_id, sel_text: true },
							success : function(response) {
								$j("#searchAutosBox<?php echo $random_nr ?> #<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>").removeAttr("disabled");
								$j("#searchAutosBox<?php echo $random_nr ?> #<?php echo $dox_options['ad_set']['model']['base'].'sub'; ?>").append(response);					
							}						
						});				
					
					}
					
					/* if make changed */
					$j("#searchAutosBox<?php echo $random_nr ?> #<?php echo $dox_options['ad_set']['model']['base']; ?>").change(function () {
						fill_dd_model();			
					});	
					<?php } ?>	
					
					<?php if ($dox_options['ad_set']['location']['show'] == 'true') { ?>
					function fill_dd_cities() {
						$j("#searchAutosBox<?php echo $random_nr ?> #<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>").empty();
						
						var $location_id = $j("#searchAutosBox<?php echo $random_nr ?> #<?php echo $dox_options['ad_set']['location']['base']; ?>").val();
						
						$j.ajax({
							type    : 'POST',
							url     : '<?php echo admin_url('admin-ajax.php'); ?>',
							data    : { action : 'dox_get_city', location_id: $location_id, sel_text: true },
							success : function(response) {
								$j("#searchAutosBox<?php echo $random_nr ?> #<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>").removeAttr("disabled");
								$j("#searchAutosBox<?php echo $random_nr ?> #<?php echo $dox_options['ad_set']['location']['base'].'sub'; ?>").append(response);					
							}						
						});				
					
					}					
		
					/* if location changed */
					$j("#searchAutosBox<?php echo $random_nr ?> #<?php echo $dox_options['ad_set']['location']['base']; ?>").change(function () {
						fill_dd_cities();			
					});
					<?php } ?>	
		
				})						  
			</script>		
		
<?php }

     function update($new_instance, $old_instance) {
       $instance = $old_instance;
	   $instance['title'] = $new_instance['title'];   
	   
		return $instance;
     }

     function form($instance) {
	 
		$defaults = array(
			'title' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'autotrader') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
				
		<?php
     }
}

register_widget('dox_wid_search_autos');

?>
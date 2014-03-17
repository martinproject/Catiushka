<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<?php global $dox_options; ?>
<head profile="http://gmpg.org/xfn/11">
	<title><?php wp_title('|', 1, 'right'); ?><?php bloginfo('name'); ?></title>
	
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="description" content="<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>" />

	<link rel="shortcut icon" href="<?php echo $dox_options['general']['favicon_url']; ?>" type="image/x-icon" />
		
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	
	<?php wp_head(); ?>	
	
	
	<script type="text/javascript">		
		jQuery(document).ready(function() { 
				
				<!-- Superfish -->
				jQuery('.navigation ul').superfish({ 
					delay: 200,
					animation: {opacity:'show',height:'show'},
					speed: 500,
					autoArrows: false,
					dropShadows: false
				});
				
				var $j = jQuery.noConflict();
				
				<!-- TopPanel -->
				$j("#topPanel .panel-tab").click(function(){
					$j("#topPanel .panel").slideToggle(300);	
				});
				
				<!-- Alert -->
				$j(".alert").delay(5000).slideUp(350);

				
			});		
	</script>	
	
	<?php if ( is_singular() ) { ?>
		<!-- Facebook Like Button -->
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) {return;}
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>

		<!-- Google+ Button -->
		<script type="text/javascript">
		  (function() {
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		  })();
		</script>	
	<?php } // endif - is_single() ?>
	
	<?php echo stripslashes( $dox_options['general']['analytics_code'] ); ?>	
</head>

<body <?php body_class(); ?>>

<?php get_template_part( 'top-panel' ); ?>

<!-- #header -->
<div id="header" class="container">
	<div class="container_12 clearfix">
		<div class="grid_4"><div id="logo"><h1><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1></div></div>
		<div class="grid_8"><?php if ( has_nav_menu( 'nav-menu' ) ) { wp_nav_menu( 'theme_location=nav-menu&container_class=navigation&menu_class=clearfix&depth=3' ); } ?></div>
	</div> 
	<div class="clear"></div>	
</div>
<div class="clear"></div>
<!-- end - #header -->
<?php global $dox_options; ?>
<!-- #footer -->
<div id="footer" class="container">
	<div class="container_12 widget-area clearfix">
		<div class="grid_4 alpha">
			<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer Left') ) ?>
		</div>
		<div class="grid_4">
			<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer Center') ) ?>
		</div>		
		<div class="grid_4 omega">
			<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer Right') ) ?>
		</div>
	</div>	
</div>
<div class="clear"></div>
<!-- end - #footer -->

<!-- #footer-contact-info -->
<div id="footer-contact-info" class="container">
	<div class="container_12 contact clearfix">
		<div class="grid_12 contact-info alpha">
			<ul>
			
				<?php 
					if ($dox_options['footer']['address']) { echo '<li class="address">'.$dox_options['footer']['address'].'</li>'; }
					if ($dox_options['footer']['phone']) { echo '<li class="tel">'.$dox_options['footer']['phone'].'</li>'; }
					if ($dox_options['footer']['email']) { echo '<li class="email"><a href="mailto:'.$dox_options['footer']['email'].'">'.$dox_options['footer']['email'].'</a></li>'; }
					if ($dox_options['footer']['twitter']) { echo '<li class="twitter"><a href="http://twitter.com/'.$dox_options['footer']['twitter'].'" target="_blank" >'.__('Follow Us', 'autotrader').'</a></li>'; } 
					if ($dox_options['footer']['facebook']) { echo '<li class="facebook"><a href="http://facebook.com/'.$dox_options['footer']['facebook'].'" target="_blank" >'.__('Facebook', 'autotrader').'</a></li>'; }				
				?>
			</ul>
		</div>		
	</div>
</div>
<div class="clear"></div>
<!-- end - #footer-contact-info -->

<!-- #footer-bottom-->
<div id="footer-bottom" class="container">
	<div class="container_12 contact clearfix">
		<div class="grid_8 footer-menu alpha">
			<?php if ( has_nav_menu( 'footer-menu' ) ) { wp_nav_menu( 'theme_location=footer-menu&container_class=footer-nav&menu_class=clearfix&depth=1' ); } ?>
		</div>	
		<div class="grid_4 footer-notice omega">
			<?php if ($dox_options['footer']['notice']) { echo stripslashes($dox_options['footer']['notice']); } ?>
		</div>		
	</div>
</div>
<div class="clear"></div>
<!-- end - #footer-bottom -->

<?php wp_footer(); ?>

</body>
</html>
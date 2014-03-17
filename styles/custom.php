<?php 

	$wp_root = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
	if (file_exists( $wp_root[0] . 'wp-load.php' )) require_once( $wp_root[0] . 'wp-load.php' );
	elseif (file_exists( $wp_root[0] . 'wp-config.php' )) require_once( $wp_root[0] . 'wp-config.php' );

	global $dox_options; 
	
	
	$textShadowColor = $dox_options['color']['general']['textShadow'];
	$textShadowOpacity = $dox_options['color']['general']['textShadowOpacity'];

	$headerBG = $dox_options['color']['header']['backgroundRGB'];
	$headerBGOpacity = $dox_options['color']['header']['backgroundA'];	
	
	$imageZoomBG = $dox_options['color']['home']['imageZoomBackgroundRGB'];
	$imageZoomBGOpacity = $dox_options['color']['home']['imageZoomBackgroundA'];

	$footerBG = $dox_options['color']['footer']['backgroundRGB'];
	$footerBGOpacity = $dox_options['color']['footer']['backgroundA'];
	$footer2BG = $dox_options['color']['footer']['infoBackgroundRGB'];
	$footer2BGOpacity = $dox_options['color']['footer']['infoBackgroundA'];	
	$footer3BG = $dox_options['color']['footer']['bottomBackgroundRGB'];
	$footer3BGOpacity = $dox_options['color']['footer']['bottomBackgroundA'];		
	
	function dox_rgba($hexColor, $opacity) {
		$color = array();
		$color = dox_hex_dec($hexColor);
		
		return 'rgba('.$color[0].', '.$color[1].', '.$color[2].', '.$opacity.')';
	}

	function dox_hex_dec($hexColor) {
		
		$color = array();
		$color[] = hexdec(substr($hexColor, 0, 2));
		$color[] = hexdec(substr($hexColor, 2, 2));
		$color[] = hexdec(substr($hexColor, 4, 2));
		
		return $color;
	}
	
	
	header("Content-type: text/css");

?>

/*---------------------------------------------------------------------------*/
/* General styles
/*---------------------------------------------------------------------------*/
body{ 
	color: #<?php echo $dox_options['color']['general']['color']; ?>;
	background-color: #<?php echo $dox_options['color']['general']['background']; ?>;
}

h1, h2, h3, h4, h5, h6 {
	color: #<?php echo $dox_options['color']['general']['sectionTitle']; ?>;
}

.page-title {  
	color: #<?php echo $dox_options['color']['general']['sectionTitle']; ?>;
	text-shadow: 1px 1px 0px <?php echo dox_rgba($textShadowColor, $textShadowOpacity ); ?>;
	border-bottom: 1px solid #<?php echo $dox_options['color']['general']['pageTitleBorder']; ?>;
}

.section-title { 
	color: #<?php echo $dox_options['color']['general']['sectionTitle']; ?>;
}

.section-line { border-bottom: 1px solid #<?php echo $dox_options['color']['general']['sectionTitleBorder']; ?>; }
 
a { 
	color: #<?php echo $dox_options['color']['general']['link']; ?>; 		
}

a:hover { color: #<?php echo $dox_options['color']['general']['linkHover']; ?>; }
 

input[type="text"],
input[type="password"] { 
	color: #<?php echo $dox_options['color']['general']['formElementColor']; ?>;
	border: 1px solid #<?php echo $dox_options['color']['general']['formElementBorder']; ?>;	
}
 
select { 
	color: #<?php echo $dox_options['color']['general']['formElementColor']; ?>;
	border: 1px solid #<?php echo $dox_options['color']['general']['formElementBorder']; ?>;	
}

textarea { 
	color: #<?php echo $dox_options['color']['general']['formElementColor']; ?>;
	border: 1px solid #<?php echo $dox_options['color']['general']['formElementBorder']; ?>; 	
 } 

.button, input[type="submit"], button {
	color: #<?php echo $dox_options['color']['general']['buttonColor']; ?> !important;
	background: #<?php echo $dox_options['color']['general']['buttonBackground']; ?>;
}

	.button:hover, input[type="submit"]:hover, button:hover {
		background: #<?php echo $dox_options['color']['general']['buttonHoverBackground']; ?>;
		color: #<?php echo $dox_options['color']['general']['buttonHoverColor']; ?> !important;
	}

#topPanel {
	color: #<?php echo $dox_options['color']['topPanel']['color']; ?>;
} 

#topPanel .panel {
	background-color: #<?php echo $dox_options['color']['topPanel']['background']; ?>;

    -webkit-box-shadow: 0px 1px 0px rgba(1,0,0,0.2);
	-moz-box-shadow: 0px 1px 0px rgba(1,0,0,0.2);
	box-shadow: 0px 1px 0px rgba(1,0,0,0.2);	
}

#topPanel .panel .panel-title { 
	color: #<?php echo $dox_options['color']['topPanel']['title']; ?>;
	border-bottom: 1px solid #<?php echo $dox_options['color']['topPanel']['titleBorder']; ?>;
}

#topPanel a { 
	color: #<?php echo $dox_options['color']['topPanel']['link']; ?>;
}

#topPanel .panel input[type="text"],
#topPanel .panel input[type="password"] { 
	border: 1px solid #<?php echo $dox_options['color']['topPanel']['formElementBorder']; ?>;	
 }
 
 #topPanel .panel .button, 
 #topPanel .panel input[type="submit"], 
 #topPanel .panel button {
 	color: #<?php echo $dox_options['color']['topPanel']['buttonColor']; ?>;
	border: 1px solid #<?php echo $dox_options['color']['topPanel']['formElementBorder']; ?>;
	background: #<?php echo $dox_options['color']['topPanel']['buttonBackground']; ?>;

 }

#topPanel .panel .button:hover, 
#topPanel .panel input[type="submit"]:hover, 
#topPanel .panel button:hover {
 	color: #<?php echo $dox_options['color']['topPanel']['buttonHoverColor']; ?>;
	background: #<?php echo $dox_options['color']['topPanel']['buttonHoverBackground']; ?>;
}
	
	
#topPanel .panel-tab {
    -webkit-box-shadow: 0px 1px 0px rgba(0,0,0,0.2);
	-moz-box-shadow: 0px 1px 0px rgba(0,0,0,0.2);
	box-shadow: 0px 1px 0px rgba(0,0,0,0.2);	
}

#topPanel .panel-tab h4 {
	color: #<?php echo $dox_options['color']['topPanel']['color']; ?>;
	background-color: #<?php echo $dox_options['color']['topPanel']['background']; ?>;
}

 
#header {
	border-top: 5px solid #<?php echo $dox_options['color']['header']['borderTop']; ?>;
	border-bottom: 1px solid #<?php echo $dox_options['color']['header']['borderBottom']; ?>;
	background-color: #<?php echo $dox_options['color']['header']['background']; ?>;
	background-color: <?php echo dox_rgba($headerBG, $headerBGOpacity ); ?>;
 }
 
 
.navigation ul a { color: #<?php echo $dox_options['color']['header']['navLink']; ?>; }
.navigation ul a:hover { color: #<?php echo $dox_options['color']['header']['navLinkHover']; ?>; }

.navigation ul li ul { 
	background-color: #<?php echo $dox_options['color']['header']['navBackground']; ?>; 
	border: 1px solid #<?php echo $dox_options['color']['header']['navBorder']; ?>; 
	border-top: 2px solid #<?php echo $dox_options['color']['header']['navLinkHover']; ?>;
    -webkit-box-shadow: 0px 1px 2px rgba(0,0,0,0.2);
	-moz-box-shadow: 0px 1px 2px rgba(0,0,0,0.2);
	box-shadow: 0px 1px 2px rgba(0,0,0,0.2);
}


.tj_nav .tj_prev  {
	background: #<?php echo $dox_options['color']['home']['slideNavBackground']; ?> url(../images/icon-set.png) no-repeat 2px -18px;
}

.tj_nav .tj_next  {
	background: #<?php echo $dox_options['color']['home']['slideNavBackground']; ?> url(../images/icon-set.png) no-repeat 2px 2px;
}

.tj_nav span:hover  {
	background-color: #<?php echo $dox_options['color']['home']['slideNavHoverBackground']; ?>;
}

#googleMap { border: 1px solid #<?php echo $dox_options['color']['general']['formElementBorder']; ?>;	}

.browser-cat h5 { color: #<?php echo $dox_options['color']['home']['browseCatTitle']; ?>; border-bottom: 1px solid #<?php echo $dox_options['color']['home']['browseCatTitle']; ?>; }
.browser-cat ul li { border-bottom: 1px dotted #<?php echo $dox_options['color']['home']['browseCatBorder']; ?>; }


#homeSearch {
	background-color: #<?php echo $dox_options['color']['home']['searchBackground']; ?>;
	border: 1px solid #<?php echo $dox_options['color']['home']['searchBorder']; ?>;
}

a.image-zoom:hover span.zoom-icon {
	background: #<?php echo $dox_options['color']['home']['imageZoomBackground']; ?> url(../images/zoom.png) no-repeat;
	background-color: <?php echo dox_rgba($imageZoomBG, $imageZoomBGOpacity ); ?>;
}

a.small-thumb-zoom:hover span.zoom-icon {
	background: #<?php echo $dox_options['color']['home']['imageZoomBackground']; ?> url(../images/zoom32.png) no-repeat;
	background-color: <?php echo dox_rgba($imageZoomBG, $imageZoomBGOpacity ); ?>;
}

a.slide-thumb-zoom:hover span.zoom-icon {
	background: #<?php echo $dox_options['color']['home']['imageZoomBackground']; ?> url(../images/zoom32.png) no-repeat;
	background-color: <?php echo dox_rgba($imageZoomBG, $imageZoomBGOpacity ); ?>;
}

.dealer-data {
	border-bottom: 1px dotted #<?php echo $dox_options['color']['home']['browseCatBorder']; ?>;
}

.dealer-data label.sub-title { 
	text-shadow: 0px -1px 0px <?php echo dox_rgba($textShadowColor, $textShadowOpacity ); ?>;
	border-bottom: 1px solid #<?php echo $dox_options['color']['home']['browseCatBorder']; ?>;
}

/*---------------------------------------------------------------------------*/
/* Content
/*---------------------------------------------------------------------------*/
#content .post h3.title { color: #<?php echo $dox_options['color']['content']['link']; ?>; }

#content .custom-post-type .watchlist-button-single { 
	text-shadow: 0px -1px 0px <?php echo dox_rgba($textShadowColor, $textShadowOpacity ); ?>;;
	background: #<?php echo $dox_options['color']['content']['pagerLink']; ?>;
}

#content .custom-post-type .watchlist-button-single:hover { 
 	color: #<?php echo $dox_options['color']['topPanel']['buttonHoverColor']; ?>;
	background: #<?php echo $dox_options['color']['topPanel']['buttonHoverBackground']; ?>;	
}

#content .custom-post-type .auto-photos .post-thumbs .thumb-container {
	background-color: #<?php echo $dox_options['color']['content']['thumbContainerBackground']; ?>;
}

#content .custom-post-type .auto-photos .post-thumbs .thumb-container .tj_nav span  {
	color: #<?php echo $dox_options['color']['content']['metaColor']; ?>;
}


#content .custom-post-type .auto-photos .post-thumbs .thumb-container .tj_nav .tj_prev  {
	background: #<?php echo $dox_options['color']['home']['slideNavBackground']; ?> url(../images/icon-set.png) no-repeat 2px -18px;
}

#content .custom-post-type .auto-photos .post-thumbs .thumb-container .tj_nav .tj_next  {
	background: #<?php echo $dox_options['color']['home']['slideNavBackground']; ?> url(../images/icon-set.png) no-repeat 2px 2px;
}

#content .custom-post-type .auto-photos .post-thumbs .thumb-container .tj_nav span:hover  {
	color: #<?php echo $dox_options['color']['home']['pagerLink']; ?>;
	background-color: #<?php echo $dox_options['color']['home']['slideNavHoverBackground']; ?>;
}

#content .custom-post-type .seller-info ul li {
	border-bottom: 1px dotted #<?php echo $dox_options['color']['home']['itemBorder']; ?>;
}

#content .custom-post-type .seller-info ul li span {
	text-shadow: 0px -1px 0px <?php echo dox_rgba($textShadowColor, $textShadowOpacity ); ?>;
}

#content .custom-post-type .auto-features {
	background-color: #<?php echo $dox_options['color']['content']['featuresBlockBackground']; ?>;
}

#content .custom-post-type .auto-features h4.section-title  {
	color: #<?php echo $dox_options['color']['content']['pagerLink']; ?> !important;
}

#content .custom-post-type .auto-features ul li {
	border-bottom: 1px dotted #<?php echo $dox_options['color']['home']['itemBorder']; ?>;
}

#content .custom-post-type .auto-features ul li span {
	text-shadow: 0px -1px 0px <?php echo dox_rgba($textShadowColor, $textShadowOpacity ); ?>;
}

#content .post, #content .page, #search-results .custom-post-type { border-bottom: 1px solid #<?php echo $dox_options['color']['home']['widgetTitleBorder']; ?>; }
.dox-template .page { border: none !important; }
#content .post .blog-title, #content .page .blog-title, #search-results .custom-post-type .blog-title { color: #<?php echo $dox_options['color']['content']['link']; ?>; }
#content .post .post-meta-data span, #content .page .post-meta-data span, #search-results .custom-post-type .post-meta-data span { text-shadow: 0px -1px 0px <?php echo dox_rgba($textShadowColor, $textShadowOpacity ); ?>; }

	/* paging */
	#content .dox_pager {
		background-color: #<?php echo $dox_options['color']['content']['pagerBackground']; ?>;
		border-bottom: 3px solid #<?php echo $dox_options['color']['content']['pagerBorder']; ?>;
		text-shadow: 0px -1px 0px <?php echo dox_rgba($textShadowColor, $textShadowOpacity ); ?>;
	}
	
	#content .dox_pager  ul li { border-right: 2px solid #<?php echo $dox_options['color']['content']['pagerItemBorder']; ?>; }
	#content .dox_pager span { border-right: 2px solid #<?php echo $dox_options['color']['content']['pagerItemBorder']; ?>; }
	#content .dox_pager  span.bla { border-right: 2px solid #<?php echo $dox_options['color']['content']['pagerItemBorder']; ?>; }
	#content .dox_pager  li.current a { color: #<?php echo $dox_options['color']['content']['pagerLink']; ?> !important; }

	#content .dox_pager li.current,
	#content .dox_pager ul li:hover { background-color: #<?php echo $dox_options['color']['content']['pagerBorder']; ?>; }
	
	
#content .post a,
#content .page a,
#content .post .blog-title a,
#content .page .blog-title a { 
	color: #<?php echo $dox_options['color']['content']['link']; ?>; 	
}

#content .post a:hover,
#content .page a:hover,
#content .post .blog-title a:hover,
#content .page .blog-title a:hover  { color: #<?php echo $dox_options['color']['content']['linkHover']; ?>; }

#content .post .entry-content blockquote, #content .page .entry-content blockquote { border: 1px solid #<?php echo $dox_options['color']['content']['blockquoteBorder']; ?>; }
#content .post .entry-content pre, #content .page .entry-content pre  { width: 80%; border: 1px solid #<?php echo $dox_options['color']['content']['blockquoteBorder']; ?>; }

/*---------------------------------------------------------------------------*/
/* Comments
/*---------------------------------------------------------------------------*/	
#comments  .comment-title,
#respond  .comment-title { color: #<?php echo $dox_options['color']['content']['link']; ?>; }

#comments { border-bottom: 1px dotted #<?php echo $dox_options['color']['home']['itemBorder']; ?>; }
#respond { border-bottom: 1px dotted #<?php echo $dox_options['color']['home']['itemBorder']; ?>; }

#comments .comment { border-top: 1px dotted #<?php echo $dox_options['color']['home']['itemBorder']; ?>; }

#comments .comment-reply a,
#respond .cancel-comment-reply a {
	color: #<?php echo $dox_options['color']['listing']['buttonColor']; ?>;
	background: #<?php echo $dox_options['color']['listing']['buttonBackground']; ?>;	
	text-shadow: 0px -1px 0px <?php echo dox_rgba($textShadowColor, $textShadowOpacity ); ?>;;	
}

#comments .comment-reply a:hover,
#respond .cancel-comment-reply a:hover {
		background: #<?php echo $dox_options['color']['general']['buttonHoverBackground']; ?>;
		color: #<?php echo $dox_options['color']['general']['buttonHoverColor']; ?> !important;
}

#comments .children .comment { border-top: 1px dotted #<?php echo $dox_options['color']['home']['itemBorder']; ?>; }

#comments .not-approved { color: #<?php echo $dox_options['color']['content']['linkHover']; ?>; }

/*---------------------------------------------------------------------------*/
/* Widgets
/*---------------------------------------------------------------------------*/	

.widget h3 { 
	color: #<?php echo $dox_options['color']['content']['link']; ?>;
	text-shadow: 1px 1px 0px <?php echo dox_rgba($textShadowColor, $textShadowOpacity ); ?>;
	border-bottom: 1px solid #<?php echo $dox_options['color']['content']['widgetTitleBorder']; ?>;	
}

.widget ul li { border-bottom: 1px dotted #<?php echo $dox_options['color']['home']['itemBorder']; ?>; }


.dox_wid_show_posts ul { border-bottom: 1px dotted #<?php echo $dox_options['color']['content']['widgetPostItemBorder']; ?>; }
.dox_wid_show_posts span.post-date { color: #<?php echo $dox_options['color']['content']['metaColor']; ?>; }
.dox_wid_show_posts span.ad-price { color: #<?php echo $dox_options['color']['content']['metaColor']; ?>; }


.search-autos-box {
	background-color: #<?php echo $dox_options['color']['home']['searchBackground']; ?>;
	border: 1px solid #<?php echo $dox_options['color']['home']['searchBorder']; ?>;	
}

#topPanel .panel .widget h3 { 
	color: #<?php echo $dox_options['color']['topPanel']['title']; ?>;
	border-bottom: 1px solid #<?php echo $dox_options['color']['topPanel']['titleBorder']; ?>;	
}


#footer .widget ul li { border-bottom: 1px dotted #<?php echo $dox_options['color']['footer']['itemBorder']; ?>; }
#footer .dox_wid_show_posts ul { border-bottom: 1px dotted #<?php echo $dox_options['color']['content']['widgetPostItemBorder']; ?>; }

/*---------------------------------------------------------------------------*/
/* Footer
/*---------------------------------------------------------------------------*/
#footer {
	border-top: 4px solid #<?php echo $dox_options['color']['footer']['borderTop']; ?>;
	background-color: #<?php echo $dox_options['color']['footer']['background']; ?>;
	background-color: <?php echo dox_rgba($footerBG, $footerBGOpacity ); ?>;
}

#footer-contact-info {
	color: #<?php echo $dox_options['color']['footer']['color']; ?>;
	background-color: #<?php echo $dox_options['color']['footer']['infoBackground']; ?>;
	background-color: <?php echo dox_rgba($footer2BG, $footer2BGOpacity ); ?>;
}

#footer-contact-info a { 
	color: #<?php echo $dox_options['color']['footer']['link']; ?>; 	
}

#footer-contact-info a:hover { color: #<?php echo $dox_options['color']['footer']['linkHover']; ?>; }


#footer-contact-info ul li.address {
	background: transparent url(../images/icon-set.png) no-repeat 0px -142px;
}

#footer-contact-info ul li.tel {
	background: transparent url(../images/icon-set.png) no-repeat 0px -162px;
}

#footer-contact-info ul li.email {
	background: transparent url(../images/icon-set.png) no-repeat 0px -118px;
}

#footer-contact-info ul li.twitter {
	background: transparent url(../images/icon-set.png) no-repeat 0px -182px;
}

#footer-contact-info ul li.facebook {
	background: transparent url(../images/icon-set.png) no-repeat 0px -202px;
}

#footer-bottom {
	color: #<?php echo $dox_options['color']['footer']['bottomColor']; ?>;
	text-transform: uppercase;
	background-color: #<?php echo $dox_options['color']['footer']['bottomBackground']; ?>;
	background-color: <?php echo dox_rgba($footer3BG, $footer3BGOpacity ); ?>;
}

#footer-bottom a { 
	color: #<?php echo $dox_options['color']['footer']['bottomLink']; ?>; 		
}

#footer-bottom a:hover { color: #<?php echo $dox_options['color']['footer']['linkHover']; ?>; }

/*---------------------------------------------------------------------------*/
/* Listing
/*---------------------------------------------------------------------------*/

.listing .custom-post-type {
	border-bottom: 1px solid #<?php echo $dox_options['color']['listing']['border']; ?>; 
}

	.listing .custom-post-type ul.features li {
		border-bottom: 1px dotted #<?php echo $dox_options['color']['content']['itemBorder']; ?>;
	}

	.listing .custom-post-type ul.features li span {
		text-shadow: 0px -1px 0px <?php echo dox_rgba($textShadowColor, $textShadowOpacity ); ?>;
	}


	.listing .custom-post-type ul.price li {
		color: #<?php echo $dox_options['color']['listing']['pagerColor']; ?>;
		text-shadow: 0px -1px 0px <?php echo dox_rgba($textShadowColor, $textShadowOpacity ); ?>;
	}

	/* button */
	.listing .custom-post-type .button {
		color: #<?php echo $dox_options['color']['listing']['buttonColor']; ?>;
		background: #<?php echo $dox_options['color']['listing']['buttonBackground']; ?>;
		text-shadow: 0px -1px 0px <?php echo dox_rgba($textShadowColor, $textShadowOpacity ); ?>;;
	}

		.listing .custom-post-type .button:hover {
			background: #<?php echo $dox_options['color']['general']['buttonHoverBackground']; ?>;
			color: #<?php echo $dox_options['color']['general']['buttonHoverColor']; ?> !important;
		}
		
	/* paging */
	.listing .dox_pager {
		color: #<?php echo $dox_options['color']['listing']['pagerColor']; ?>;
		background-color: #<?php echo $dox_options['color']['listing']['pagerBackground']; ?>;
		border-bottom: 3px solid #<?php echo $dox_options['color']['listing']['pagerBorder']; ?>;
		text-shadow: 0px -1px 0px <?php echo dox_rgba($textShadowColor, $textShadowOpacity ); ?>;
	}
	
	.listing .dox_pager  ul li { border-right: 2px solid #<?php echo $dox_options['color']['listing']['pagerItemBorder']; ?>; }
	.listing .dox_pager span { border-right: 2px solid #<?php echo $dox_options['color']['listing']['pagerItemBorder']; ?>; }
	.listing .dox_pager  span.bla { border-right: 2px solid #<?php echo $dox_options['color']['listing']['pagerItemBorder']; ?>; }
	.listing .dox_pager  li.current a { color: #<?php echo $dox_options['color']['listing']['pagerLink']; ?> !important; }

	.listing .dox_pager li.current,
	.listing .dox_pager ul li:hover { background-color: #<?php echo $dox_options['color']['listing']['pagerBorder']; ?>; }			

	/* sorting */
	.listing .items-sort{
		color: #<?php echo $dox_options['color']['listing']['pagerColor']; ?>;
		background-color: #<?php echo $dox_options['color']['listing']['pagerBackground']; ?>;
		border-bottom: 4px solid #<?php echo $dox_options['color']['listing']['pagerBorder']; ?>;
		text-shadow: 0px -1px 0px <?php echo dox_rgba($textShadowColor, $textShadowOpacity ); ?>;	
	}

		.listing .items-sort span { color: #<?php echo $dox_options['color']['listing']['pagerColor']; ?> !important; }
		
		.listing .items-sort span.delete-link a { color: #<?php echo $dox_options['color']['content']['metaColor']; ?>; }
		.listing .items-sort span.delete-link a:hover { color: #<?php echo $dox_options['color']['listing']['pagerLink']; ?>; }
	
/*---------------------------------------------------------------------------*/
/* cGrid
/*---------------------------------------------------------------------------*/
.cgrid{ 
	background-color: #<?php echo $dox_options['color']['grid']['background']; ?>; 
}

	/* Grid Header */
	.cgrid-header  ul li {
		text-shadow: 0px -1px 0px <?php echo dox_rgba($textShadowColor, $textShadowOpacity ); ?>;
		background-color: #<?php echo $dox_options['color']['grid']['headerBackground']; ?>;
		border-bottom: 4px solid #<?php echo $dox_options['color']['grid']['headerBorder']; ?>;
	}
	

	/* Grid Body */
	
	.cgrid-body  ul { 
		background-color: #<?php echo $dox_options['color']['grid']['background']; ?>;
	}
	
	.cgrid-body  ul:nth-child(2n+1) li { 
		background-color: #<?php echo $dox_options['color']['grid']['gridItemBackground']; ?>;
	}
	
	.cgrid-body  ul:nth-child(2n+2) li { 
		background-color: #<?php echo $dox_options['color']['grid']['gridItemBackgroundAlt']; ?>;
	}
	
	.cgrid-body  ul li {
		border-bottom: 1px solid #<?php echo $dox_options['color']['grid']['gridItemBorder']; ?>;
	}
	
	.cgrid .cgrid-link a { 
		color: #<?php echo $dox_options['color']['grid']['link']; ?>;
	}
	
	.cgrid .cgrid-link a:hover { 
		color: #<?php echo $dox_options['color']['grid']['linkHover']; ?>;
	}
	
	/* paging */
	.cgrid-paging .dox_pager {
		background-color: #<?php echo $dox_options['color']['grid']['headerBackground']; ?>;
		border-bottom: 3px solid #<?php echo $dox_options['color']['grid']['headerBorder']; ?>;
		text-shadow: 0px -1px 0px <?php echo dox_rgba($textShadowColor, $textShadowOpacity ); ?>;
	}
	
	.cgrid-paging .dox_pager  ul li { border-right: 2px solid #<?php echo $dox_options['color']['grid']['pagerBorder']; ?>; }
	.cgrid-paging .dox_pager span { border-right: 2px solid #<?php echo $dox_options['color']['grid']['pagerBorder']; ?>; }
	.cgrid-paging .dox_pager  span.bla { border-right: 2px solid #<?php echo $dox_options['color']['grid']['pagerBorder']; ?>; }
	.cgrid-paging .dox_pager  li.current a { color: #<?php echo $dox_options['color']['grid']['link']; ?> !important; }

	.cgrid-paging .dox_pager li.current,
	.cgrid-paging .dox_pager ul li:hover { background-color: #<?php echo $dox_options['color']['grid']['headerBorder']; ?>; }	
	

/*---------------------------------------------------------------------------*/
/* Step Form
/*---------------------------------------------------------------------------*/
.step-form { 
	background-color: #<?php echo $dox_options['color']['form']['background']; ?>; 
}

.step-form-alt {
	background-color: #<?php echo $dox_options['color']['form']['background']; ?>; 
}

	/* Step Form Wrapper */

	.step-form-wrap .form-input label.sub-title { 
		text-shadow: 0px -1px 0px <?php echo dox_rgba($textShadowColor, $textShadowOpacity ); ?>;
		border-bottom: 1px solid #<?php echo $dox_options['color']['form']['itemBorder']; ?>;
	}

	/* Step Form Navigation */
	.step-form-nav { float: left; width: 100%; }
	.step-form-nav ul { }
	.step-form-nav ul li {
		text-shadow: 0px -1px 0px <?php echo dox_rgba($textShadowColor, $textShadowOpacity ); ?>;
		background-color: #<?php echo $dox_options['color']['form']['navBackground']; ?>;
		border-bottom: 4px solid #<?php echo $dox_options['color']['form']['navBorder']; ?>;
	}

	.step-form-nav ul li span {
		background-color: #<?php echo $dox_options['color']['form']['navBorder']; ?>;
	}
	
	.step-form-nav ul li.selected { 
		background-color: #<?php echo $dox_options['color']['form']['selectedBackground']; ?>;
		border-bottom: 4px solid #<?php echo $dox_options['color']['form']['selectedBorder']; ?>;
	}
	
	.step-form-nav ul li.selected span { 
		background-color: #<?php echo $dox_options['color']['form']['selectedBorder']; ?>;
	}
	
	.step-form-nav ul li.step-error { 
		background-color: #<?php echo $dox_options['color']['form']['errorBackground']; ?>;
		border-bottom: 4px solid #<?php echo $dox_options['color']['form']['errorBorder']; ?>;
	}
	
	.step-form-nav ul li.step-error span { 
		background-color: #<?php echo $dox_options['color']['form']['errorBorder']; ?>;
	}

	.step-form-nav ul li.step-passed { 
		background-color: #<?php echo $dox_options['color']['form']['passedBackground']; ?>;
		border-bottom: 4px solid #<?php echo $dox_options['color']['form']['passedBorder']; ?>;
	}
	
	.step-form-nav ul li.step-passed span { 
		background-color: #<?php echo $dox_options['color']['form']['passedBorder']; ?>;
	}
	
	
.focus-required-error { border: 1px solid #<?php echo $dox_options['color']['form']['errorColor']; ?> !important; }	


/*---------------------------------------------------------------------------*/
/* Login Popup
/*---------------------------------------------------------------------------*/
.login-popup-mask { 
	background: #000000;
}

.login-popup {
	background-color: #efefef;
	border: 1px solid #999999;
	
	-webkit-box-shadow: 0px 2px 2px 0px #999999, 0px -2px 2px 0px #999999, 2px 0px 2px 0px #999999, -2px 0px 2px 0px #999999;
	   -moz-box-shadow: 0px 2px 2px 0px #999999, 0px -2px 2px 0px #999999, 2px 0px 2px 0px #999999, -2px 0px 2px 0px #999999;
		    box-shadow: 0px 2px 2px 0px #999999, 0px -2px 2px 0px #999999, 2px 0px 2px 0px #999999, -2px 0px 2px 0px #999999;
			
	z-index: 99999;
}

/*---------------------------------------------------------------------------*/
/* Alerts
/*---------------------------------------------------------------------------*/
.alert {
    -webkit-box-shadow: 0px 1px 1px rgba(0,0,0,0.1);
	-moz-box-shadow: 0px 1px 1px rgba(0,0,0,0.1);
	box-shadow: 0px 1px 1px rgba(0,0,0,0.1);	
}

.alert-success {
	color: #<?php echo $dox_options['color']['alert']['successColor']; ?>;		
	border-bottom: 1px solid #<?php echo $dox_options['color']['alert']['successBorder']; ?>;
	background-color: #<?php echo $dox_options['color']['alert']['successBackground']; ?>;
}

.alert-error {
	color: #<?php echo $dox_options['color']['alert']['errorColor']; ?>;		
	border-bottom: 1px solid #<?php echo $dox_options['color']['alert']['errorBorder']; ?>;
	background-color: #<?php echo $dox_options['color']['alert']['errorBackground']; ?>;
}

.alert-warning {
	color: #<?php echo $dox_options['color']['alert']['warningColor']; ?>;		
	border-bottom: 1px solid #<?php echo $dox_options['color']['alert']['warningBorder']; ?>;
	background-color: #<?php echo $dox_options['color']['alert']['warningBackground']; ?>;
}

.label-red {
	color: #<?php echo $dox_options['color']['alert']['labelRed']; ?>;		
}
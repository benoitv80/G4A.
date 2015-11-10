<?php
/**
 * @package Catch Themes
 * @subpackage Adventurous
 * @since Adventurous 1.0
 */

/**
 * Set the default values for all the settings. If no user-defined values
 * is available for any setting, these defaults will be used.
 */
global $adventurous_options_defaults;
$adventurous_options_defaults = array(
	'fav_icon'								=> get_template_directory_uri().'/images/favicon.ico',
 	'remove_favicon'						=> '1',
	'web_clip'								=> get_template_directory_uri().'/images/apple-touch-icon.png',
 	'remove_web_clip'						=> '1',
	'remove_header_logo'					=> '1',
	'featured_logo_header'					=> get_template_directory_uri().'/images/logo.png',
	'enable_promotion'						=> 'homepage',
	'homepage_headline'						=> __( 'Adventurous is a Simple, Clean and Responsive WordPress Theme', 'adventurous' ),
	'homepage_subheadline'					=> __( 'This is Promotion Headline. You can edit this from "Appearance => Theme Options => Promotion Headline Options"', 'adventurous' ),
	'homepage_headline_button'				=> __( 'Reviews', 'adventurous' ),
	'homepage_headline_url'					=> esc_url( 'http://wordpress.org/support/view/theme-reviews/adventurous' ),
	'homepage_headline_target'				=> '1',
	'reset_featured_image'					=> '2',
	'enable_featured_header_image'			=> 'homepage',
	'page_featured_image'					=> 'full',
	'featured_header_image_url'				=> '',
	'featured_header_image_alt'				=> '',
	'featured_header_image_base'			=> '0',
 	'disable_header_right_sidebar'			=> '0',
	'reset_typography'						=> '2',	
	'custom_css'							=> '',	
	'sidebar_layout'						=> 'right-sidebar',
	'content_layout'						=> 'full',
	'featured_image'						=> 'featured',
	'reset_layout'							=> '2',
	'more_tag_text'							=> __( 'Continue Reading &rarr;', 'adventurous' ),
	'reset_moretag'							=> '2',
	'excerpt_length'						=> 30,
 	'search_display_text'					=> __( 'Search &hellip;', 'adventurous' ),
	'disable_homepage_headline'				=> '0',
	'disable_homepage_subheadline'			=> '0',
	'disable_homepage_button'				=> '0',
	'enable-featured'						=> 'homepage',
	'homepage_featured_headline'			=> '',
	'homepage_featured_subheadline'			=> '',
	'homepage_featured_qty'					=> 4,
	'homepage_featured_layout'				=> 'four-columns',
	'homepage_featured_image'				=> array(),
	'homepage_featured_url'					=> array(),
	'homepage_featured_base'				=> array(),
	'homepage_featured_title'				=> array(),
	'homepage_featured_content'				=> array(),
	'enable_posts_home'						=> '0',
 	'front_page_category'					=> array(),
	'select_slider_type'					=> 'demo-slider',
	'enable_slider'							=> 'enable-slider-homepage',
	'disable_slider_text'					=> '1',
 	'featured_slider'						=> array(),
	'slider_category'						=> array(),
	'slider_qty'							=> 4,
 	'transition_effect'						=> 'fade',
 	'transition_delay'						=> 4,
 	'transition_duration'					=> 1,	
	'exclude_slider_post'					=> '0',
 	'social_facebook'						=> '',
 	'social_twitter'						=> '',
 	'social_googleplus'						=> '',
 	'social_pinterest'						=> '',
 	'social_youtube'						=> '',
 	'social_vimeo'							=> '',
 	'social_linkedin'						=> '',
 	'social_slideshare'						=> '',
 	'social_foursquare'						=> '',
 	'social_flickr'							=> '',
 	'social_tumblr'							=> '',
 	'social_deviantart'						=> '',
 	'social_dribbble'						=> '',
 	'social_myspace'						=> '',
 	'social_wordpress'						=> '',
 	'social_rss'							=> '',
 	'social_delicious'						=> '',
 	'social_lastfm'							=> '',
	'social_instagram'						=> '',
	'social_github'							=> '',
	'social_vkontakte'						=> '',
	'social_myworld'						=> '',
	'social_odnoklassniki'					=> '',
	'social_goodreads'						=> '',
	'social_skype'							=> '',
	'social_soundcloud'						=> '',
	'social_email'							=> '',
	'social_contact'						=> '',
	'social_xing'							=> '',
	'social_meetup'							=> '',
	'footer_code'							=> '<div class="copyright">'. esc_attr__( 'Copyright', 'adventurous' ) . ' &copy; ' . adventurous_the_year() . '&nbsp;' . adventurous_site_link() . '&nbsp;' . esc_attr__( 'All Rights Reserved', 'adventurous' ) . '.</div><div class="powered">'. esc_attr__( 'Adventurous Theme by', 'adventurous' ) . '&nbsp;' . adventurous_shop_link() . '</div>',
	'reset_footer'							=> '2'
);
global $adventurous_options_settings;
$adventurous_options_settings = adventurous_options_set_defaults( $adventurous_options_defaults );

function adventurous_options_set_defaults( $adventurous_options_defaults ) {
	$adventurous_options_settings = array_merge( $adventurous_options_defaults, (array) get_option( 'adventurous_options', array() ) );
	return $adventurous_options_settings;
}

/**
 * Returns the current year.
 *
 * @uses date() Gets the current year.
 * @return string
 */
function adventurous_the_year() {
	return date( __( 'Y', 'adventurous' ) );
}


/**
 * Returns a link back to the site.
 *
 * @uses get_bloginfo() Gets the site link
 * @return string
 */
function adventurous_site_link() {
	return '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" ><span>' . get_bloginfo( 'name', 'display' ) . '</span></a>';
}


/**
 * Returns a link to Theme Shop.
 *
 * @return string
 */
function adventurous_shop_link() {
	return '<a href="'. esc_url( __( 'http://catchthemes.com', 'adventurous' ) ) . '" target="_blank" title="' . esc_attr__( 'Catch Themes', 'adventurous' ) . '"><span>' . __( 'Catch Themes', 'adventurous' ) . '</span></a>';
}


/**
 * Returns an array of color schemes registered for adventurous.
 *
 * @since Adventurous 1.6.2
 */
function adventurous_color_schemes() {
	$options = array(
		'light' 		=> __( 'Light (Blue)', 'adventurous' ),
		'dark'			=> __( 'Dark', 'adventurous' ),
		'lightblack'	=> __( 'Light (Black)', 'adventurous' ),
	);

	return apply_filters( 'adventurous_color_schemes', $options );
}


/**
 * Returns an array of featured content layout options
 *
 * @since Adventurous 1.6.2
 */
function adventurous_featured_content_layouts() {
	$options = array(
		'three-columns' => __( '3 Columns', 'adventurous' ),
		'four-columns'	=> __( '4 Columns', 'adventurous' ),
	);

	return apply_filters( 'adventurous_featured_content_layouts', $options );
}


/**
 * Returns an array of enable header image options
 *
 * @since Adventurous 1.6.2
 */
function adventurous_enable_header_featured_image() {
	$options = array(
		'homepage' 		=> __( 'Homepage', 'adventurous' ),
		'excludehome' 	=> __( 'Excluding Homepage', 'adventurous' ),
		'allpage' 		=> __( 'Entire Site', 'adventurous' ),
		'postpage' 		=> __( 'Entire Site, Page/Post Featured Image', 'adventurous' ),
		'pagespostes'	=> __( 'Pages & Posts', 'adventurous' ),
		'disable'		=> __( 'Disable', 'adventurous' ),
	);

	return apply_filters( 'adventurous_enable_header_featured_image', $options );
}


/**
 * Returns an array of page/post featured image size
 *
 * @since Adventurous 1.6.2
 */
function adventurous_page_post_featured_image_size() {
	$options = array(
		'full' 		=> __( 'Full Image', 'adventurous' ),
		'slider' 	=> __( 'Slider Image', 'adventurous' ),
		'featured'	=> __( 'Featured Image', 'adventurous' ),		
	);

	return apply_filters( 'adventurous_page_post_featured_image_size', $options );
}


/**
 * Returns an array of content featured image size
 *
 * @since Adventurous 1.6.2
 */
function adventurous_content_featured_image_size() {
	$options = array(
		'full' 		=> __( 'Full Image', 'adventurous' ),
		'slider' 	=> __( 'Slider Image', 'adventurous' ),
		'featured'	=> __( 'Featured Image', 'adventurous' ),
		'disable'	=> __( 'Disable Image', 'adventurous' ),		
	);

	return apply_filters( 'adventurous_content_featured_image_size', $options );
}


/**
 * Returns an array of sidebar layout options
 *
 * @since Adventurous 1.6.2
 */
function adventurous_sidebar_layout_options() {
	$options = array(
		'right-sidebar' => __( 'Right Sidebar', 'adventurous' ),
		'left-sidebar' 	=> __( 'Left Sidebar', 'adventurous' ),
		'no-sidebar'	=> __( 'No Sidebar', 'adventurous' ),
	);

	return apply_filters( 'adventurous_sidebar_layout_options', $options );
}


/**
 * Returns an array of slider enable options
 *
 * @since Adventurous 1.6.2
 */
function adventurous_enable_featured_content_options() {
	$options = array(
		'homepage'=> __( 'Homepage', 'adventurous' ),
		'allpage' => __( 'Entire Site', 'adventurous' ),
		'disable' => __( 'Disable', 'adventurous' ),
	);

	return apply_filters( 'adventurous_enable_slider_options', $options );
}


/**
 * Returns an array of content layout options
 *
 * @since Adventurous 1.6.2
 */
function adventurous_content_layout_options() {
	$options = array(
		'full' 		=> __( 'Full Content Display', 'adventurous' ),
		'excerpt' 	=> __( 'Excerpt/Blog Display', 'adventurous' ),
	);

	return apply_filters( 'adventurous_content_layout_options', $options );
}


/**
 * Returns an array of slider types
 *
 * @since Adventurous 1.6.2
 */
function adventurous_slider_types() {
	$options = array(
		'demo-slider' 		=> __( 'Demo Slider', 'adventurous' ),
		'post-slider' 		=> __( 'Post Slider', 'adventurous' ),
		'category-slider' 	=> __( 'Category Slider', 'adventurous' ),
	);

	return apply_filters( 'adventurous_slider_types', $options );
}


/**
 * Returns an array of slider enable options
 *
 * @since Adventurous 1.6.2
 */
function adventurous_enable_slider_options() {
	$options = array(
		'enable-slider-homepage'=> __( 'Homepage', 'adventurous' ),
		'enable-slider-allpage' => __( 'Entire Site', 'adventurous' ),
		'disable-slider' 		=> __( 'Disable', 'adventurous' ),
	);

	return apply_filters( 'adventurous_enable_slider_options', $options );
}


/**
 * Returns an array of slider transition effects
 *
 * @since Adventurous 1.6.2
 */
function adventurous_transition_effects() {
	$options = array(
		'fade'			=> __( 'fade', 'adventurous' ),
		'wipe' 			=> __( 'wipe', 'adventurous' ),
		'scrollUp' 		=> __( 'scrollUp', 'adventurous' ),
		'scrollDown'	=> __( 'scrollDown', 'adventurous' ),
		'scrollUp' 		=> __( 'scrollUp', 'adventurous' ),
		'scrollLeft'	=> __( 'scrollLeft', 'adventurous' ),
		'scrollRight'	=> __( 'scrollRight', 'adventurous' ),
		'blindX' 		=> __( 'blindX', 'adventurous' ),
		'blindY' 		=> __( 'blindY', 'adventurous' ),
		'blindZ' 		=> __( 'blindZ', 'adventurous' ),
		'cover' 		=> __( 'cover', 'adventurous' ),
		'shuffle' 		=> __( 'shuffle', 'adventurous' ),
	);

	return apply_filters( 'adventurous_transition_effects', $options );
}
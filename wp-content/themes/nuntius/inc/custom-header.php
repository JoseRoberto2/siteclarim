<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php $header_image = get_header_image();
	if ( ! empty( $header_image ) ) { ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
		</a>
	<?php } // if ( ! empty( $header_image ) ) ?>

 *
 * @package Nuntius
 * @since Nuntius 1.0
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * @uses nuntius_header_style()
 * @uses nuntius_admin_header_style()
 * @uses nuntius_admin_header_image()
 *
 * @package Nuntius
 */
function nuntius_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'nuntius_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => 'fff',
		'width'                  => 980,
		'height'                 => 155,
		'flex-height'            => true,
		'wp-head-callback'       => 'nuntius_header_style',
		'admin-head-callback'    => 'nuntius_admin_header_style',
		'admin-preview-callback' => '',
	) ) );

	add_action( 'admin_print_styles-appearance_page_custom-header', 'nuntius_fonts' );
}
add_action( 'after_setup_theme', 'nuntius_custom_header_setup' );

/**
 * Shiv for get_custom_header().
 *
 * get_custom_header() was introduced to WordPress
 * in version 3.4. To provide backward compatibility
 * with previous versions, we will define our own version
 * of this function.
 *
 * @todo Remove this function when WordPress 3.6 is released.
 * @return stdClass All properties represent attributes of the curent header image.
 *
 * @package Nuntius
 * @since Nuntius 1.1
 */

if ( ! function_exists( 'get_custom_header' ) ) {
	function get_custom_header() {
		return (object) array(
			'url'           => get_header_image(),
			'thumbnail_url' => get_header_image(),
			'width'         => HEADER_IMAGE_WIDTH,
			'height'        => HEADER_IMAGE_HEIGHT,
		);
	}
}

if ( ! function_exists( 'nuntius_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see nuntius_custom_header_setup().
 *
 * @since Nuntius 1.0
 */
function nuntius_header_style() {
	// If no custom options for text are set, let's bail
	if ( HEADER_TEXTCOLOR == get_header_textcolor() && '' == get_header_image() )
		return;
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Do we have a custom header image?
		if ( '' != get_header_image() ) :
	?>
		#header .wrap {
			background: url(<?php header_image(); ?>) no-repeat;
			width: 980px;
			height: 155px;
		}
		#site-title {
			margin: 48px 12px 0;
		}
	<?php
		endif;

		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
		#site-title {
 	 		position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		#site-title a {
			background: none !important;
			border: 0 !important;
			color: #<?php echo get_header_textcolor(); ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // nuntius_header_style

if ( ! function_exists( 'nuntius_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see nuntius_custom_header_setup().
 *
 * @since Nuntius 1.0
 */
function nuntius_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		background-color: #<?php echo ( '' != get_background_color() ? get_background_color() : '800000' ); ?>;
		border: none;
		width: 980px;
		height: 155px;
		text-align: left;
	}
	#headimg h1 {
		float: left;
		font-family: 'Lobster', Georgia, serif;
		font-size: 48px;
		font-weight: normal;
		line-height: 48px;
		margin: 45px 0 0 35px;
		padding: 10px;
	}
	#headimg h1 a {
		color: #fff;
		text-decoration: none;
	}
	#desc {
		display: none;
	}
	<?php
		// If the user has set a custom color for the text use that
		if ( HEADER_TEXTCOLOR != get_header_textcolor() ) :
	?>
		#site-title a {
			color: #<?php echo get_header_textcolor(); ?>;
		}
	<?php endif; ?>
	</style>
<?php
}
endif; // nuntius_admin_header_style
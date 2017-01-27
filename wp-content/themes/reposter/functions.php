<?php

if ( ! isset( $content_width ) ) {
	$content_width = 940;
}

/*Theme setup*/
function reposter_setup() {

	$defaults = array(
		'default-image'          => '',
		'random-default'         => false,
		'width'                  => 940,
		'height'                 => 268,
		'flex-height'            => false,
		'flex-width'             => false,
		'default-text-color'     => 'f47b56',
		'header-text'            => true,
		'uploads'                => true,
		'wp-head-callback'       => '',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
	);

	add_theme_support( 'custom-header', $defaults );

	load_theme_textdomain( 'reposter', get_template_directory() . '/languages' );
	/*add menu support*/
	register_nav_menu( 'main', 'main-menu' );
	add_theme_support( 'automatic-feed-links' );
	/*custom background*/
	$args = array(
		'default-color' => '000',
		'default-image' => get_template_directory_uri() . '/images/bg.png',
	);
	/*add custom background*/
	add_theme_support( 'custom-background', $args );
	add_filter( 'image_size_names_choose', 'reposter_custom_image_sizes' );
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'size-thumb', 940, 268, true );
	add_theme_support( 'title-tag' );
	add_editor_style();
}

/*Register sidebar*/
function reposter_register_sidebar() {
	register_sidebar( array(
			'name'          => __( 'Sidebar', 'reposter' ),
			'id'            => 'reposter_sidebar',
			'before_widget' => '<aside id="%1$s" class="widgets %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
		)
	);
}

/*Scripts/styles*/
function reposter_scripts() {
	if ( is_singular() ) {
		wp_enqueue_script( 'comment-reply' );
	}
	wp_enqueue_script( 'reposter-scripts', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ), '1.1', true );
	$string_js = array(
		'buttonFile'   => __( 'Choose file...', 'reposter' ),
		'noFile' => __( 'No file chosen...', 'reposter' ),
		'noImage' => __( 'You forgot to upload an image!', 'reposter' ),
	);
	wp_localize_script( 'reposter-scripts', 'reposterStringJs', $string_js );
	wp_enqueue_style( 'reposter-style', get_stylesheet_uri() );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'reposter-flex-slider', get_template_directory_uri() . '/js/flexslider.min.js', array( 'jquery' ), false, true );
}

/*Add home menu to nav menu*/
function reposter_home_page_menu_args( $args ) {
	$args['show_home'] = true;

	return $args;
}

/*Function excerpt*/
function reposter_new_excerpt_length( $length ) {
	return 20;
}

/*Add metaboxes*/
function reposter_add_custom_box() {
	add_meta_box( 'reposter_section_slider', __( 'Slide settings', 'reposter' ), 'reposter_custom_box', 'post' );
	add_meta_box( 'reposter_section_slider', __( 'Slide settings', 'reposter' ), 'reposter_custom_box', 'page' );
}

/*Custom images size*/
function reposter_custom_image_sizes( $sizes ) {
	$custom_sizes = array(
		'featured-image' => 'Featured Image',
	);

	return array_merge( $sizes, $custom_sizes );
}

/*Create Custom metabox*/
function reposter_custom_box() {
	global $post;
	$screen = get_current_screen(); ?>
	<input type='checkbox' name='add_slide' id='add_slide' value='on' <?php if ( 'on' == get_post_meta( $post->ID, 'add_slide', true ) ) { ?> checked='checked' <?php } ?> />
	<label for='add_slide'><?php echo __( 'Display this ', 'reposter' ) . $screen->post_type . __( ' in slider', 'reposter' ); ?></label>
	<p><?php _e( 'Use image by size 940x268. If your image size is bigger than 940x268, you need upload image again and WordPress will crop your image for needed size.', 'reposter' ); ?> </p>
<?php }

/*Save metabox*/
function reposter_save_post() {
	global $post, $post_id;

	if ( wp_is_post_revision( $post_id ) ) {
		return $post_id;
	}

	if ( null != $post ) {
		if ( ( isset( $_POST['add_slide'] ) ) && ( 'on' == $_POST['add_slide'] ) ) {
			update_post_meta( $post->ID, 'add_slide', $_POST['add_slide'] );
		} else {
			update_post_meta( $post->ID, 'add_slide', 'off' );
		}
	}
}

/*Add pictures upload support*/
function reposter_featured_img_title() {
	global $post;
	$thumbnail_id    = get_post_thumbnail_id( $post->ID );
	$thumbnail_image = get_posts( array(
		'p'           => $thumbnail_id,
		'post_type'   => 'attachment',
		'post_status' => 'any',
	) );
	if ( $thumbnail_image && isset( $thumbnail_image[0] ) ) {
		return '<p>' . $thumbnail_image[0]->post_title . '</p>';
	}
}

/*Navigation breadcrumbs*/
function reposter_the_breadcrumb() {
	global $post;
	_e( 'VOCÊ ESTÁ AQUI: ', 'reposter' );
	if ( ! is_front_page() ) { ?>
		<a href='<?php echo home_url(); ?>'><?php _e( 'Home', 'reposter' ); ?></a> -
		<span class='reposter_grey_serif'></span>
		<?php if ( is_category() || is_single() ) {
			if ( is_single() ) {
				if ( isset( $_GET['page'] ) && ! empty( $_GET['page'] ) ) {
					echo the_title() . ' - ' . $_GET['page'];
				} elseif ( is_attachment() ) {
					echo the_title();
				} else {
					echo ' - ' . the_category( ', ' ) . get_the_title();
				}
			} elseif ( is_category() ) {
				echo single_cat_title();
			}
		} elseif ( is_tag() ) {
			echo single_tag_title( '', false );
		} elseif ( is_page() ) {
			/*Reverse post ancestors if it has*/
			if ( $post->ancestors ) {
				$ancestors = array_reverse( $post->ancestors );
				for ( $i = 0; $i < count( $ancestors ); $i ++ ) {
					if ( 0 == $i ) {
						echo '<a href=' . get_permalink( $ancestors[ $i ] ) . '>' . get_the_title( $ancestors[ $i ] ) . '</a>' . ' - ';
					} else {
						echo '<a href=' . get_permalink( $ancestors[ $i ] ) . '>' . get_the_title( $ancestors[ $i ] ) . '</a>' . ' - ';
					}
				}
			} else {
				$ancestors = get_the_title();
			}
			/*Display elements of array as breadcrumbs*/
			echo get_the_title();
		} elseif ( is_search() ) {
			printf( __( 'RESULTADO PARA: %s', 'reposter' ), '<span class="reposter_orange">' . get_search_query() . '</span>' );
		} elseif ( is_archive() ) {
			if ( is_author() ) {
				echo the_category( ', ' ) . ' - ' . __( 'AUTOR DA PUBLICAÇÃO', 'reposter' );
			} else {
				echo the_category( ', ' ) . ' - ' . get_the_date( 'F Y' );
			}
		} elseif ( is_404() ) {
			_e( 'PÁGINA NÃO ENCONTRADA', 'reposter' );
		}
	} else { ?>
		<a href='<?php echo home_url(); ?>'><?php _e( 'Home', 'reposter' ); ?></a>
	<?php }
}

/*Comment function*/
function reposter_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' : ?>
			<li class='post pingback'>
				<p>
					<?php _e( 'Pingback:', 'reposter' );
					comment_author_link();
					edit_comment_link( __( 'Edit', 'reposter' ), '<span class="edit-link">', '</span>' ); ?>
				</p>
			</li>
			<?php break;
		default : ?>
			<li <?php comment_class(); ?> id='li-comment-<?php comment_ID(); ?>'>
				<article id='comment-<?php comment_ID(); ?>' class='comment'>
					<header class='comment-meta'>
						<div class='comment-author vcard'>
							<table>
								<tr>
									<td class='comment-info-avatar'>
										<?php $avatar_size = 68;
										if ( '0' != $comment->comment_parent ) {
											$avatar_size = 39;
										}
										echo get_avatar( $comment, $avatar_size ); ?>
									</td>
									<td class='comment-info'>
										<?php /*translators: 1: comment author, 2: date and time*/
										printf( __( '%1$s on %2$s said:', 'reposter' ),
											get_comment_author_link(),
											sprintf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
												esc_url( get_comment_link( $comment->comment_ID ) ),
												get_comment_time( 'c' ),
												/*translators: 1: date, 2: time*/
												sprintf( __( '%1$s at %2$s', 'reposter' ), get_comment_date(), get_comment_time() )
											)
										); ?>
									</td>
								</tr>
							</table>
						</div><!-- .comment-author .vcard -->
						<?php if ( '0' == $comment->comment_approved ) : ?>
							<p>
								<em class='comment-awaiting-moderation'><?php _e( 'Your comment is awaiting moderation.', 'reposter' ); ?></em>
							</p>
						<?php endif; ?>
					</header><!-- end .comment-meta -->
					<div class='comment-content'><?php comment_text(); ?></div>
					<?php edit_comment_link( __( 'Edit', 'reposter' ), '<span class="edit-link">', '</span>' ); ?>
					<div class='dnt_reply'>
						<?php comment_reply_link( array_merge( $args, array(
							'reply_text' => __( 'Reply', 'reposter' ) . ' &darr;',
							'depth'      => $depth,
							'max_depth'  => $args['max_depth'],
						) ) ); ?>
					</div><!-- .reply -->
					<div class='reposter_clear'></div>
				</article><!-- #comment-## -->
			</li>
			<?php break;
	endswitch;
}

/*Create Slider*/
function reposter_slider_template() {
	/*Query Arguments*/
	$args = array(
		'post_type'           => array( 'post', 'page' ),
		'posts_per_page'      => - 1,
		'meta_value'          => 'on',
		'meta_key'            => 'add_slide',
		'ignore_sticky_posts' => 1,
	);
	/*The Query*/
	$the_query = new WP_Query( $args );
	/*Check if the Query returns any posts*/
	if ( $the_query->have_posts() ) {
		/*Start the Slider*/ ?>
		<div id='reposter_main_slider'>
			<div class='flexslider'>
				<ul class='slides'>
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
						<li>
							<?php the_post_thumbnail( 'size-thumb' ); ?>
							<div class='opasity'>
								<div class='slider_box'>
									<h1 class='slider-title'><a href='<?php the_permalink(); ?>'><?php the_title(); ?></a></h1>
									<?php the_excerpt(); ?>
								</div><!--end .slider_box -->
							</div><!--end .opasity -->
						</li><!-- end li -->
					<?php endwhile;
					wp_reset_query(); ?>
				</ul><!-- end .slides -->
			</div><!-- end .flexslider -->
			<div class="clear"></div>
		</div><!-- end #main_slider -->
	<?php }

	/*Reset Post Data*/
	wp_reset_postdata();
}

/*Function for painting two first letter*/
function reposter_title_color_letters() {
	$blog_name = get_bloginfo( 'name' );
	/*excerpt first two letters*/
	$color_letters = substr( $blog_name, 0, 2 );
	/*excerpt all after two letters*/
	$blog_name_after = substr( $blog_name, 2, - 1 );
	/*excerpt last letter*/
	$last_letter = substr( $blog_name, - 1 );
	/*join all in one*/
	echo $blog_title = $color_letters . "<span class='site-header-color'>" . $blog_name_after . $last_letter . '</span>';
}

/*Function display header text*/
function reposter_display_header_text() { ?>
	<style type='text/css'>
		.reposter_site-title a, .reposter_site-description {
			<?php if ( get_header_textcolor() == 'blank' ) {
				echo 'visibility: hidden;';
			} else {
				echo 'color: #' . get_header_textcolor() . ';';
			} ?>
		}
	</style>
<?php }

/*color for description*/
function reposter_description_color() {
	echo "<span class='reposter_site-description'>" . get_bloginfo( 'description' ) . '</span>';
}

add_action( 'after_setup_theme', 'reposter_setup' );
add_action( 'widgets_init', 'reposter_register_sidebar' );
add_action( 'wp_enqueue_scripts', 'reposter_scripts' );
add_filter( 'wp_page_menu_args', 'reposter_home_page_menu_args' );
add_filter( 'excerpt_length', 'reposter_new_excerpt_length' );
add_action( 'add_meta_boxes', 'reposter_add_custom_box' );
add_action( 'save_post', 'reposter_save_post' );

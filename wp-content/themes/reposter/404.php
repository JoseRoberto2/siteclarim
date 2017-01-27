<?php
/**
 * The template for displaying the 404 page.
 *
 */
get_header(); ?>
	<div id='reposter_width'>
		<div id='reposter_main' class='wrapper'>
			<?php if ( get_header_image() != '' ) { ?>
				<div id='reposter_header-image'>
					<img src='<?php header_image(); ?>' alt='' />
				</div>
			<?php } ?>
			<div id='reposter_main_content'>
				<section id='reposter_left-side'>
					<article id='post-<?php the_ID(); ?>' class='post'>
						<div class='reposter_cont'>
							<h1><?php _e( 'Error 404', 'reposter' ); ?></h1>
							<h2><?php _e( 'The page you have requested has flown the coop.', 'reposter' ); ?></h2>
							<h2><?php _e( 'Perhaps you are here because:', 'reposter' ); ?></h2>
							<ul>
								<li><?php _e( 'The page has moved', 'reposter' ); ?></li>
								<li><?php _e( 'The page no longer exists', 'reposter' ) ?></li>
								<li><?php _e( 'You were looking for your puppy and got lost', 'reposter' ); ?></li>
								<li><?php _e( 'You like 404 pages', 'reposter' ); ?></li>
							</ul>
							<div id='reposter_search' class='reposter_widget_search'><?php get_search_form(); ?></div>
						</div><!--end .reposter_cont-->
					</article><!--end .post-->
				</section><!--end #left-side-->
				<?php get_sidebar(); ?>
			</div><!--end #reposter_main_content-->
			<div class='reposter_clear'></div>
		</div><!--end #reposter_main-->
	</div><!--end #reposter_width-->
<?php get_footer();

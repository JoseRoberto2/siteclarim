<?php
/**
 * The template for displaying single page.
 *
 */
get_header() ?>
	<div id='reposter_width'>
		<div id='reposter_main' class='wrapper'>
			<?php if ( get_header_image() != '' ) { ?>
				<div id='reposter_header-image'>
					<img src='<?php header_image(); ?>' alt='' />
				</div>
			<?php } ?>
			<div id='reposter_title'>
				<div id='reposter_article_head'>
					<p><?php reposter_the_breadcrumb(); ?></p><!--breadcrumbs-->
				</div>
				<div id='reposter_search' class='reposter_widget_search'><?php get_search_form(); ?><!-- enable search form --></div>
			</div><!--end #reposter_title-->
			<hr />
			<div id='reposter_main_content'>
				<section id='reposter_left-side'>
					<?php $i = 0;
					if ( have_posts() ) :
						while ( have_posts() ) : the_post();
							$i ++ ?>
							<article id='post-<?php the_ID(); ?>' <?php post_class(); ?>>
								<div class='reposter_cont'>
									<p class='entry-title'>
										<?php the_title(); ?>
									</p>
									<div class='entry-meta'>
										<?php _e( 'PUBLICADO EM', 'reposter' ) ?>
										<span class='reposter_orange'><a href="<?php echo get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ); ?>"><?php the_date(); ?></a></span>
										<?php //if ( has_category() ) {
											//_e( 'in', 'reposter' ); ?>
											<!--span class='reposter_orange'><?php //the_category( ', ' ); ?></span-->
										<?php //}
										_e( ' AUTOR: ', 'reposter' ); ?>
										<span class='reposter_orange'><?php the_author_posts_link(); ?></span>
										<?php edit_post_link( __( '| Edit', 'reposter' ) ); ?>
									</div><!-- end .entry-meta -->
									<!--post image-->
									<?php if ( has_post_thumbnail() ) {
										echo "<div class='featured-image'>" . get_the_post_thumbnail() . "</div><div class='featured-image-title'>" . reposter_featured_img_title() . '</div>';
									}
									if ( wp_attachment_is_image() ) {
										echo "<div class='previous-image'>";
										previous_image_link( false, __( '&larr; Previous', 'reposter' ) );
										echo "</div><div class='next-image'>";
										next_image_link( false, __( 'Next &rarr;', 'reposter' ) );
										echo '</div>';
									}
									the_content();
									wp_link_pages(); ?>
									<div id='nav-below' class='navigation'><!--pages navigation-->
										<div class='nav-previous'><?php previous_post_link( '%link', "<span class='meta-nav'>" . _x( '&larr;', 'LINK ANTERIOR', 'reposter' ) . '</span> %title' ); ?></div>
										<div class='nav-next'><?php next_post_link( '%link', "%title <span class='meta-nav'>" . _x( '&rarr;', 'PRÓXIMO LINK', 'reposter' ) . '</span>' ); ?></div>
									</div><!-- #nav-below -->
									<div class='reposter_clear'></div>
									<!--post comments-->
									<?php comments_template( '', true ); ?>
								</div><!--end .reposter_cont-->
								<!--posts navigation-->
								<?php if ( has_tag() ) : ?>
									<div class='tags'><?php the_tags(); ?></div>
								<?php endif; ?>
								<div class='reposter_back-top'>
									<span class='reposter_orange'><a href='javascript:scroll( 0,0 );'><?php _e( '[Top]', 'reposter' ); ?></a></span>
								</div>
							</article><!--end #post-->
						<?php endwhile;
					endif; ?>
				</section><!--end #reposter_left-side-->
				<?php get_sidebar(); ?>
			</div><!--end #reposter_main_content-->
		</div><!--end #reposter_main-->
		<div class='reposter_clear'></div>
	</div><!--end #reposter_width-->
<?php get_footer();

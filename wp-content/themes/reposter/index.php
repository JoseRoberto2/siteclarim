<?php
/**
 * The main page template.
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
				<p><?php reposter_the_breadcrumb(); ?></p>
			</div>
			<div id='reposter_search' class='reposter_widget_search'><?php get_search_form(); ?></div>
		</div><!--end #reposter_title-->
		<hr />
		<div id='reposter_slider'>
			<?php reposter_slider_template(); ?>
		</div>
		<div id='reposter_main_content'>
			<section id='reposter_left-side'>
				<?php $i = 0;
				if ( have_posts() ) {
					while ( have_posts() ) : the_post();
						$i ++ ?>
						<article id='post-<?php the_ID(); ?>' <?php post_class(); ?>>
							<div class='reposter_cont'>
								<!--post title url-->
								<p class='entry-title'>
									<a href='<?php the_permalink(); ?>'><?php the_title(); ?></a>
								</p>
								<!--categories and date of posts-->
								<div class='entry-meta'>
									<?php _e( 'PUBLICADO EM ', 'reposter' ) ?>
									<span class='reposter_orange'>
										<a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a>
									</span>
									<?php //if ( has_category() ) {
										//_e( 'in', 'reposter' ); ?>
										<!--span class='reposter_orange'><?php //the_category( ', ' ); ?></span-->
									<?php //}
									_e( ' AUTOR: ', 'reposter' ); ?>
									<span class='reposter_orange'><?php the_author_posts_link(); ?></span>
									<?php edit_post_link( __( '| Edit', 'reposter' ) ); ?>
								</div><!-- end .entry-meta -->
								<?php if ( has_post_thumbnail() ) {
									echo "<div class='featured-image'>" . get_the_post_thumbnail() . "</div><div class='featured-image-title'>" . reposter_featured_img_title() . '</div>';
								}
								the_content();
								comments_template( '', true ); ?>
								<?php wp_link_pages(); ?>
							</div><!--end .reposter_cont-->
							<!--tags-->
							<?php if ( has_tag() ) { ?>
								<div class='tags'><?php the_tags( __( 'Tags: ', 'reposter' ) ); ?></div><!--styling tags-->
							<?php } else { ?><!--else tags block empty-->
								<div></div>
							<?php } ?>
							<div class='reposter_back-top'><!--scrolling top-->
								<span class='reposter_orange'><a href='javascript:scroll( 0,0 );'><?php _e( '[Top]', 'reposter' ); ?></a></span>
							</div>
							<div class='reposter_clear'></div>
						</article><!--end #post-->
					<?php endwhile;
				} ?>
				<nav id='reposter_nav-pages'>
					<div id='pre-page'><?php previous_posts_link(); ?></div>
					<div id='next-page'><?php next_posts_link(); ?></div>
				</nav><!--end #reposter_nav-pages-->
			</section><!--end #reposter_left-side-->
			<?php get_sidebar(); ?>
		</div><!--end #reposter_main_content-->
		<div class='reposter_clear'></div>
	</div><!-- end #reposter_main -->
</div><!-- end #reposter_width -->
<?php get_footer();

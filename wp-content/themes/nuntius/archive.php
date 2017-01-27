<?php
/**
 * This is the template for displaying Archives
 *
 * @package Nuntius
 * @since Nuntius 1.0
 */

get_header(); ?>

<div id="content">
	<div id="content-inner" class="hfeed">

		<?php if ( have_posts() ) : ?>

		<div class="archive-header">
			<h1 class="archive-title">
				<?php if ( is_day() ) : ?>
					<?php printf( __( 'Archive | %s', 'nuntius' ), get_the_date() ); ?>
				<?php elseif ( is_month() ) : ?>
					<?php printf( __( 'Archive | %s', 'nuntius' ), get_the_date( 'F Y' ) ); ?>
				<?php elseif ( is_year() ) : ?>
					<?php printf( __( 'Archive | %s', 'nuntius' ), get_the_date( 'Y' ) ); ?>
				<?php elseif ( is_author() ) : ?>
					<?php printf( __( '%s', 'nuntius' ), get_the_author() ); ?>
				<?php elseif ( is_category() ) : ?>
					<?php printf( __( '%s', 'nuntius' ), single_cat_title( '', false) ); ?>
				<?php elseif ( is_tag() ) : ?>
					<?php printf( __( 'Tag Archive | %s', 'nuntius' ), single_tag_title( '', false ) ); ?>
				<?php else :
					_e( 'Archives', 'new' ); ?>
				<?php endif; ?>
			</h1>

			<?php if ( is_day() || is_month() || is_year() ) : ?>
				<div class="archive-description">
					<p><?php _e( 'You are browsing the site archives by date.', 'nuntius' ); ?></p>
				</div><!-- .archive-description -->
			<?php endif; ?>
		</div><!-- .archive-header -->

		<?php rewind_posts(); ?>

		<?php /* Start the Loop */ ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'archive' ); ?>

		<?php endwhile; ?>

		<?php endif; ?>

	</div><!-- .hfeed -->

	<?php nuntius_content_nav( 'nav-below' ); ?>

</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
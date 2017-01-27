<?php
/**
 * @package Nuntius
 */
?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( sprintf( __( 'Permanent Link to %s', 'nuntius' ), the_title_attribute( 'echo=0' ) ) ); ?>">
		<?php the_post_thumbnail( 'nuntius-thumbnail', array( 'class' => 'nuntius-thumbnail', 'alt' => get_the_title(), 'title' => get_the_title() ) ); ?>
	</a>

	<h2 class="entry-title">
		<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
	</h2><!-- .entry-title -->

	<div class="byline">

		<?php nuntius_archive_post_meta(); ?>

		<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'nuntius' ), __( '1 Comment', 'nuntius' ), __( '% Comments', 'nuntius' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'nuntius' ), '<span class="edit-link">', '</span>' ); ?>

	</div><!-- .byline -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
		<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'nuntius' ), 'after' => '</p>' ) ); ?>
	</div><!-- .entry-summary -->

</div><!-- #post-## -->
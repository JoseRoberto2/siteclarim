<?php
/**
 * The template for displaying the comments.
 *
 */
?>
<div id='comments'>
	<?php if ( post_password_required() ) : ?>
		<p class='nopassword'><?php _e( 'This post is password protected. Enter the password to view any comments.', 'reposter' ); ?></p>

		<?php return;
	endif;

	if ( have_comments() ) : ?>
		<h2 id='comments-title'><?php printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'reposter' ), number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' ); ?></h2>

		<ol class='commentlist'>
			<?php wp_list_comments( array( 'callback' => 'reposter_comment' ) ); ?>
		</ol>

		<?php if ( 1 < get_comment_pages_count() && get_option( 'page_comments' ) ) : /*are there comments to navigate through*/ ?>
			<nav id='comment-nav-below'>
				<div class='nav-previous'><?php previous_comments_link( __( '&larr; Older Comments', 'reposter' ) ); ?></div>
				<div class='nav-next'><?php next_comments_link( __( 'Newer Comments &rarr;', 'reposter' ) ); ?></div>
				<div class='reposter_clear'></div>
			</nav><!-- end #comment-nav-below -->
		<?php endif;

		#Closed comments
		if ( ! comments_open() && get_comments_number() ) : ?>
			<p class='nocomments'><?php _e( 'Comments are closed.', 'reposter' ); ?></p>
		<?php endif;

	endif;

	comment_form(); ?>

</div><!-- #comments -->

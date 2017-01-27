<?php
/**
 * The template for displaying the sidebar.
 *
 */
?>
<section id='reposter_right-side'>
	<?php
	 	
	 	if ( is_active_sidebar( 'reposter_sidebar' ) ) {
		dynamic_sidebar( 'reposter_sidebar' );
	} else { ?>
		<aside id='primary' class='widget-area'>
			<div class='widgets'>
				<h3><?php _e( 'Archives', 'reposter' ); ?></h3>
				<ul class='no-widgets'>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</div><!-- end .widgets -->
		</aside><!-- end .widget-area -->
	<?php } 	?>
</section>

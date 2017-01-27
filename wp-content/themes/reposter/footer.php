<?php
/**
 * The template for displaying the footer.
 *
 */
?>
<div class='reposter_whitespace'>
	<div id='reposter_footer'>
		<div>
			<h1 class='reposter_site-footer'>&copy; <?php echo date_i18n( 'Y' ) . ' ' . get_bloginfo( 'name' ); ?></h1>
		</div>
		<div id='reposter_footer_end' class='reposter_foot'>
			<div>
			
				<!--<p>
					<span class='reposter_grey_serif'><?php //_e( 'Powered by', 'reposter' ); ?></span>
					<span class='reposter_orange'>
						<a href="<?php //echo esc_url( wp_get_theme()->get( 'AuthorURI' ) ); ?>">BestWebLayout</a>
					</span>
					<span class='reposter_grey_serif'><?php //_e( 'and', 'reposter' ); ?></span>
					<span class='reposter_orange'>
						<a href="<?php //echo esc_url( 'http://wordpress.org/' ); ?>">WordPress</a>
					</span>
				</p><!-end p-->
				<p>
				<span class='reposter_orange'>Jornalista Waldilene Farias</span>
				</p>
			</div>
		</div><!--end #reposter_footer_end-->
	</div><!--end #reposter_footer-->
</div><!--end .reposter_whitespace-->
<?php wp_footer(); ?>
</body>
</html>

<form class='searchform' action='<?php echo esc_url( home_url( '/' ) ); ?>' method='get'>
	<div>
		<input type='text' name='s' class='search-box' placeholder='<?php esc_attr_e( 'Digite', 'reposter' ); ?>' value="<?php the_search_query(); ?>" />
		<input type='submit' class='search-button' value='<?php _e( 'PESQUISA', 'reposter' ); ?>' />
	</div>
</form>
<div class='reposter_clear'></div>

<?php
/**
 * @package TA Pluton
 *
 * Search Form Template
 */
?>
 
<form method="get" class="form-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="row">
		<div class="col-xs-12">
			<div class="input-group">
				<input type="text" class="form-control search-query" name="s" placeholder="<?php esc_attr_e( 'search here &hellip;', 'ta-pluton' ); ?>" />
				<span class="input-group-btn">
					<button type="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'search', 'ta-pluton' ); ?>"><?php _e( 'Search', 'ta-pluton' ); ?></button>
				</span>
			</div>
		</div>
	</div>
</form>
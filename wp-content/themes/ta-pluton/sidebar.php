<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package TA Pluton
 */

if ( ! is_active_sidebar( 'sidebar-right' ) ) {
	return;
}
?>

		<div id="secondary" class="col-md-4" role="complementary">
			<?php dynamic_sidebar( 'sidebar-right' ); ?>
		</div><!-- #secondary -->

	</div> <!-- .row -->
</div> <!-- .container -->
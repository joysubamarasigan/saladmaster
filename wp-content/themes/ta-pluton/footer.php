<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package TA Pluton
 */
?>

	</div><!-- #content -->

	<footer id="colophon" role="contentinfo">
		<div class="footer">
			<p><?php if ( ta_option( 'custom_copyright' ) != '') : echo ta_option( 'custom_copyright' ); ?><?php endif; ?></p>
        </div>
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

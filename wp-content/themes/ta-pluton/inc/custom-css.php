<?php
/**
 * Adds custom CSS to the wp_head() hook.
 *
 * @package WordPress
 * @subpackage TA Pluton
 */

if ( !function_exists( 'ta_custom_css' ) ) {

	add_action( 'wp_head', 'ta_custom_css' );
	function ta_custom_css() {

			$custom_css = '';

			if( ta_option( 'slider_backgound', false, 'url' ) != '' ) {
				$slider_backgound_url = ta_option( 'slider_backgound', false, 'url' );
				$custom_css .= '.da-slider {background: transparent url('.$slider_backgound_url.') repeat-x 0% center;}';
			}

			if( ta_option( 'client_backgound', false, 'url' ) != '' ) {
				$client_backgound_url = ta_option( 'client_backgound', false, 'url' );
				$custom_css .= '.client-bg {background: url('.$client_backgound_url.') no-repeat center;}';
			}

			if( ta_option( 'newsletter_backgound', false, 'url' ) != '' ) {
				$newsletter_backgound_url = ta_option( 'newsletter_backgound', false, 'url' );
				$custom_css .= '.newsletter-bg {background: url('.$newsletter_backgound_url.') no-repeat center;}';
			}

			if( ta_option( 'custom_css' ) != '' ) {
				$custom_css .= ta_option( 'custom_css' );
			}

			//Trim white space for faster page loading
			$custom_css_trimmed =  preg_replace( '/\s+/', ' ', $custom_css );

			//Echo CSS
			$css_output = "<!-- Custom CSS -->\n<style type=\"text/css\">\n" . $custom_css_trimmed . "\n</style>";

			if( !empty( $custom_css ) ) {
				echo $css_output;
			}
	}

}
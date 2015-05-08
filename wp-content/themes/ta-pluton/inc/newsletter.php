<?php
/**
 * Newsletter
 *
 * @package TA Pluton
 */

define( 'WP_USE_THEMES', false );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );

$api_key = ta_option( 'mailchimp_api_key' );
$list_id = ta_option( 'mailchimp_list_id' );

require( 'Mailchimp.php' );
$Mailchimp = new Mailchimp( $api_key );
$Mailchimp_Lists = new Mailchimp_Lists( $Mailchimp );
$subscriber = $Mailchimp_Lists->subscribe( $list_id, array( 'email' => htmlentities($_POST['subscribe-email']) ) );

if ( ! empty( $subscriber['leid'] ) ) {
   echo "success";
}
else {
	echo "fail";
}

?>
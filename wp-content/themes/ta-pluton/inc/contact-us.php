<?php
/**
 * Contact Us Form
 *
 * @package TA Pluton
 */

define( 'WP_USE_THEMES', false );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );

// Strips nasty tags from code..
function cleanEvilTags($data) {
	$data = preg_replace("/javascript/i", "j&#097;v&#097;script",$data);
	$data = preg_replace("/alert/i", "&#097;lert",$data);
	$data = preg_replace("/about:/i", "&#097;bout:",$data);
	$data = preg_replace("/onmouseover/i", "&#111;nmouseover",$data);
	$data = preg_replace("/onclick/i", "&#111;nclick",$data);
	$data = preg_replace("/onload/i", "&#111;nload",$data);
	$data = preg_replace("/onsubmit/i", "&#111;nsubmit",$data);
	$data = preg_replace("/<body/i", "&lt;body",$data);
	$data = preg_replace("/<html/i", "&lt;html",$data);
	$data = preg_replace("/document\./i", "&#100;ocument.",$data);
	$data = preg_replace("/<script/i", "&lt;&#115;cript",$data);
	return strip_tags(trim($data));
}

// Cleans output data..
function cleanData($data) {
	$data = str_replace(' & ', ' &amp; ', $data);
	return (get_magic_quotes_gpc() ? stripslashes($data) : $data);
}

function multiDimensionalArrayMap($func,$arr) {
	$newArr = array();
	if (!empty($arr)) {
		foreach($arr AS $key => $value) {
		$newArr[$key] = (is_array($value) ? multiDimensionalArrayMap($func,$value) : $func($value));
		}
	}
  return $newArr;
}

if (!empty($_POST)){

	$data['success'] = true;
	$_POST  = multiDimensionalArrayMap('cleanEvilTags', $_POST);
	$_POST  = multiDimensionalArrayMap('cleanData', $_POST);

	//your email address 
	$emailTo = ta_option( 'contact_email' );

	//email subject
	$emailSubject = "Website Contact Form";

	$name = $_POST["name"];
	$email = $_POST["email"];
	$comment = $_POST["comment"];
	if($name == "")
		$data['success'] = false;

	if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
		$data['success'] = false;
	}

	if($comment == "")
		$data['success'] = false;

	if($data['success'] == true){

	$message = "You have received a new message. Here are the details:<br><br>
	Name: $name<br><br>
	Email: $email<br><br>
	Message:<br>$comment";

	$headers = "MIME-Version: 1.0" . "\r\n"; 
	$headers .= "Content-type:text/html; charset=utf-8" . "\r\n"; 
	$headers .= "Reply-To: $email";
	wp_mail( $emailTo, $emailSubject, $message, $headers );

	$data['success'] = true;
	echo json_encode( $data );
	}
}
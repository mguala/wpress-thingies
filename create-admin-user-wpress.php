<?php
/*
 * Create Admin User
 */
 
$jb_password = 'PASSWORD'; #enter your desired password here, if you don't line 16 makes sure nothing bad happens like setting you actual password to 'PASSWORD'
$jb_username = '9seedsJB';
$jb_email = 'jb@9seeds.com';
 
if ( $jb_password === 'PASSWORD' )
	die;
 
require_once('wp-blog-header.php');
 
 
if ( !username_exists($jb_username) && !email_exists($jb_email) ) {
	$user_id = wp_create_user( $jb_username, $jb_password, $jb_email);
 
	if ( is_int($user_id) ) {
	  $wp_user_object = new WP_User($user_id);
	  $wp_user_object->set_role('administrator');
	  echo 'Success!';
	} else {
	  echo 'Error with wp_insert_user. No users were created.';
	}
} else {
	echo 'This user or email already exists. Nothing was done.';
}
